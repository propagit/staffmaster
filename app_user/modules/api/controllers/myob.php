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
		$access_token = $this->config_model->get('myob_access_token');
		if ($access_token)
		{
			$expiry_time = time() + 600; # Add 600 second (10 minutes) before it expires
			if ($expiry_time > $this->config_model->get('myob_access_token_expires'))
			{
				$oauth = new myob_api_oauth();
				$oauth_tokens = $oauth->refreshAccessToken($this->api_key, $this->api_secret, $this->config_model->get('myob_refresh_token'));
				if ($oauth_tokens)
				{
					$this->config_model->add(array('key' => 'myob_access_token', 'value' => $oauth_tokens->access_token));
					$this->config_model->add(array('key' => 'myob_access_token_expires', 'value' => time() + $oauth_tokens->expires_in));
					$this->config_model->add(array('key' => 'myob_refresh_token', 'value' => $oauth_tokens->refresh_token));
				}
				else
				{
					die("Error #1.");
				}
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
				$this->config_model->add(array('key' => 'myob_access_token', 'value' => $oauth_tokens->access_token));
				$this->config_model->add(array('key' => 'myob_access_token_expires', 'value' => time() + $oauth_tokens->expires_in));
				$this->config_model->add(array('key' => 'myob_refresh_token', 'value' => $oauth_tokens->refresh_token));
				
				header("Location: " . base_url() . 'api/myob/connect/' . $function);
			}
			else
			{
				die("Error #2");
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
			case 'read_employee_payment':
					$result = $this->read_employee_payment($params[1]);
				break;
			case 'update_employee_payment':
					$result = $this->update_employee_payment($params[1]);
				break;
			case 'read_customer':
					$result = $this->read_customer($params[1]);
				break;
			case 'append_customer':
					$result = $this->append_customer($params[1]);
				break;
			case 'update_customer':
					$result = $this->update_customer($params[1]);
				break;
			case 'search_customer':
					$result = $this->search_customer();
				break;
			case 'read_payroll':
					$result = $this->read_payroll($params[1]);
				break;
			case 'append_timesheets':
					$result = $this->append_timesheets($params[1]);
				break;
			case 'append_employee_payroll':
					#$result = $this->append_employee_payroll();
				break;
			case 'read_activity':
					$result = $this->read_activity($params[1]);
				break;
			case 'info':
					$result = $this->info();
				break;
			case 'test':
					echo $this->test(); die();
				break;
			case '':
			default:
					$result = $this->company();
				break;
		}
		var_dump($result);
		return $result;
	}
	
	function company()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$url = $this->cloud_api_url;
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		$company = json_decode($response);
		var_dump($company); die();
		if (isset($company[0]))
		{
			$this->config_model->add(array('key' => 'myob_company_id', 'value' => $company[0]->Id));
			#header("Location: " . base_url() . 'setting/integration');
		}
		header("Location: " . base_url() . 'setting/integration');
	}
	
	function test()
	{
		$a = $this->info();
		if (isset($a->Errors))
		{
			return false;
		}
		return true;
	}
	
	function info()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		$response = json_decode($response);
		return ($response);
	}
	
	function preferences()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
	
	function taxcode()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#var_dump($headers); die();
		$url = $this->cloud_api_url . $this->company_id . '/GeneralLedger/TaxCode';
		
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
			$items = $response->Items;
			return $items[5];
		}
		return null;
	}
	
	
	/**
	*	@desc: get all employees from MYOB
	*	@return: array of objects (vector) of employee from MYOB
	*				or null
	*/
	function search_employee()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		
		$filter = "filter=IsActive%20eq%20true";
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/?$' . $filter;
		
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch); 
		curl_close($ch);
		$response = json_decode($response);
		#var_dump($response); die();
		if (isset($response->Items))
		{
			return $response->Items;
		}
		return null;		
	}
	
	/**
	*	@desc: get employee from MYOB
	*	@params: $external_id (DisplayID in MYOB)
	*	@return: object (vector) of employee data from MYOB
	*				or null if not found
	*/
	function read_employee($external_id)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		#var_dump($response); die();
		if (isset($response->Items[0]))
		{
			return $response->Items[0];
		}
		return null;
	}
	
	/**
	*	@desc: add new employee to MYOB
	*	@params: $user_id (user_id in StaffBooks)
	*	@return: true if success
	*				or false if failed
	*/
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
			'DisplayID' => ($staff['external_staff_id']) ? $staff['external_staff_id'] : STAFF_PREFIX . $staff['user_id'],
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
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		$response = json_decode($response);
		
		if (isset($response->Errors))
		{
			return false;
		}
		
		$this->load->model('staff/staff_model');
		return $this->staff_model->update_staff($user_id, array('external_staff_id' => STAFF_PREFIX . $user_id), true);		
	}
	
	/**
	*	@desc: update existed employee to MYOB
	*	@params: $external_id (DisplayID in MYOB)
	*	@return: true if success
	*				or false if failed
	*/
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
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		
		$response = json_decode($response);
		
		if (isset($response->Errors))
		{
			return false;
		}
		
		return true;
	}
	
	/**
	*	@desc: get employee payment details from MYOB
	*	@params: $external_id (DisplayID in MYOB)
	*	@return: object (vector) of payment details of employee
	*				or null if not found
	*/
	function read_employee_payment($external_id)
	{
		$employee = $this->read_employee($external_id);
		if (!isset($employee))
		{
			return null;
		}
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		#var_dump($response); die();
		return $response;
	}
	
	/**
	*	@desc: update employee payment details to MYOB
	*	@params: $user_id (user_id in StaffBooks)
	*	@return: true if success
	*				or false if failed
	*/
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
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		$response = json_decode($response);
		if (isset($response->Errors))
		{
			return false;
		}
		return true;
	}
	
	/**
	*	@desc: get all customers from MYOB
	*	@return: array of objects (vector) of customers from MYOB
	*				or null
	*/
	function search_customer()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=IsActive%20eq%20true";
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/?$' . $filter;
		
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
			#var_dump($response->Items);
			return $response->Items;
		}
		return null;
	}
	
	/**
	*	@desc: get customer from MYOB
	*	@params: $external_id (DisplayID from MYOB)
	*	@return: object (vector) of customer
	*				or null if not found
	*/
	function read_customer($external_id)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/?$' . $filter;
		
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
			#var_dump($response->Items[0]);
			return $response->Items[0];
		}
		return false;
	}
	
	/**
	*	@desc: add new customer to MYOB
	*	@params: $user_id (user_id in StaffBooks)
	*	@return: true if success
	*				or false if failed
	*/
	function append_customer($user_id)
	{
		$client = modules::run('client/get_client', $user_id);
		if (!$client)
		{
			return false;
		}
		$names = explode(' ', $client['full_name']);
		$customer = array(
			'CompanyName' => $client['company_name'],
			'LastName' => isset($names[1]) ? $names[1] : $names[0],
			'FirstName' => $names[0],
			'IsIndividual' => 'False',
			'DisplayID' => ($client['external_client_id']) ? $client['external_client_id'] : CLIENT_PREFIX . $client['user_id'],
			'IsActive' => 'True',
			'Addresses' => array(
				array(
					'Location' => 1,
					'Street' => $client['address'],
					'City' => $client['city'],
					'State' => $client['state'],
					'PostCode' => $client['postcode'],
					'Country' => $client['country'],
					'Phone1' => $client['phone'],
					'Phone2' => $client['mobile'],
					'Email' => $client['email_address'],
					'Salutation' => $client['title']
				)
			),
			'Notes' => 'Imported from StaffBooks',
			'SellingDetails' => array(
				'ABN' => $client['abn'],
				'TaxCode' => array(
					'UID' => $this->taxcode()->UID
				),
				'FreightTaxCode' => array(
					'UID' => $this->taxcode()->UID
				)
			),
			'LastModified' => $client['modified_on']
		);
		$params = json_encode($customer);
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer';
		
		$ch = curl_init($url); 
		
		
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
				
		$response = curl_exec($ch); 
		curl_close($ch);
		$response = json_decode($response);
		
		if (isset($response->Errors))
		{
			$result = false;
		}
		$this->load->model('client/client_model');
		$result = $this->client_model->update_client($user_id, array('external_client_id' => CLIENT_PREFIX . $user_id), true);
		return $result;
	}
	
	/**
	*	@desc: update customer data to MYOB
	*	@params: $external_id (DisplayID in MYOB)
	*	@return: true if success
	*				or false if failed
	*/
	function update_customer($external_id)
	{
		$customer = $this->read_customer($external_id);
		if (!isset($customer))
		{
			return false;
		}
		$client = modules::run('client/get_client_by_external_id', $external_id);
		if (!$client)
		{
			return false;
		}
		$names = explode(' ', $client['full_name']);
		$updated_customer = array(
			'UID' => $customer->UID,
			'CompanyName' => $client['company_name'],
			'LastName' => isset($names[1]) ? $names[1] : $names[0],
			'FirstName' => $names[0],
			'IsIndividual' => 'False',
			'DisplayID' => 'SBCUS' . $client['user_id'],
			'IsActive' => 'True',
			'Addresses' => array(
				array(
					'Location' => 1,
					'Street' => $client['address'],
					'City' => $client['city'],
					'State' => $client['state'],
					'PostCode' => $client['postcode'],
					'Country' => $client['country'],
					'Phone1' => $client['phone'],
					'Phone2' => $client['mobile'],
					'Email' => $client['email_address'],
					'Salutation' => $client['title']
				)
			),
			'Notes' => 'Updated from StaffBooks',
			'SellingDetails' => array(
				'ABN' => $client['abn'],
				'TaxCode' => array(
					'UID' => $this->taxcode()->UID
				),
				'FreightTaxCode' => array(
					'UID' => $this->taxcode()->UID
				)
			),
			'LastModified' => $client['modified_on'],
			'RowVersion' => $customer->RowVersion
		);
		
		$params = json_encode($updated_customer);
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/' . $customer->UID;
		
		$ch = curl_init($url); 
		
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		
		
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		
		if (isset($response->Errors))
		{
			return false;
		}
		return true;
	}
	
	function read_activity($external_id)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		
		$url = $this->cloud_api_url . $this->company_id . '/TimeBilling/Activity/?$' . $filter;
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
			var_dump($response->Items[0]);
			return $response->Items[0];
		}
		return null;
	}
	
	function read_payroll($name)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
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
		$errors = array();
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
				$break = '';
				if ($pay_rate['break']) {
					$break = ' w/ ' . $pay_rate['break'] / 3600 . ' hour break';
				}
				
				$payroll = $this->read_payroll(urlencode($earningID));
				$customer = $this->read_customer($timesheet['external_client_id']);
				#$activity = $this->read_activity();
				
				$lines[] = array(
					'PayrollCategory' => array(
						'UID' => $payroll->UID
					),
					'Job' => null,
					'Activity' => null,
					'Customer' => ($customer) ? array(
						'UID' => $customer->UID
					) : null,
					'Notes' => trim($timesheet['venue'] . ' ' . date('H:i', $pay_rate['start']) . ' - ' . date('H:i', $pay_rate['finish']) . ' ' . $break),
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
			
			#var_dump($timesheet_data);
			
			$params = json_encode($timesheet_data);
			
			$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
			$headers = array(
				'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
		        'x-myobapi-cftoken: '.$cftoken,
		        'x-myobapi-key: ' . $this->api_key,
		        'x-myobapi-version: v2',
		        'Content-Type: application/json',
		        'Content-Length: ' . strlen($params)
			);
			
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID;
			
			$ch = curl_init($url); 
			
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
			
			
			$response = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($response);
			if (isset($response->Errors))
			{
				$errors[] = $response->Errors;
			}	
		}
		return $errors;
		
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
}