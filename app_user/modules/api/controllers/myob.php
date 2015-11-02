<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: MYOB API
 */

class Myob extends MX_Controller {

	var $cloud_api_url = 'https://api.myob.com/accountright/';
	// var $cloud_api_url = 'https://api-myob-com-z44bv7hnjcma.runscope.net/accountright/';

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
		$this->time_billing_disabled = $this->config_model->get('myob_time_billing_disabled');
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
				die($url);
			}
			$api_access_code = $_GET['code'];
			$oauth = new myob_api_oauth();
			$oauth_tokens = $oauth->getAccessToken($this->api_key, $this->api_secret, $redirect_url, $api_access_code, $api_scope);
			#var_dump($oauth_tokens);die();
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
		$param = isset($params[1]) ? urlencode($params[1]) : '';


		switch($params[0])
		{
			case 'read_employee':
					$result = $this->read_employee($param);
				break;
			case 'read_employee_by_UID':
					$result = $this->read_employee_by_UID($param);
				break;
			case 'test_read_employee_by_UID':
					$result = $this->test_read_employee_by_UID($param);
				break;
			case 'append_employee':
					$result = $this->append_employee($param);
				break;
			case 'update_employee':
					$result = $this->update_employee($param);
				break;
			case 'search_employee':
					$result = $this->search_employee();
				break;
			case 'test_search_employee':
					$result = $this->test_search_employee();
				break;
			case 'read_employee_payment':
					$result = $this->read_employee_payment($param);
				break;
			case 'read_employee_payroll':
					$result = $this->read_employee_payroll($param);
				break;
			case 'update_employee_payment':
					$result = $this->update_employee_payment($param);
				break;
			case 'update_employee_payroll':
					$result = $this->update_employee_payroll($param);
				break;


			case 'read_customer':
					$result = $this->read_customer($param);
				break;
			case 'append_customer':
					$result = $this->append_customer($param);
				break;
			case 'update_customer':
					$result = $this->update_customer($param);
				break;
			case 'search_customer':
					$result = $this->search_customer();
				break;
			case 'read_payroll':
					$result = $this->read_payroll($param);
				break;
			case 'validate_append_timesheet':
					$result = $this->validate_append_timesheet($param);
				break;
			case 'test_append_timesheets':
					$result = $this->test_append_timesheets($param);
				break;
			case 'append_timesheets':
					$result = $this->append_timesheets($param);
				break;
			case 'read_invoices':
					$result = $this->read_invoices();
				break;
			case 'read_invoice':
					$result = $this->read_invoice($param);
				break;
			case 'validate_append_invoice':
					$result = $this->validate_append_invoice($param);
				break;
			case 'append_invoice':
					$result = $this->append_invoice($param);
				break;
			case 'read_activity':
					$result = $this->read_activity($param);
				break;


			case 'search_super_funds':
					$result = $this->search_super_funds();
				break;
			case 'read_super_fund':
					$result = $this->read_super_fund($param);
				break;
			case 'read_accounts':
					$result = $this->read_accounts($param);
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
		#var_dump($result);
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
		# var_dump($response); die();
		if (isset($company[0]))
		{
			$this->config_model->add(array('key' => 'myob_company_id', 'value' => $company[0]->Id));
		}
		if (isset($company[1]))
		{
			$this->config_model->add(array('key' => 'myob_company_id', 'value' => $company[1]->Id));
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

	function taxcode($code)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#var_dump($headers); die();
		#$filter = "filter=substringof('". $code ."',%20Code)%20eq%20true";
		$filter = "filter=Code%20eq%20'". $code ."'";

		$url = $this->cloud_api_url . $this->company_id . '/GeneralLedger/TaxCode/?$' . $filter;

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
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/?$' . $filter . '&$top=5000';

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

	function test_search_employee()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);

		$filter = "filter=IsActive%20eq%20true";
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/?$' . $filter . '&$top=5000';

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		var_dump($response); die();
		if (isset($response->Items))
		{
			return $response->Items;
		}
		return null;
	}



	function test_read_employee($external_id)
	{
		$e = $this->read_employee($external_id);
		var_dump($e);
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
		#$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		$filter = "filter=DisplayID%20eq%20'". $external_id ."'";
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
	*	@desc: get employee from MYOB
	*	@params: $external_id (UID in MYOB)
	*	@return: object (vector) of employee data from MYOB
	*				or null if not found
	*/
	function read_employee_by_UID($uid)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Employee/'.$uid;

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

	function test_read_employee_by_UID($uid)
	{
		$e = $this->read_employee_by_UID($uid);
		var_dump($e);
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
					'City' => trim($staff['city']) ? $staff['city'] : $staff['suburb'],
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
		// $updated_employee = array(
		// 	'UID' => $employee->UID,
		// 	'LastName' => $staff['last_name'],
		// 	'FirstName' => $staff['first_name'],
		// 	'IsIndividual' => 'True',
		// 	'DisplayID' => $staff['external_staff_id'],
		// 	'IsActive' => 'True',
		// 	'Addresses' => array(
		// 		array(
		// 			'Location' => 1,
		// 			'Street' => $staff['address'],
		// 			'City' => trim($staff['city']) ? $staff['city'] : $staff['suburb'],
		// 			'State' => $staff['state'],
		// 			'PostCode' => $staff['postcode'],
		// 			'Country' => $staff['country'],
		// 			'Phone1' => $staff['phone'],
		// 			'Phone2' => $staff['mobile'],
		// 			'Email' => $staff['email_address'],
		// 			'Salutation' => $staff['title']
		// 		)
		// 	),
		// 	'LastModified' => $staff['modified_on'],
		// 	'RowVersion' => $employee->RowVersion
		// );
		// $params = json_encode($updated_employee);
		$employee->LastName = $staff['last_name'];
		$employee->FirstName = $staff['first_name'];
		$employee->DisplayID = $staff['external_staff_id'];
		$employee->Addresses = json_decode(json_encode(array(
			array(
				'Location' => 1,
				'Street' => $staff['address'],
				'City' => trim($staff['city']) ? $staff['city'] : $staff['suburb'],
				'State' => $staff['state'],
				'PostCode' => $staff['postcode'],
				'Country' => $staff['country'],
				'Phone1' => $staff['phone'],
				'Phone2' => $staff['mobile'],
				'Email' => $staff['email_address'],
				'Salutation' => $staff['title']
			)
		), FALSE));

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
	*	@desc: updates the display ID [Card ID] with UID in myob in an event the employee do not have a display id and we need to sync the employee anyway
	*	@return: true if success
	*				or false if failed
	*/
	function update_employee_displayID_onetime($employee,$display_id)
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

		#$employee = $this->read_employee_by_UID($uid);
		#var_dump($employee);
		$employee->DisplayID = $display_id;

		$params = json_encode($employee);

		#var_dump($employee);die();

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
		#var_dump($response);die();exit;
		if (isset($response->Errors))
		{
			return false;
		}

		return true;
	}

	/**
	*	@desc: update existed employee to MYOB
	*	@params: $external_id (DisplayID in MYOB)
	*	@return: true if success
	*				or false if failed
	*/
	function test_update_employee($external_id)
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
					'City' => trim($staff['city']) ? $staff['city'] : $staff['suburb'],
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
		// echo '<pre>';
		var_dump($updated_employee);
		// echo '</pre>';
		die();
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

	function test_read_employee_payment($external_id)
	{
		$payment = $this->read_employee_payment($external_id);
		var_dump($payment);
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

	function print_employee_payroll($external_id)
	{
		var_dump($this->read_employee_payroll($external_id));
	}

	function read_employee_payroll($external_id)
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

		$url = $this->cloud_api_url . $this->company_id . '/Contact/EmployeePayrollDetails/' . $employee->EmployeePayrollDetails->UID;

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

	function test_read_employee_payroll($external_id)
	{
		$payroll = $this->read_employee_payroll($external_id);
		var_dump($payroll);
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
		$bsb = str_replace(array(' ','-'), '', $staff['f_bsb']);
		$bsb = trim($bsb);
		$bsb = substr($bsb,0,3) . '-' . substr($bsb, 3);
		$bank_statement_text = strtoupper('wages ' . $staff['first_name'] . ' ' . $staff['last_name']);
		if (strlen($bank_statement_text) > 18)
		{
			$bank_statement_text = strtoupper('wages ' . substr($staff['first_name'], 0, 1) . '. ' . $staff['last_name']);
		}
		if (strlen($bank_statement_text) > 18)
		{
			$bank_statement_text = substr($bank_statement_text, 0, 18);
		}
		// $payment_details = array(
		// 	'UID' => $payment->UID,
		// 	'Employee' => array(
		// 		'UID' => $payment->Employee->UID
		// 	),
		// 	'PaymentMethod' => 'Electronic',
		// 	'BankStatementText' => strtoupper('wages ' . $staff['first_name'] . ' ' . $staff['last_name']),
		// 	'BankAccounts' => array(
		// 		array(
		// 			'BSBNumber' => $bsb,
		// 			'BankAccountNumber' => $staff['f_acc_number'],
		// 			'BankAccountName' => $staff['f_acc_name'],
		// 			'Value' => '100',
		// 			'Unit' => 'Percent'
		// 		)
		// 	),
		// 	'RowVersion' => $payment->RowVersion
		// );
		// $params = json_encode($payment_details);

		if ($staff['f_acc_number']) {
			$payment->PaymentMethod = 'Electronic';
			$payment->BankStatementText = $bank_statement_text;
			$bank_account = json_decode(json_encode(array(
				array(
					'BSBNumber' => $bsb,
					'BankAccountNumber' => $staff['f_acc_number'],
					'BankAccountName' => $staff['f_acc_name'],
					'Value' => '100',
					'Unit' => 'Percent'
				)
			), FALSE));
			$payment->BankAccounts = json_decode(json_encode($bank_account), FALSE);
		}

		$params = json_encode($payment);

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

	function update_employee_payroll($user_id)
	{
		$staff = modules::run('staff/get_staff', $user_id);
		if (!$staff)
		{
			return false;
		}
		$payroll = $this->read_employee_payroll($staff['external_staff_id']);
		if (!$payroll)
		{
			return false;
		}
		$gender = null;
		if ($staff['gender'] == 'm') { $gender = 'Male'; }
		else if ($staff['gender'] == 'f') { $gender = 'Female'; }

		$s_external_id = $staff['s_external_id'];
		if (!$s_external_id)
		{
			$s_external_id = modules::run('setting/superinformasi', 'super_fund_external_id');
		}
		$super = null;
		if ($s_external_id)
		{
			// $super = array(
			// 	'SuperannuationFund' => array(
			// 		'UID' => $s_external_id
			// 	),
			// 	'EmployeeMembershipNumber' => $staff['s_employee_id']
			// );
			$payroll->Superannuation->SuperannuationFund->UID = $s_external_id;
			$payroll->Superannuation->EmployeeMembershipNumber = $staff['s_employee_id'];
		}

		// $payroll_details = array(
		// 	'UID' => $payroll->UID,
		// 	'Employee' => array(
		// 		'UID' => $payroll->Employee->UID
		// 	),
		// 	'DateOfBirth' => $staff['dob'] . ' 00:00:00',
		// 	'Gender' => $gender,
		// 	'Wage' => json_decode(json_encode($payroll->Wage), true),
		// 	'Superannuation' => $super,
		// 	'Tax' => array(
		// 		'TaxFileNumber' => $staff['f_tfn'],
		// 		'TaxTable' => json_decode(json_encode($payroll->Tax->TaxTable), true)
		// 	),
		// 	'RowVersion' => $payroll->RowVersion
		// );
		// #var_dump($payroll_details); die();
		// $params = json_encode($payroll_details);
		$payroll->DateOfBirth = $staff['dob'] != '0000-00-00' ? $staff['dob'] . ' 00:00:00' : $payroll->DateOfBirth;
		$payroll->Gender = $gender;

		$tfn = str_replace(array(' ','-'), '', $staff['f_tfn']);
		$tfn = trim($tfn);
		$tfn = substr($tfn,0,3) . ' ' . substr($tfn, 3,3) . ' ' . substr($tfn,6);

		$payroll->Tax->TaxFileNumber = $tfn;
		$params = json_encode($payroll);

		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);

		$url = $this->cloud_api_url . $this->company_id . '/Contact/EmployeePayrollDetails/' . $payroll->UID;
		$ch = curl_init($url);


		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		#var_dump($response);die();
		$response = json_decode($response);
		if (isset($response->Errors))
		{
			return false;
		}
		return true;
	}

	function test_update_employee_payroll($user_id)
	{
		$staff = modules::run('staff/get_staff', $user_id);
		if (!$staff)
		{
			return false;
		}
		$payroll = $this->read_employee_payroll($staff['external_staff_id']);
		if (!$payroll)
		{
			return false;
		}
		$gender = null;
		if ($staff['gender'] == 'm') { $gender = 'Male'; }
		else if ($staff['gender'] == 'f') { $gender = 'Female'; }

		$s_external_id = $staff['s_external_id'];
		if (!$s_external_id)
		{
			$s_external_id = modules::run('setting/superinformasi', 'super_fund_external_id');
		}
		$super = null;
		if ($s_external_id)
		{
			$super = array(
				'SuperannuationFund' => array(
					'UID' => $s_external_id
				),
				'EmployeeMembershipNumber' => $staff['s_employee_id']
			);
		}

		$payroll->DateOfBirth = $staff['dob'] . ' 00:00:00';
		$payroll->Gender = $gender;
		$payroll->Superannuation = $super;
		$payroll->Tax->TaxFileNumber = $staff['f_tfn'];

		// var_dump($payroll); die();

		// $payroll_details = array(
		// 	'UID' => $payroll->UID,
		// 	'Employee' => array(
		// 		'UID' => $payroll->Employee->UID
		// 	),
		// 	'DateOfBirth' => $staff['dob'] . ' 00:00:00',
		// 	'Gender' => $gender,
		// 	'Wage' => json_decode(json_encode($payroll->Wage), true),
		// 	'Superannuation' => $super,
		// 	'Tax' => array(
		// 		'TaxFileNumber' => $staff['f_tfn'],
		// 		'TaxTable' => json_decode(json_encode($payroll->Tax->TaxTable), true)
		// 	),
		// 	'RowVersion' => $payroll->RowVersion
		// );
		#var_dump($payroll_details); die();

		$params = json_encode($payroll); var_dump($params); die();
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);

		var_dump($headers); echo '<hr />';

		$url = $this->cloud_api_url . $this->company_id . '/Contact/EmployeePayrollDetails/' . $payroll->UID;

		var_dump($url); echo '<hr />';
		$ch = curl_init($url);


		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct
		// var_dump($ch); die();

		$response = curl_exec($ch);
		curl_close($ch);
		var_dump($response);
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
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/?$' . $filter . '&$top=5000';

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

	function test_read_customer()
	{
		$c = $this->search_customer();
		var_dump($c);
	}

	/**
	*	@desc: get customer from MYOB
	*	@params: $external_id (DisplayID from MYOB)
	*	@return: object (vector) of customer
	*				or null if not found
	*/
	function read_customer($external_id)
	{
		if (!$external_id)
		{
			return false;
		}
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		$filter = "filter=DisplayID%20eq%20'". $external_id ."'";
		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/?$' . $filter;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response);
		#var_dump($response);
		if (isset($response->Items[0]))
		{
			#var_dump($response->Items[0]);
			return $response->Items[0];
		}
		return null;
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
					'UID' => $this->taxcode('GST')->UID
				),
				'FreightTaxCode' => array(
					'UID' => $this->taxcode('GST')->UID
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

	function test_update_customer($external_id)
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
					'UID' => $this->taxcode('GST')->UID
				),
				'FreightTaxCode' => array(
					'UID' => $this->taxcode('GST')->UID
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
		var_dump($response);
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

		$abn = '';
		if ($client['abn'])
		{
			$abn = str_replace(' ', '', $client['abn']);
			$abn = trim($abn);
			$abn = substr($abn,0,2) . ' ' . substr($abn, 2,3) . ' ' . substr($abn, 5,3) . ' ' . substr($abn, 8);
		}

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
				'ABN' => $abn,
				'TaxCode' => array(
					'UID' => $this->taxcode('GST')->UID
				),
				'FreightTaxCode' => array(
					'UID' => $this->taxcode('GST')->UID
				)
			),
			'LastModified' => $client['modified_on'],
			'RowVersion' => $customer->RowVersion
		);
		#var_dump($updated_customer); die();
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

	function update_customer_displayID_onetime($customer,$display_id)
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

		$customer->DisplayID = $display_id;

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

	function delete_customer($external_id)
	{
		$customer = $this->read_customer($external_id);
		if (!isset($customer))
		{
			return false;
		}

		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        #'Content-Length: ' . strlen($params)
		);

		$url = $this->cloud_api_url . $this->company_id . '/Contact/Customer/' . $customer->UID;

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		var_dump($response);
		$response = json_decode($response);

		if (isset($response->Errors))
		{
			return false;
		}
		return true;
	}

	function read_accounts($class)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=Classification%20eq%20'". $class ."'";

		$url = $this->cloud_api_url . $this->company_id . '/GeneralLedger/Account/?$' . $filter;
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

	function search_activity()
	{
		$a = $this->read_activity('Gen Lab Base Rate $33');
		var_dump($a);
	}

	function read_activity($external_id)
	{
		if (!$external_id)
		{
			return false;
		}
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: ' . $cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#$filter = "filter=substringof('". $external_id ."',%20DisplayID)%20eq%20true";
		$filter = "filter=Name%20eq%20'". urlencode($external_id) ."'";

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
			#var_dump($response->Items[0]);
			return $response->Items[0];
		}
		return null;
	}

	function append_activity($external_id, $rate)
	{
		$activity = array(
			'DisplayID' => $external_id,
			'Name' => $external_id,
			#'Description' => '',
			'IsActive' => 'True',
			'Type' => 'Hourly',
			'UnitOfMeasurement' => 'Hour',
			'Status' => 'Chargeable',
			'ChargeableDetails' => array(
				'UseDescriptionOnSales' => 'False',
				'IncomeAccount' => null,
				'TaxCode' => array(
					'UID' => $this->taxcode('GST')->UID
				),
				'Rate' => 'ActivityRate',
				'ActivityRateExcludingTax' => $rate * 10/11
			)
		);
		$params = json_encode($activity);

		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);

		$url = $this->cloud_api_url . $this->company_id . '/TimeBilling/Activity';

		$ch = curl_init($url);


		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		var_dump($response);
		$response = json_decode($response);
		if (isset($response->Errors))
		{
			$errors[] = $response->Errors;
		}
		return $errors;
	}

	function search_super_funds()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#$filter = "filter=substringof('". $name ."',%20Name)%20eq%20true";
		#$filter = "filter=Name%20eq%20'". $name ."'";

		$url = $this->cloud_api_url . $this->company_id . '/Payroll/SuperannuationFund?$orderby=Name';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response);
		#var_dump($response);
		if (isset($response->Items))
		{
			#var_dump($response->Items);
			return $response->Items;
		}
		return null;
	}

	function read_super_fund($uid)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		$filter = "filter=UID%20eq%20'". $uid ."'";

		$url = $this->cloud_api_url . $this->company_id . '/Payroll/SuperannuationFund/' . $uid;
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

	function append_super_fund()
	{
		$super_fund = array(
			'Name' => 'Test New Super Fund',
			'EmployerMembershipNumber' => '',
			'PhoneNumber' => '04 0213 3066',
			'Website' => 'www.propagate.com.au'
		);
		$params = json_encode($super_fund);

		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2',
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($params)
		);

		$url = $this->cloud_api_url . $this->company_id . '/Payroll/SuperannuationFund';

		$ch = curl_init($url);


		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		var_dump($response);
		$response = json_decode($response);
		if (isset($response->Errors))
		{
			#$errors[] = $response->Errors;
		}
		#return $errors;
	}

	function search_payroll()
	{
		$p = $this->read_payroll('Level 1');
		var_dump($p);
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
		#$filter = "filter=substringof('". $name ."',%20Name)%20eq%20true";
		$filter = "filter=Name%20eq%20'". urlencode($name) ."'";

		$url = $this->cloud_api_url . $this->company_id . '/Payroll/PayrollCategory/?$' . $filter;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response);
		#var_dump($response);
		if (isset($response->Items[0]))
		{
			return $response->Items[0];
		}
		return null;
	}

	function read_timesheets($external_id, $filter = '')
	{
		/*$employee = $this->read_employee($external_id);
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
		#$filter = "?StartDate=2015-08-24T00:00:00&EndDate=2015-08-31T00:00:00";
		if($filter){
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID . '/' . $filter;
		}else{
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID;
		}

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);*/
		$response = $this->get_timesheets($external_id, $filter);
		var_dump($response);
	}

	function get_timesheets($external_id, $filter = '')
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
		if($filter){
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID . '/' . $filter;
		}else{
			$url = $this->cloud_api_url . $this->company_id . '/Payroll/Timesheet/' . $employee->UID;
		}

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response);

		if ($response)
		{
			return $response;
		}
		return null;
	}

	function validate_append_timesheet($timesheet_id)
	{
		$timesheet = modules::run('timesheet/get_timesheet', $timesheet_id);


		# Check payroll category for employee on MYOB
		$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
		foreach($pay_rates as $pay_rate)
		{
			$earningID = $pay_rate['group'];
			if (!$earningID)
			{
				$payrate = modules::run('attribute/payrate/get_payrate', $timesheet['payrate_id']);
				$earningID = $payrate['name'];
			}
			$payroll = $this->read_payroll($earningID);

			# Make sure all the payroll categories are set up on MYOB
			if (!$payroll)
			{
				$result = array(
					'ok' => false,
					'msg' => "<p>Payroll category <b>$earningID</b> is not found in MYOB</p>"
				);
				#var_dump($result);
				return $result;
			}

			/**
				ActivityID is required for time billing.
				This is however not required for timesheet

				Check config to see if the client is using MYOB time billing feature
				If they are validate activityID, else skip this step
			*/

			if(!$this->time_billing_disabled){
				$activityID = $pay_rate['activity'];
				if (!$activityID)
				{
					$payrate_id = $timesheet['payrate_id'];
					if ($timesheet['client_payrate_id'] > 0)
					{
						$payrate_id = $timesheet['client_payrate_id'];
					}
					$payrate = modules::run('attribute/payrate/get_payrate', $payrate_id);
					$activityID = $payrate['name'];
				}
				$activity = $this->read_activity($activityID);
				if (!$activity)
				{
					$result = array(
						'ok' => false,
						'msg' => '<p>Activity Name <b>' . $activityID . '</b> is not found in MYOB</p>'
					);
					#var_dump($result);
					return $result;
				}
			}

		}



		# Make sure the staff is set up on MYOB
		$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
		if (!$staff['external_staff_id'])
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Employee <b>' . $staff['first_name'] . ' ' . $staff['last_name'] . '</b> is not found in MYOB</p>'
			);
			#var_dump($result);
			return $result;
		}

		$employee = $this->read_employee($staff['external_staff_id']);
		if (!$employee)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Employee <b>' . $staff['first_name'] . ' ' . $staff['last_name'] . '</b> is not found in MYOB</p>'
			);
			#var_dump($result);
			return $result;
		}

		# Make sure payroll category is assigned to staff
		$employee_payrolls = $this->read_employee_payroll($employee->DisplayID)->Wage->WageCategories;
		$valid_employee_payroll = false;
		foreach($employee_payrolls as $e_payroll)
		{
			if ($e_payroll->UID == $payroll->UID)
			{
				$valid_employee_payroll = true;
			}
		}
		if (!$valid_employee_payroll)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Payroll category <b>' . $payroll->Name . '</b> has not been assigned to employee <b>' . $employee->FirstName . ' ' . $employee->LastName . '</b> in MYOB</p>'
			);
			#var_dump($result);
			return $result;
		}
		return array(
			'ok' => true
		);
	}

	function test_append_timesheets($payrun_id)
	{
		$this->load->model('payrun/payrun_model');
		$timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		#print_r($timesheets);exit;
		usort($timesheets, function($a, $b) { // anonymous function
		    // compare numbers only
		    if (isset($a['external_staff_id'])) {
			    return $a['external_staff_id'] - $b['external_staff_id'];
		    }
		});


		$errors = array();
		# Now all conditions are satisfied, push to MYOB
		foreach($timesheets as $timesheet)
		{
			if(1){
			#if($timesheet['timesheet_id'] == 8){
			$employee = $this->read_employee($timesheet['external_staff_id']);
			$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);

			# get existing timesheets for this user
			$filter = "?StartDate=" . $timesheet['date_from'] . "T00:00:00&EndDate=" . $timesheet['date_to'] . "T00:00:00";
			$existing_timesheets_obj = $this->get_timesheets($timesheet['external_staff_id'], $filter);
			print_r($existing_timesheets_obj);

			# change to array
			$existing_timesheets = json_decode(json_encode($existing_timesheets_obj), TRUE);
			$lines = array();

			foreach($pay_rates as $pay_rate)
			{
				$earningID = $pay_rate['group'];
				if (!$earningID)
				{
					$earningID = $timesheet['payrate'];
				}

				# if client has not disabled time billing
				if(!$this->time_billing_disabled){
					$activityID = $pay_rate['activity'];
					if (!$activityID)
					{
						$payrate_id = $timesheet['payrate_id'];
						if ($timesheet['client_payrate_id'] > 0)
						{
							$payrate_id = $timesheet['client_payrate_id'];
						}
						$payrate = modules::run('attribute/payrate/get_payrate', $payrate_id);
						$activityID = $payrate['name'];
					}
				}

				$break = '';
				if ($pay_rate['break']) {
					$break = ' w/ ' . $pay_rate['break'] / 3600 . ' hour break';
				}

				$payroll = $this->read_payroll($earningID);
				$customer = $this->read_customer($timesheet['external_client_id']);

				# if client uses time billing feature
				if($client_uses_timebilling){
					$activity = $this->read_activity($activityID);
				}

				if(isset($existing_timesheets['Lines']) && count($existing_timesheets['Lines']) > 0){
					$matched_any = false;
					foreach($existing_timesheets['Lines'] as $key => $existing_lines){
						# append existing is same payroll

						if($existing_lines['PayrollCategory']['UID'] == $payroll->UID){
							$existing_timesheets['Lines'][$key]['Entries'][] = array(
																				'Date' => date('Y-m-d H:i:s', $pay_rate['start']),
																				'Hours' => $pay_rate['hours'],
																				'Processed' => false
																			);
							$matched_any = true;

						}
					}
					# if none of the existing timesheet has same payrate - this is a new timesheet
					if(!$matched_any){
						$existing_timesheets['Lines'][] = array(
								'PayrollCategory' => array(
									'UID' => $payroll->UID
								),
								'Job' => null,
								'Activity' => !$this->time_billing_disabled ? array(
									'UID' => $activity->UID
								) : null,
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
					# get all existing lines
					$lines = $existing_timesheets['Lines'];
				}else{
					$lines[] = array(
						'PayrollCategory' => array(
							'UID' => $payroll->UID
						),
						'Job' => null,
						'Activity' => !$this->time_billing_disabled ? array(
							'UID' => $activity->UID
						) : null,
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

			#var_dump($timesheet_data); continue;
			#exit;
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
			var_dump($response);
			} # if timesheet_id
		}


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
		# Now all conditions are satisfied, push to MYOB
		foreach($timesheets as $timesheet)
		{

			$employee = $this->read_employee($timesheet['external_staff_id']);
			$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
			# get existing timesheets for this user
			$filter = "?StartDate=" . $timesheet['date_from'] . "T00:00:00&EndDate=" . $timesheet['date_to'] . "T00:00:00";
			$existing_timesheets_obj = $this->get_timesheets($timesheet['external_staff_id'], $filter);
			# change to array
			$existing_timesheets = json_decode(json_encode($existing_timesheets_obj), TRUE);
			$lines = array();
			foreach($pay_rates as $pay_rate)
			{
				$earningID = $pay_rate['group'];
				if (!$earningID)
				{
					$earningID = $timesheet['payrate'];
				}

				# if client has not disabled time billing
				if(!$this->time_billing_disabled){
					$activityID = $pay_rate['activity'];
					if (!$activityID)
					{
						$payrate_id = $timesheet['payrate_id'];
						if ($timesheet['client_payrate_id'] > 0)
						{
							$payrate_id = $timesheet['client_payrate_id'];
						}
						$payrate = modules::run('attribute/payrate/get_payrate', $payrate_id);
						$activityID = $payrate['name'];
					}
				}

				$break = '';
				if ($pay_rate['break']) {
					$break = ' w/ ' . $pay_rate['break'] / 3600 . ' hour break';
				}

				$payroll = $this->read_payroll($earningID);
				$customer = $this->read_customer($timesheet['external_client_id']);

				# if client uses time billing feature
				if($client_uses_timebilling){
					$activity = $this->read_activity($activityID);
				}

				if(isset($existing_timesheets['Lines']) && count($existing_timesheets['Lines']) > 0){
					$matched_any = false;
					foreach($existing_timesheets['Lines'] as $key => $existing_lines){
						# append existing is same payroll

						if($existing_lines['PayrollCategory']['UID'] == $payroll->UID){
							$existing_timesheets['Lines'][$key]['Entries'][] = array(
																				'Date' => date('Y-m-d H:i:s', $pay_rate['start']),
																				'Hours' => $pay_rate['hours'],
																				'Processed' => false
																			);
							$matched_any = true;

						}
					}
					# if none of the existing timesheet has same payrate - this is a new timesheet
					if(!$matched_any){
						$existing_timesheets['Lines'][] = array(
								'PayrollCategory' => array(
									'UID' => $payroll->UID
								),
								'Job' => null,
								'Activity' => !$this->time_billing_disabled ? array(
									'UID' => $activity->UID
								) : null,
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
					# get all existing lines
					$lines = $existing_timesheets['Lines'];
				}else{
					$lines[] = array(
						'PayrollCategory' => array(
							'UID' => $payroll->UID
						),
						'Job' => null,
						'Activity' => !$this->time_billing_disabled ? array(
							'UID' => $activity->UID
						) : null,
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

			#var_dump($timesheet_data); continue;

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
			#var_dump($response);
			$response = json_decode($response);
			if (isset($response->Errors))
			{
				$errors[] = $response->Errors;
			}
		}
		if (count($errors) > 0)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Error: ' . $errors[0][0]->Message . '</p>'
			);
			#var_dump($result);
			return $result;
		}

		return array(
			'ok' => true
		);

	}

	function test_read_invoices()
	{
		$a = $this->read_invoices();
		var_dump($a);
	}

	function read_invoices()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);

		$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice?$orderby=Date%20desc';

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		return ($response->Items);
	}

	function read_invoice($external_id)
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);
		#$filter = "filter=substringof('". $external_id ."',%20Number)%20eq%20true";
		$filter = "filter=Number%20eq%20'". $external_id ."'";


		$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice/?$' . $filter;

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
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
		return null;
	}

	function read_invoice_services($external_id)
	{
		$invoice = $this->read_invoice($external_id);
		if (!$invoice)
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

		$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice/Service/' . $invoice->UID;

		$ch = curl_init($url);


		#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // enforce that when we use SSL the verification is correct


		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);
		var_dump($response);
	}


	function read_invoice_items()
	{
		$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
		$headers = array(
			'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
	        'x-myobapi-cftoken: '.$cftoken,
	        'x-myobapi-key: ' . $this->api_key,
	        'x-myobapi-version: v2'
		);

		$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice/Item';

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
		$response = json_decode($response);
	}

	function validate_append_invoice($invoice_id)
	{
		$this->load->model('invoice/invoice_model');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		if (!$invoice)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Invoice is not found in StaffBooks</p>'
			);
			return $result;
		}
		$client = modules::run('client/get_client', $invoice['client_id']);
		if (!$client)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Client for this invoice is not found in StaffBooks</p>'
			);
			return $result;
		}
		$customer = $this->read_customer($client['external_client_id']);
		if (!$customer)
		{
			$result = array(
				'ok' => false,
				'msg' => '<p>Customer <b>' . $client['company_name'] . '</b> is not found in MYOB'
			);
			return $result;
		}

		$invoice_items = $this->invoice_model->get_invoice_items($invoice_id);
		foreach($invoice_items as $item)
		{
			if ($item['include_timesheets']) # TimeBilling
			{
				$timesheets = modules::run('invoice/get_invoice_timesheets', $invoice_id, $item['job_id']);
				foreach($timesheets as $timesheet)
				{
					$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id'], 1);
					foreach($pay_rates as $pay_rate)
					{
						$group = $pay_rate['group'];
						if (!$group)
						{
							$payrate_id = $timesheet['payrate_id'];
							if ($timesheet['client_payrate_id'] > 0)
							{
								$payrate_id = $timesheet['client_payrate_id'];
							}
							$payrate = modules::run('attribute/payrate/get_payrate', $payrate_id);
							$group = $payrate['name'];
						}
						$activity = $this->read_activity($group);
						if (!$activity)
						{
							$result = array(
								'ok' => false,
								'msg' => '<p>Activity Name <b>' . $group . '</b> is not found in MYOB</p>'
							);
							#var_dump($result);
							return $result;
						}
					}
				}
			}
			else # Miscellaneous
			{
				if (!$this->config_model->get('myob_invoice_account'))
				{
					$result = array(
						'ok' => false,
						'msg' => '<p>Please set up MYOB Account for Invoice in System Settings > Accounts Integration</p>'
					);
					return $result;
				}
			}
		}
		$result = array(
			'ok' => true
		);
		#var_dump($result);
		return $result;
	}

	function append_invoice($invoice_id)
	{
		$this->load->model('invoice/invoice_model');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$client = modules::run('client/get_client', $invoice['client_id']);
		$customer = $this->read_customer($client['external_client_id']);
		$invoice_items = $this->invoice_model->get_invoice_items($invoice_id);

		$timesheet_lines = array();
		$manual_lines = array();
		foreach($invoice_items as $item)
		{
			if ($item['include_timesheets'])
			{
				$timesheets = modules::run('invoice/get_invoice_timesheets', $invoice_id, $item['job_id']);
				foreach($timesheets as $timesheet)
				{
					$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id'], 1);
					$staff = modules::run('staff/get_staff', $timesheet['staff_id']);

					foreach($pay_rates as $pay_rate)
					{
						$group = $pay_rate['group'];
						$break = '';
						if ($pay_rate['break']) {
							$break = ' w/ ' . $pay_rate['break'] / 3600 . ' hour break';
						}
						if (!$group)
						{
							$payrate_id = $timesheet['payrate_id'];
							if ($timesheet['client_payrate_id'] > 0)
							{
								$payrate_id = $timesheet['client_payrate_id'];
							}
							$payrate = modules::run('attribute/payrate/get_payrate', $payrate_id);
							$group = $payrate['name'];
						}

						$activity = $this->read_activity($group);
						$timesheet_lines[] = array(
							'Type' => 'Transaction',
							'Date' => date('Y-m-d H:i:s', $pay_rate['start']),
							'Hours' => $pay_rate['hours'],
							'Activity' => array(
								'UID' => $activity->UID
							),
							'Item' => null,
							'Rate' => $pay_rate['rate'],
							'Description' => trim($staff['first_name'] . ' ' . $staff['last_name'] . ' ' . date('H:ia', $pay_rate['start']) . ' - ' . date('H:ia', $pay_rate['finish']) . ' ' . $break),
							'TaxCode' => array(
								'UID' => $this->taxcode('GST')->UID
							),
						);
					}

				}
			}
			else
			{
				$taxcode = 'FRE';
				if ($item['tax'] == GST_YES || $item['tax'] == GST_ADD)
				{
					$taxcode = 'GST';
				}
				$manual_lines[] = array(
					'Type' => 'Transaction',
					'Description' => $item['title'],
					'Total' => $item['amount'],
					'Account' => array(
						'UID' => $this->config_model->get('myob_invoice_account')
					),
					#'Job' => null,
					'TaxCode' => array(
						'UID' => $this->taxcode($taxcode)->UID
					)
				);
			}
		}

		#var_dump($timesheet_lines); die();
		#var_dump($manual_lines); die();

		$number = intval($invoice['invoice_number']);
		if (!$number)
		{
			$myob_invoices = $this->read_invoices();
			$numbers = array();
			foreach($myob_invoices as $myob_invoice)
			{
				$numbers[] = intval($myob_invoice->Number);
			}
			$number = max($numbers);
			#$number = str_pad(max($numbers) + 1, 8, "0", STR_PAD_LEFT);
		}

		$errors = array();
		$external_ids = array();

		if (count($timesheet_lines) > 0) # Push TimeBilling invoice
		{
			$external_ids[] = str_pad($number + 1, 8, "0", STR_PAD_LEFT);
			$timebilling_invoice = array(
				'Number' => str_pad($number + 1, 8, "0", STR_PAD_LEFT),
				'Date' => date('Y-m-d H:i:s', strtotime($invoice['issued_date'])),
				'CustomerPurchaseOrderNumber' => $invoice['po_number'],
				'Customer' => array(
					'UID' => $customer->UID
				),
				'Status' => 'Open',
				'Lines' => $timesheet_lines,
				'IsTaxInclusive' => 'True'
			);
			$params = json_encode($timebilling_invoice);

			$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
			$headers = array(
				'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
		        'x-myobapi-cftoken: '.$cftoken,
		        'x-myobapi-key: ' . $this->api_key,
		        'x-myobapi-version: v2',
		        'Content-Type: application/json',
		        'Content-Length: ' . strlen($params)
			);

			$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice/TimeBilling';

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
				$errors[] = $response->Errors;
			}
		}

		if (count($manual_lines) > 0) # Push Miscellaneous invoice
		{
			$external_ids[] = str_pad($number + 2, 8, "0", STR_PAD_LEFT);
			$miscellaneous_invoice = array(
				'Number' => str_pad($number + 2, 8, "0", STR_PAD_LEFT),
				'Date' => date('Y-m-d H:i:s', strtotime($invoice['issued_date'])),
				'CustomerPurchaseOrderNumber' => $invoice['po_number'],
				'Customer' => array(
					'UID' => $customer->UID
				),
				'Status' => 'Open',
				'Lines' => $manual_lines,
				'IsTaxInclusive' => 'True'
			);
			#var_dump($miscellaneous_invoice); die();
			$params = json_encode($miscellaneous_invoice);

			$cftoken = base64_encode($this->config_model->get('myob_username') . ':' . $this->config_model->get('myob_password'));
			$headers = array(
				'Authorization: Bearer ' . $this->config_model->get('myob_access_token'),
		        'x-myobapi-cftoken: '.$cftoken,
		        'x-myobapi-key: ' . $this->api_key,
		        'x-myobapi-version: v2',
		        'Content-Type: application/json',
		        'Content-Length: ' . strlen($params)
			);

			$url = $this->cloud_api_url . $this->company_id . '/Sale/Invoice/Miscellaneous';

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
				$errors[] = $response->Errors;
			}
		}
		$external_id = implode(' - ' , $external_ids);
		#var_dump($errors);
		if (count($errors) > 0)
		{
			return array(
				'ok' => false,
				'msg' => $errors
			);
		}
		else
		{
			if($this->invoice_model->update_invoice($invoice_id, array('external_id' => $external_id)))
			{
				return array(
					'ok' => true,
					'msg' => $external_id
				);
			}
		}
	}

}
