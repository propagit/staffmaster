<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Shoebooks API
 */

class Shoebooks extends MX_Controller {

	var $host = 'http://login.shoebooks.com.au/net/soap/AccountingService.asmx';
	var $account_name = '';
	var $login_name = '';
	var $login_password = '';
	
	function __construct()
	{
		parent::__construct();
		require_once(APPPATH.'libraries/nusoap/nusoap.php'); //includes nusoap
		$this->account_name = $this->config_model->get('shoebooks_account_name');
		$this->login_name = $this->config_model->get('shoebooks_login_name');
		$this->login_password = $this->config_model->get('shoebooks_login_password');
	}
	
	function index() 
	{
		$host = 'http://login.shoebooks.com.au/net/soap/AccountingService.asmx';
		$action = 'http://www.shoebooks.com.au/accounting/v10/SearchEmployee';
		
		$account_name = 'staffbooks';
		$login_name = 'staffbooks';
		$login_password = 'staffb00ks';
		
		$request = '<SearchEmployee xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $account_name . '</AccountName>
				<LoginName>' . $login_name . '</LoginName>
				<LoginPassword>' . $login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
		<args />
		</SearchEmployee>';
		
		
		$client = new nusoap_client($host);
		
		
		
		$error = $client->getError();
		if ($error)
		{
			die("client construction error: {$error}\n");
		}
		
		
		
		
		
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		var_dump($result);
	}
	
	function get_staff($id)
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/ReadEmployee';
		$request = '<ReadEmployee xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<id>' . $id . '</id>
			</ReadEmployee>';
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['ReadEmployeeResult']['Employee']))
		{
			return $result['ReadEmployeeResult']['Employee'];
		}
		return null;
	}
	

}