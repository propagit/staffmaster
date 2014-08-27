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
		#$a = $this->append_payslip(13);
		#var_dump($a);
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
		if ($result['ReadEmployeeResult']['Employee']['EmployeeID'])
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
		$e_id = ($staff['external_staff_id']) ? $staff['external_staff_id'] : STAFF_PREFIX . $staff['user_id'];
		
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
						<ContactMethod>N/A</ContactMethod>
					</ContactNumber>
				</ContactNumbers>
			</NewEmployee>
		</UpdateEmployee>';
		#var_dump($request);
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		var_dump($msg);
		$result = $client->send($msg, $action);
		var_dump($result);
		#return $result;
		return true;
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
		#var_dump($result);
		if (($result['ReadCustomerResult']['Customer']['CustomerID']))
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
		$e_id = ($client['external_client_id']) ? $client['external_client_id'] : CLIENT_PREFIX . $client['user_id'];
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
		#var_dump($result);
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
		
		$this->load->model('payrun/payrun_model');
		$timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		#return $timesheets;
		usort($timesheets, function($a, $b) { // anonymous function
		    // compare numbers only
		    if (isset($a['external_staff_id'])) {
			    return $a['external_staff_id'] - $b['external_staff_id'];
		    }
		});
		$results = array();
		foreach($timesheets as $timesheet)
		{
			# Check if staff is there
			$employee = $this->read_employee($timesheet['external_staff_id']);
			if (!$employee['EmployeeID'])
			{
				$this->append_employee($timesheet['staff_id']);
				$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
				$timesheet['external_staff_id'] = $staff['external_staff_id'];
			}
			
			$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
			
			$start = '';
			if ($timesheet['date_from'] && $timesheet['date_from'] != '0000-00-00')
			{
				$start = '<PeriodStart>' . date('Y-m-d', strtotime($timesheet['date_from'])) . '</PeriodStart>';
			}
			$finish = '';
			if ($timesheet['date_to'] && $timesheet['date_to'] != '0000-00-00')
			{
				$finish = '<PeriodFinish>' . date('Y-m-d', strtotime($timesheet['date_to'])) . '</PeriodFinish>';
			}
			$pay_date = '';
			if ($timesheet['payable_date'] && $timesheet['payable_date'] != '0000-00-00')
			{
				$pay_date = '<PayDate>' . date('Y-m-d', strtotime($timesheet['payable_date'])) . '</PayDate>';
			}
			
			$request = '<AppendPayslip xmlns="http://www.shoebooks.com.au/accounting/v10/">
				<Login>
					<AccountName>' . $this->account_name . '</AccountName>
					<LoginName>' . $this->login_name . '</LoginName>
					<LoginPassword>' . $this->login_password . '</LoginPassword>
					<SessionID></SessionID>
				</Login>
				<NewPayslip>
					<EmployeeID>' . $timesheet['external_staff_id'] . '</EmployeeID>
					<DateEffect>' . date('Y-m-d') . '</DateEffect>
					<DateAccrual>' . date('Y-m-d') . '</DateAccrual>
					' . $start . '
					' . $finish . '
					<AccountID></AccountID>
					<JobID></JobID>
					' . $pay_date . '				
					<DivID>0</DivID>
					<PayslipLines>';
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
				
				$request .= '
						<PRPayslipLine>
							<EarningID>' . $earningID . '</EarningID>
							<Hours>' . $pay_rate['hours'] . '</Hours>
							<Amount>' . $pay_rate['rate'] . '</Amount>
							<Total>' . ($pay_rate['hours'] * $pay_rate['rate']) . '</Total>
							<WorkDate>' . date('Y-m-d', $pay_rate['start']) . '</WorkDate>
							<Notes>' . $timesheet['job_name'] . ' - ' . $timesheet['venue'] . ' - ' . $timesheet['client'] . ' ' . date('H:i', $pay_rate['start']) . ' - ' . date('H:i', $pay_rate['finish']) . ' ' . $break . '</Notes>
							<DivID>0</DivID>
							<JobID></JobID>
						</PRPayslipLine>';
			}
			$request .= '
					</PayslipLines>
				</NewPayslip>
			</AppendPayslip>';
			#var_dump($request); die();
			$client = new nusoap_client($this->host);
			$error = $client->getError();
			if ($error)
			{
				#die("client construction error: {$error}\n");
				return false;
			}
			$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
			$result = $client->send($msg, $action);
			if ($result['AppendPayslipResult']['ErrorMessage'] == "OK")
			{
				$results[] = $result;
			}
			$this->payrun_model->update_synced($timesheet['timesheet_id'], array(
				'external_id' => $result['AppendPayslipResult']['NewRecordID'],
				'external_msg' => $result['AppendPayslipResult']['ErrorMessage']
			));
				
		}
		return $results;
	}
	
	function read_invoice($external_id)
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/ReadInvoice';
		$request = '<ReadInvoice xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<id>' . $external_id . '</id>
		</ReadInvoice>';
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		var_dump($result);
		if (isset($result['ReadInvoiceResult']['Invoice']))
		{
			return $result['ReadInvoiceResult']['Invoice'];
		}
		return null;
	}
	
	function append_invoice($invoice_id)
	{
		$action = 'http://www.shoebooks.com.au/accounting/v10/AppendInvoice';
		
		$this->load->model('invoice/invoice_model');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		if (!$invoice)
		{
			return false;
		}
		
		$client = modules::run('client/get_client', $invoice['client_id']);
		
		# Check if client is there
		$customer = $this->read_customer($client['external_client_id']);
		if (!$customer)
		{
			$this->append_customer($client['user_id']);
			$client = modules::run('client/get_client', $client['user_id']);
		}
		
		$request = '<AppendInvoice xmlns="http://www.shoebooks.com.au/accounting/v10/">
			<Login>
				<AccountName>' . $this->account_name . '</AccountName>
				<LoginName>' . $this->login_name . '</LoginName>
				<LoginPassword>' . $this->login_password . '</LoginPassword>
				<SessionID></SessionID>
			</Login>
			<NewInvoice>
				<CustomerID>' . $client['external_client_id'] . '</CustomerID>
				<InvoiceDate>' . date('Y-m-d', strtotime($invoice['issued_date'])) . '</InvoiceDate>
				<DueDate>' . date('Y-m-d', strtotime($invoice['due_date'])) . '</DueDate>
				<CustomerPO>' . $invoice['po_number'] . '</CustomerPO>
				<AccountID></AccountID>
				<DivID>0</DivID>
				<InvoiceLines>';
		
		$invoice_items = $this->invoice_model->get_invoice_items($invoice_id);
		
		foreach($invoice_items as $item)
		{
			if ($item['include_timesheets']) # Item that include timesheets
			{
				$timesheets = modules::run('invoice/get_invoice_timesheets', $invoice_id, $item['job_id']);
				foreach($timesheets as $timesheet)
				{
					$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id'], 1);
					$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
					
					foreach($pay_rates as $pay_rate)
					{
						$break = '';
						if ($pay_rate['break']) {
							$break = ' w/ ' . $pay_rate['break'] / 3600 . ' hour break';
						}
						# Taxable = 'Code1' which is always tax included
						$rate = $pay_rate['rate'] * 10 / 11;
						$request .= '
					<ARInvoiceLine>
						<QtyOrdered>' . $pay_rate['hours'] . '</QtyOrdered>
						<QtyShipped>' . $pay_rate['hours'] . '</QtyShipped>
						<Description>' . trim($staff['first_name'] . ' ' . $staff['last_name'] . ' ' . date('H:ia', $pay_rate['start']) . ' - ' . date('H:ia', $pay_rate['finish']) . ' ' . $break) . '</Description>
						<AccountID></AccountID>
						<JobID></JobID>
						<Taxable>Code1</Taxable>
						<SalesPrice>' . $rate . '</SalesPrice>
						<DivID>0</DivID>
						<ItemDate>' . date('Y-m-d', $pay_rate['start']) . '</ItemDate>
					</ARInvoiceLine>';
					}
				}
			}
			else
			{
				$tax = $item['tax'];
				$amount = $item['amount'];
				$tax_amount = 0;
				$ex_tax_amount = $amount;
				$inc_tax_amount = $amount;
				$taxable = 'Code2';
				if ($tax == GST_YES || $tax == GST_ADD) {
					$tax_amount = $amount/11;
					$ex_tax_amount = $amount * 10/11;
					$inc_tax_amount = $amount;
					$taxable = 'Code1';
				} 
				$request .= '
					<ARInvoiceLine>
						<QtyOrdered>1</QtyOrdered>
						<QtyShipped>1</QtyShipped>
						<Description>' . trim($item['title']) . '</Description>
						<AccountID></AccountID>
						<JobID></JobID>
						<Taxable>' . $taxable . '</Taxable>
						<SalesPrice>' . $ex_tax_amount . '</SalesPrice>
						<DivID>0</DivID>
						<ItemDate>' . date('Y-m-d', strtotime($invoice['issued_date'])) . '</ItemDate>
					</ARInvoiceLine>';
			}
		}
		
		$request .= '
				</InvoiceLines>
			</NewInvoice>
		</AppendInvoice>';
		#var_dump($request); die();
		$client = new nusoap_client($this->host);
		$error = $client->getError();
		if ($error)
		{
			#die("client construction error: {$error}\n");
			return false;
		}
		$msg = $client->serializeEnvelope($request, '', array(), 'document', 'encoded', '');
		$result = $client->send($msg, $action);
		#var_dump($result);
		if (isset($result['AppendInvoiceResult']['NewRecordID']))
		{
			return $this->invoice_model->update_invoice($invoice_id, array('external_id' => $result['AppendInvoiceResult']['NewRecordID']));
		}
		return false;
	}
}