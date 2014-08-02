<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: MYOB API
 */

class Myob extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'libraries/myob_api_oauth.php'); //includes nusoap
	}
	
	function index()
	{
		$cloud_api_url = 'https://api.myob.com/accountright/';
		
				
		$api_key = '6k2r6jwjj2a7t9qmh9n338w2';
		$api_secret = 'EsJWfB3HXHGDke8RmZtpSfeS';
		
		$myob = new myob_api_oauth();
		$redirect_url = 'http://demo.sm.com/api/myob';
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
			'IsIndividual' => 'True'
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
	        'Content-Length: ' . strlen($params)
		);
		
		$url = $cloud_api_url . $guid . '/Payroll/Timesheet/f4a40e1f-7a30-4555-baa5-3f41f8fb8033';
		
		$url = $cloud_api_url . $guid . '/Company/Preferences';
		
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