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
		$a = $this->update_customer(16);
		var_dump($a);
	}
	
	function test() 
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/Defaults';
		$request = '<Defaults xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			</Defaults>';
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			$output = array(
				'ok' => false,
				'message' => "client construction error: {$error}\n"
			);
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		#return $result;
		if ($result['DefaultsResult']['ErrorCode'])
		{
			$output = array(
				'ok' => false,
				'message' => $result['DefaultsResult']['ErrorMessage']
			);
		}
		else
		{
			$output = array(
				'ok' => true
			);
		}
		echo json_encode($output);
	}
	
	function read_employee($id)
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
	
	function search_employee()
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/SearchEmployee';
		$request = '<SearchEmployee xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
		<args />
		</SearchEmployee>';		
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['SearchEmployeeResult']['Results']) 
			&& is_array($result['SearchEmployeeResult']['Results']) && $result['SearchEmployeeResult']['Results'] != '')
		{
			$item = $result['SearchEmployeeResult']['Results']['DataItem'];
			if (isset($item['DataID']))
			{
				$a = array();
				$a[] = $item;
				return $a;
			}
			return $item;
		}
		return array();
	}
	
	function append_employee($user_id)
	{
		$staff = modules::run('staff/get_staff', $user_id);
		if (!$staff)
		{
			return false;
		}
		$action = 'http://www.shoebooks.com.au/accounting/v10/AppendEmployee';
		
		$dob = '';
		if ($staff['dob'] && $staff['dob'] != '0000-00-00') {
			$dob = '<BirthDate>' . $staff['dob'] . '</BirthDate>';
		}
		$date_entered = '';
		if ($staff['created_on'] && $staff['created_on'] != '0000-00-00 00:00:00') {
			$date_entered = '<DateEntered>' . date('Y-m-d', strtotime($staff['created_on'])) . '</DateEntered>';
		}
		$date_modified = '';
		if ($staff['modified_on'] && $staff['modified_on'] != '0000-00-00 00:00:00') {
			$date_entered = '<LastModified>' . date('Y-m-d', strtotime($staff['modified_on'])) . '</LastModified>';
		}		
		$e_id = 'SB' . $staff['user_id'];
		
		$request = '<AppendEmployee xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewEmployee>
				<EmployeeID>' . $e_id . '</EmployeeID>
				<Company>' . $staff['first_name'] . ' ' . $staff['last_name'] . '</Company>
				<SocialSecurity>' . $staff['f_tfn'] . '</SocialSecurity>
				<Title>' . $staff['title'] . '</Title>
				<FirstName>' . $staff['first_name'] . '</FirstName>
				<MiddleName></MiddleName>
				<LastName>' . $staff['last_name'] . '</LastName>
				<Address>' . $staff['address'] . '</Address>
				<County>' . $staff['suburb'] . '</County>
				<City>' . $staff['city'] . '</City>
				<State>' . $staff['state'] . '</State>
				<Zip>' . $staff['postcode'] . '</Zip>
				<Country>' . $staff['country'] . '</Country>' .
				$dob . '
				<Gender>' . $staff['gender'] . '</Gender>
				<EmergencyContact>' . $staff['emergency_contact'] . '</EmergencyContact>
				<EmergencyPhone>' . $staff['emergency_phone'] . '</EmergencyPhone>' .
				$date_entered .
				$date_modified . '
				<BankName>' . $staff['f_acc_name'] . '</BankName>
				<BankNumber>' . $staff['f_bsb'] . '</BankNumber>
				<BankAccount>' . $staff['f_acc_number'] . '</BankAccount>
				<ExtraVendorID></ExtraVendorID>
				<BankType></BankType>
				<ExtraFundName>' . $staff['s_fund_name'] . '</ExtraFundName>
				<ExtraFundNumber>' . $staff['s_membership'] . '</ExtraFundNumber>
				<EmploymentType></EmploymentType>
				<VendorID></VendorID>
				<ContactNumbers>
					<ContactNumber>
						<PhoneNumber>' . $staff['phone'] . '</PhoneNumber>
						<ContactMethod></ContactMethod>
					</ContactNumber>
				</ContactNumbers>
			</NewEmployee>
		</AppendEmployee>';
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['AppendEmployeeResult']['NewRecordID']))
		{
			$this->load->model('staff/staff_model');
			return $this->staff_model->update_staff($user_id, array('external_staff_id' => $result['AppendEmployeeResult']['NewRecordID']));
		}
		return false;
	}
	
	function update_employee($external_id)
	{
		$staff = modules::run('staff/get_staff_by_external_id', $external_id);
		if (!$staff)
		{
			return false;
		}
		$action = 'http://www.shoebooks.com.au/accounting/v10/UpdateEmployee';
		
		$dob = '';
		if ($staff['dob'] && $staff['dob'] != '0000-00-00') {
			$dob = '<BirthDate>' . $staff['dob'] . '</BirthDate>';
		}
		$date_entered = '';
		if ($staff['created_on'] && $staff['created_on'] != '0000-00-00 00:00:00') {
			$date_entered = '<DateEntered>' . date('Y-m-d', strtotime($staff['created_on'])) . '</DateEntered>';
		}
		$date_modified = '';
		if ($staff['modified_on'] && $staff['modified_on'] != '0000-00-00 00:00:00') {
			$date_entered = '<LastModified>' . date('Y-m-d', strtotime($staff['modified_on'])) . '</LastModified>';
		}	
		
		$request = '<UpdateEmployee xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewEmployee>
				<EmployeeID>' . $staff['external_staff_id'] . '</EmployeeID>
				<Company>' . $staff['first_name'] . ' ' . $staff['last_name'] . '</Company>
				<SocialSecurity>' . $staff['f_tfn'] . '</SocialSecurity>
				<Title>' . $staff['title'] . '</Title>
				<FirstName>' . $staff['first_name'] . '</FirstName>
				<MiddleName></MiddleName>
				<LastName>' . $staff['last_name'] . '</LastName>
				<Address>' . $staff['address'] . '</Address>
				<County>' . $staff['suburb'] . '</County>
				<City>' . $staff['city'] . '</City>
				<State>' . $staff['state'] . '</State>
				<Zip>' . $staff['postcode'] . '</Zip>
				<Country>' . $staff['country'] . '</Country>' .
				$dob . '
				<Gender>' . $staff['gender'] . '</Gender>
				<EmergencyContact>' . $staff['emergency_contact'] . '</EmergencyContact>
				<EmergencyPhone>' . $staff['emergency_phone'] . '</EmergencyPhone>' .
				$date_entered .
				$date_modified . '				
				<BankName>' . $staff['f_acc_name'] . '</BankName>
				<BankNumber>' . $staff['f_bsb'] . '</BankNumber>
				<BankAccount>' . $staff['f_acc_number'] . '</BankAccount>
				<ExtraVendorID></ExtraVendorID>
				<BankType></BankType>
				<ExtraFundName>' . $staff['s_fund_name'] . '</ExtraFundName>
				<ExtraFundNumber>' . $staff['s_membership'] . '</ExtraFundNumber>
				<EmploymentType></EmploymentType>
				<VendorID></VendorID>
				<ContactNumbers>
					<ContactNumber>
						<PhoneNumber>' . $staff['phone'] . '</PhoneNumber>
						<ContactMethod></ContactMethod>
					</ContactNumber>
				</ContactNumbers>
			</NewEmployee>
		</UpdateEmployee>';
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		#return $result;
		return false;
	}
	
	function read_customer($id)
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/ReadCustomer';
		$request = '<ReadCustomer xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<id>' . $id . '</id>
		</ReadCustomer>';
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['ReadCustomerResult']['Customer']))
		{
			return $result['ReadCustomerResult']['Customer'];
		}
		return null;
	}
	
	function search_customer()
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/SearchCustomer';
		$request = '<SearchCustomer xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
		<args />
		</SearchCustomer>';		
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['SearchCustomerResult']['Results'])
			&& is_array($result['SearchCustomerResult']['Results']) && $result['SearchCustomerResult']['Results'] != '')
		{			
			$item = $result['SearchCustomerResult']['Results']['DataItem'];
			if (isset($item['DataID']))
			{
				$a = array();
				$a[] = $item;
				return $a;
			}
			return $item;
		}
		return array();
	}
	
	function append_customer($user_id)
	{
		$client = modules::run('client/get_client', $user_id);
		if (!$client)
		{
			return false;
		}
		$action = 'http://www.shoebooks.com.au/accounting/v10/AppendCustomer';
		$e_id = 'SB' . $client['user_id'];
		$request = '<AppendCustomer xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewCustomer>
				<CustomerID>' . $e_id . '</CustomerID>
				<CompanyName>' . $client['company_name'] . '</CompanyName>
				<FirstName>' . $client['full_name'] . '</FirstName>
				<Address>' . $client['address'] . '</Address>
				<County>' . $client['suburb'] . '</County>
				<City>' . $client['city'] . '</City>
				<State>' . $client['state'] . '</State>
				<Zip>' . $client['postcode'] . '</Zip>
				<Country>' . $client['country'] . '</Country>				
				<CompanyACN></CompanyACN>
				<CompanyABN>' . $client['abn'] . '</CompanyABN>
				<ContactNumbers>
					<ContactNumber>
						<PhoneNumber>' . $client['phone'] . '</PhoneNumber>
						<ContactMethod></ContactMethod>
					</ContactNumber>
				</ContactNumbers>
			</NewCustomer>
		</AppendCustomer>';
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		if (isset($result['AppendCustomerResult']['NewRecordID']))
		{
			$this->load->model('client/client_model');
			return $this->client_model->update_client($user_id, array('external_client_id' => $result['AppendCustomerResult']['NewRecordID']));
		}
		return false;
	}
	
	function update_customer($external_id)
	{
		$client = modules::run('client/get_client_by_external_id', $external_id);
		if (!$client)
		{
			return false;
		}
		
		$action = 'http://www.shoebooks.com.au/accounting/v10/UpdateCustomer';
		$request = '<UpdateCustomer xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewCustomer>
				<CustomerID>' . $client['external_client_id'] . '</CustomerID>
				<CompanyName>' . $client['company_name'] . '</CompanyName>
				<FirstName>' . $client['full_name'] . '</FirstName>
				<Address>' . $client['address'] . '</Address>
				<County>' . $client['suburb'] . '</County>
				<City>' . $client['city'] . '</City>
				<State>' . $client['state'] . '</State>
				<Zip>' . $client['postcode'] . '</Zip>
				<Country>' . $client['country'] . '</Country>				
				<CompanyACN></CompanyACN>
				<CompanyABN>' . $client['abn'] . '</CompanyABN>
				<ContactNumbers>
					<ContactNumber>
						<PhoneNumber>' . $client['phone'] . '</PhoneNumber>
						<ContactMethod></ContactMethod>
					</ContactNumber>
				</ContactNumbers>
			</NewCustomer>
		</UpdateCustomer>';
		
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		return true;
	}
	
	
	function append_payslip($payrun_id)
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/AppendPayslip';
		$request = '<AppendPayslip xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewPayslip>
				<EmployeeID>string</EmployeeID>
				<PeriodStart>dateTime</PeriodStart>
				<PeriodFinish>dateTime</PeriodFinish>
				<AccountID>string</AccountID>
				<JobID>string</JobID>
				<PayDate>dateTime</PayDate>
				<DivID>int</DivID>
				<PayslipLines>
					<PRPayslipLine>
						<EarningID>string</EarningID>
						<Hours>decimal</Hours>
						<Amount>decimal</Amount>
						<Total>decimal</Total>
						<WorkDate>dateTime</WorkDate>
						<DivID>int</DivID>
						<JobID>string</JobID>
					</PRPayslipLine>
					<PRPayslipLine>
						<EarningID>string</EarningID>
						<Hours>decimal</Hours>
						<Amount>decimal</Amount>
						<Total>decimal</Total>
						<AccountID>string</AccountID>
						<WorkDate>dateTime</WorkDate>
						<Notes>string</Notes>
						<DivID>int</DivID>
						<JobID>string</JobID>
					</PRPayslipLine>
				</PayslipLines>
			</NewPayslip>
		</AppendPayslip>';
	}
}