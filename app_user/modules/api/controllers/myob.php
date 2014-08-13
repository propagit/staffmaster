<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: MYOB API
 */

class Myob extends MX_Controller {
	
	var $cloud_api_url = 'https://api.myob.com/accountright/';
	var $api_key;
	var $api_secret;
	var $company_id;
	
	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'libraries/myob_api_oauth.php'); //includes nusoap
		$this->api_key = $this->config_model->get('myob_api_key');
		$this->api_secret = $this->config_model->get('myob_api_secret');
		$this->company_id = $this->config_model->get('myob_company_id');
	}
		
	function connect($function='')
	{	
		$access_token = $this->session->userdata('access_token');
		if ($access_token)
		{
			$expiry_time = time() + 600;
			if ($expiry_time > $this->session->userdata('access_token_expires'))
			{
				$oauth = new myob_api_oauth();
				$oauth_tokens = $oauth->refreshAccessToken($this->api_key, $this->api_secret, $this->session->userdata('refresh_token'));
				if ($oauth_tokens)
				{			
					$this->session->set_userdata('access_token', $oauth_tokens->access_token);
					$this->session->set_userdata('access_token_expires', time() + $oauth_tokens->expires_in);
					$this->session->set_userdata('refresh_token', $oauth_tokens->refresh_token);
					#$this->config_model->add(array(
					#	'key' => 'myob_refresh_token',
					#	'value' => $oauth_tokens->refresh_token
					#));
				}
				else
				{
					die("Error #1.");
				}
			}
		}
		else
		{
			if ($this->config_model->get('myob_refresh_token'))
			{
				$oauth = new myob_api_oauth();
				#var_dump($this->config_model->get('myob_refresh_token')); die();
				$oauth_tokens = $oauth->refreshAccessToken($this->api_key, $this->api_secret, $this->config_model->get('myob_refresh_token'));
				var_dump($oauth_tokens); die();
				if ($oauth_tokens)
				{			
					$this->session->set_userdata('access_token', $oauth_tokens->access_token);
					$this->session->set_userdata('access_token_expires', time() + $oauth_tokens->expires_in);
					$this->session->set_userdata('refresh_token', $oauth_tokens->refresh_token);
					$this->config_model->add(array(
						'key' => 'myob_refresh_token',
						'value' => $oauth_tokens->refresh_token
					));
				}
				else
				{
					die("Error #1.");
				}
			}
			else
			{
				$redirect_url = base_url() . 'api/myob/connect';
				$api_scope = 'CompanyFile';
				
				if (!isset($_GET['code']))
				{
					$url = "https://secure.myob.com/oauth2/account/authorize?client_id=" . $this->api_key . "&redirect_uri=" . urlencode($redirect_url) . "&response_type=code&scope=$api_scope";
					if ($function)
					{
						$url .= "&state=" . urlencode($function);
					}
					header("Location: $url");
				}
				$api_access_code = $_GET['code'];
				$oauth = new myob_api_oauth();
				$oauth_tokens = $oauth->getAccessToken($this->api_key, $this->api_secret, $redirect_url, $api_access_code, $api_scope);
				if ($oauth_tokens)
				{
					$function = '';
					if (isset($_GET['state']))
					{
						$function = urldecode($_GET['state']);
					}
					$this->session->set_userdata('access_token', $oauth_tokens->access_token);
					$this->session->set_userdata('access_token_expires', time() + $oauth_tokens->expires_in);
					$this->session->set_userdata('refresh_token', $oauth_tokens->refresh_token);
					#$this->config_model->add(array(
					#	'key' => 'myob_refresh_token',
					#	'value' => $oauth_tokens->refresh_token
					#));
					
					header("Location: " . base_url() . 'api/myob/connect/' . $function);
				}
				else
				{
					die("Error #2");
				}
			}
			
		}
		
		$result = '';
		$params = explode('~', $function);
		switch($params[0])
		{
			case 'read_employee':
					$result = $this->read_employee($params[1]);
				break;
			case 'append_employee':
					$result = $this->append_employee($params[1]);
				break;
			case 'update_employee':
					$result = $this->update_employee($params[1]);
				break;
			case 'search_employee':
					$result = $this->search_employee();
				break;
			case 'update_employee_payment':
					$result = $this->update_employee_payment($params[1]);
				break;
			case 'append_employee_payroll':
					#$result = $this->append_employee_payroll();
				break;
			case 'info':
					$result = $this->info();
				break;
			case '':
			default:
					$result = $this->company();
				break;
		}
		#var_dump($result);
		return $result;
	}
	
	function company()
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$url = $this->cloud_api_url;
		#return $headers;
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		#return $response;
		$company = json_decode($response);
		if (isset($company[0]))
		{
			$this->config_model->add(array(
				'key' => 'myob_company_id',
				'value' => $company[0]->Id
			));
			header("Location: " . base_url() . 'setting/integration');
		}
		$this->session->set_flashdata('connect_myob_failed', true);
		header("Location: " . base_url() . 'setting/integration');
	}
	
	function info()
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$url = $this->cloud_api_url . 'Info';
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		return ($response);
	}
	
	function preferences()
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#var_dump($headers); die();
		$url = $this->cloud_api_url . $this->company_id . '/Company/Preferences';
		
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		$response = json_decode($response);
		return $response;
	}
	
	function test()
	{
		$a = $this->info();
		if (isset($a->Errors))
		{
			echo 'false';
		}
		echo 'true';
	}
	
	function search_employee()
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#var_dump($headers); die();
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee';
		
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		$response = json_decode($response);
		if (isset($response->Items))
		{
			return $response->Items;
		}
		return null;		
	}
	
	function read_employee($external_id)
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/?$' . $filter;
		
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch); 
		
		$response = json_decode($response);
		if (isset($response->Items[0]))
		{
			return $response->Items[0];
		}
		return null;
	}
	
	function append_employee($user_id)
	{
		$staff = modules::run('staff/get_staff', $user_id);
		if (!$staff)
		{
			return false;
		}
		$employee = array(
			'LastName' => $staff['last_name'],
			'FirstName' => $staff['first_name'],
			'IsIndividual' => 'True',
			'DisplayID' => 'SB' . $staff['user_id'],
			'IsActive' => 'True',
			'Addresses' => array(
				array(
					'Location' => 1,
					'Street' => $staff['address'],
					'City' => $staff['city'],
					'State' => $staff['state'],
					'PostCode' => $staff['postcode'],
					'Country' => $staff['country'],
					'Phone1' => $staff['phone'],
					'Phone2' => $staff['mobile'],
					'Email' => $staff['email_address'],
					'Salutation' => $staff['title']
				)
			),
			'LastModified' => $staff['modified_on']
		);
		$params = json_encode($employee);
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee';
		
		$ch = curl_init($url); 
		
		
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
				
		$response = curl_exec($ch); 
		curl_close($ch);
		
		$this->load->model('staff/staff_model');
		return $this->staff_model->update_staff($user_id, array('external_staff_id' => 'SB' . $user_id));		
	}
	
	function update_employee($external_id)
	{
		$employee = $this->read_employee($external_id);
		if (!isset($employee))
		{
			return false;
		}
		$staff = modules::run('staff/get_staff_by_external_id', $external_id);
		if (!$staff)
		{
			return false;
		}
		$updated_employee = array(
			'UID' => $employee->UID,
			'LastName' => $staff['last_name'],
			'FirstName' => $staff['first_name'],
			'IsIndividual' => 'True',
			'DisplayID' => $staff['external_staff_id'],
			'IsActive' => 'True',
			'Addresses' => array(
				array(
					'Location' => 1,
					'Street' => $staff['address'],
					'City' => $staff['city'],
					'State' => $staff['state'],
					'PostCode' => $staff['postcode'],
					'Country' => $staff['country'],
					'Phone1' => $staff['phone'],
					'Phone2' => $staff['mobile'],
					'Email' => $staff['email_address'],
					'Salutation' => $staff['title']
				)
			),
			'LastModified' => $staff['modified_on'],
			'RowVersion' => $employee->RowVersion
		);
		$params = json_encode($updated_employee);
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/' . $employee->UID;
		
		$ch = curl_init($url); 
		
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}
	
	function read_employee_payment($external_id)
	{
		$employee = $this->read_employee($external_id);
		if (!isset($employee))
		{
			return null;
		}
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/EmployeePaymentDetails/' . $employee->EmployeePaymentDetails->UID;
		
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch); 
		
		$response = json_decode($response);
		#var_dump($response);
		return $response;
	}
	
	function update_employee_payment($user_id)
	{
		$staff = modules::run('staff/get_staff', $user_id);
		if (!$staff)
		{
			return false;
		}
		$payment = $this->read_employee_payment($staff['external_staff_id']);
		if (!isset($payment))
		{
			return false;
		}
		$bsb = str_replace(' ', '', $staff['f_bsb']);
		$bsb = trim($bsb);
		$bsb = substr($bsb,0,3) . '-' . substr($bsb, 3);
		
		$payment_details = array(
			'UID' => $payment->UID,
			'Employee' => array(
				'UID' => $payment->Employee->UID
			),
			'PaymentMethod' => 'Electronic',
			'BankStatementText' => strtoupper('wages ' . $staff['first_name'] . ' ' . $staff['last_name']),
			'BankAccounts' => array(
				array(
					'BSBNumber' => $bsb,
					'BankAccountNumber' => $staff['f_acc_number'],
					'BankAccountName' => $staff['f_acc_name'],
					'Value' => '100',
					'Unit' => 'Percent'
				)
			),
			'RowVersion' => $payment->RowVersion
		);
		$params = json_encode($payment_details);
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/EmployeePaymentDetails/' . $payment->UID;
		$ch = curl_init($url); 
		
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch);
		curl_close($ch);
		return true;
	}
	
	function read_payroll($name)
	{
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=substringof('". $name ."',%20Name)%20eq%20true";
		
		$url = $this->cloud_api_url . $this->company_id . '/Payroll/PayrollCategory/?$' . $filter;
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch); 
		
		$response = json_decode($response);
		if (isset($response->Items[0]))
		{
			return $response->Items[0];
		}
		return null;
	}
	
	function read_timesheets($external_id)
	{
		$employee = $this->read_employee($external_id);
		if (!$employee)
		{
			return;
		}
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $this->session->userdata('access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID;
		
		$ch = curl_init($url); 
		
		
		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch);
		curl_close($ch);
		var_dump($response);
	}
	
	function append_timesheets($payrun_id)
	{
		$this->load->model('payrun/payrun_model');
		$timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		usort($timesheets, function($a, $b) { // anonymous function
		    // compare numbers only
		    if (isset($a['external_staff_id'])) {
			    return $a['external_staff_id'] - $b['external_staff_id'];
		    }
		});
		foreach($timesheets as $timesheet)
		{
			$employee = $this->read_employee($timesheet['external_staff_id']);
			if (!$employee)
			{
				continue;
			}
			
			$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
			$lines = array();
			foreach($pay_rates as $pay_rate)
			{
				$earningID = $pay_rate['group'];
				if (!$earningID)
				{
					$earningID = $timesheet['payrate'];
				}
				
				$payroll = $this->read_payroll(urlencode($earningID));
				$lines[] = array(
					'PayrollCategory' => array(
						'UID' => $payroll->UID
					),
					'Job' => null,
					'Activity' => null,
					'Customer' => null,
					'Notes' => 'Imported from StaffBooks',
					'Entries' => array(
						array(
							'Date' => date('Y-m-d H:i:s', $pay_rate['start']),
							'Hours' => $pay_rate['hours'],
							'Processed' => false
						)
					)
				);
			}
			
			$start_date = date('Y-m-d H:i:s', $timesheet['start_time']);
			if ($timesheet['date_from'] && $timesheet['date_from'] != '0000-00-00')
			{
				$start_date = date('Y-m-d H:i:s', strtotime($timesheet['date_from']));
			}
			$end_date = date('Y-m-d H:i:s', $timesheet['finish_time']);
			if ($timesheet['date_to'] && $timesheet['date_to'] != '0000-00-00')
			{
				$end_date = date('Y-m-d H:i:s', strtotime($timesheet['date_to']));
			}
			
			$timesheet_data = array(
				'Employee' => array(
					'UID' => $employee->UID
				),
				'StartDate' => $start_date,
				'EndDate' => $end_date,
				'Lines' => $lines
			);
			
			$params = json_encode($timesheet_data);
			
			$cftoken = base64_encode('Administrator:');
			$headers = array(
				'Authorization: Bearer ' . $this->session->userdata('access_token'),
		        'x-myobapi-cftoken: '.$cftoken,
		        'x-myobapi-key: ' . $this->api_key,
		        'x-myobapi-version: v2',
		        'Content-Type: application/json',
		        'Content-Length: ' . strlen($params)
			);
			
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID;
			#var_dump($url);
			$ch = curl_init($url); 
			
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
			
			
			$response = curl_exec($ch);
			curl_close($ch);
			
		}
		
	}
	
	function append_employee_payroll($subdomain, $user_id)
	{
		if (!$subdomain || !$user_id)
		{
			return false;
		}
		$employee = $this->read_employee($subdomain, $user_id);
		if (!$employee)
		{
			return false;
		}
		$staff = $this->api_model->get_staff($subdomain, $user_id);
		
		$gender = '';
		if ($staff['gender'] == 'f')
		{
			$gender = 'Female';
		}
		else if ($staff['gender'] == 'm')
		{
			$gender = 'Male';
		}
		
		$employee_payroll = array(
			'UID' => $employee->Items[0]->EmployeePayrollDetails->UID,
			'Employee' => array(
				'UID' => $employee->Items[0]->UID
			),
			'DateOfBirth' => date('Y-m-d H:i:s', strtotime($staff['dob'])),
			'Gender' => $gender,
			'StartDate' => $staff['created_on'],
			'EmploymentBasis' => 'Individual',
			
			
		);
		return ($employee_payroll);
	}
		
	function connect4()
	{
		$cloud_api_url = 'https://api.myob.com/accountright/';
		$api_key = '6k2r6jwjj2a7t9qmh9n338w2';
		$api_secret = 'EsJWfB3HXHGDke8RmZtpSfeS';
		
		$myob = new myob_api_oauth();
		$redirect_url = 'http://sm.com/api/myob/connect';
		$api_scope = 'CompanyFile';
		$api_access_code = '';
		if (!isset($_GET['code']))
		{
			$url = "https://secure.myob.com/oauth2/account/authorize?client_id=$api_key&redirect_uri=$redirect_url&response_type=code&scope=CompanyFile";
			header("Location: $url");
		}
		$api_access_code = $_GET['code'];
		$oauth_tokens = $myob->getAccessToken($api_key, $api_secret, $redirect_url, $api_access_code, $api_scope);
		
		if (isset($oauth_tokens->error)) {
			header("Location: $redirect_url");
		}
		
		$guid = $oauth_tokens->user->uid;
		$guid = 'eaa033d6-6081-4b49-ab5e-e62f05ffa551'; # Sandbox
		#var_dump($guid); die();
		
		#var_dump($oauth_tokens); die();
		$employee = array(
			'LastName' => 'Nguyen',
			'FirstName' => 'Nam',
			'IsIndividual' => 'True',
		);
		#$employee = json_encode($employee);
		
		$payroll = array(
			'Name' => 'Advance',
			'Type' => 'Wage',
			'URI' => 'https://api.myob.com/accountright/eaa033d6-6081-4b49-ab5e-e62f05ffa551/Payroll/PayrollCategory/Wage/2ba32363-e120-4879-83aa-2f329a9a40f5'
		);
		
		$wage = array(
			'Name' => 'Base Hourly',
			'Type' => 'Wage',
			'WageType' => 'Hourly',
			'HourlyDetails' => array(
				'PayRate' => 'RegularRate',
				'RegularRateMultiplier' => 1,
				'FixedHourlyRate' => 50,
				'AutomaticallyAdjustBaseAmounts' => true
			)
		);
		
				
		$timesheet = array(
			'Employee' => array(
				'UID' => 'f4a40e1f-7a30-4555-baa5-3f41f8fb8033'
			),			
			'StartDate' => '2014-07-30 10:30:00',
			'EndDate' => '2014-08-07 10:30:00',
			'Lines' => array(array(
				'PayrollCategory' => array(
					'UID' => '2ba32363-e120-4879-83aa-2f329a9a40f5'
				),
				'Entries' => array(
					array(
						'Date' => '2014-08-02 09:00:00',
						'Hours' => '8'
					)
				)
			)),
			
		);
		
		$preferences = array(
			'Timesheets' => array(
				'UseTimesheetsFor' => 'Payroll',
				'WeekStartsOn' => 'Monday'
			)
		);
		
		$params = json_encode($preferences);
		#echo '<pre>'; print_r($params); echo '</pre>'; die();
		$cftoken = base64_encode('Administrator:');
		$headers = array(
			'Authorization: Bearer ' . $oauth_tokens->access_token,
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        #'Content-Length: ' . strlen($params)
		);
		
		$url = $cloud_api_url . $guid . '/Payroll/Timesheet/f4a40e1f-7a30-4555-baa5-3f41f8fb8033';
		
		$url = $cloud_api_url . 'eaa033d6-6081-4b49-ab5e-e62f05ffa551/Contact/Employee';
		
		#var_dump($headers); die();
		#var_dump($url); die();
		#$params = http_build_query($employee);
		 
		#var_dump($params); die();
		# 'LastName='.urlencode('Nguyen').'&FirstName='.urlencode('Nam').'&IsIndividual='.urlencode('true');
		
		#var_dump($params); die();
		$session = curl_init($url); 
		
		
		#curl_setopt($session, CURLOPT_POST, true); 
		#curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($session, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($session, CURLOPT_HEADER, false); 
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		// get the response & close the session
		$response = curl_exec($session); 
		curl_close($session); 
		// return what we got
		var_dump($response);
	}
}