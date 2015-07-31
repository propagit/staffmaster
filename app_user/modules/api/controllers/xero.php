<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Xero API
 */

class Xero extends MX_Controller {

    var $app_type;
    var $user_agent;
    var $oauth_callback;
    var $signatures = array();
    var $XeroOAuth;

    function __construct()
    {
        require_once(APPPATH . 'libraries/xero/lib/XeroOAuth.php');
        parent::__construct();
        $this->app_type = 'Private'; # Partner
        $this->c = 'oob';
        $this->user_agent = 'StaffBookks_Private';
        $this->signatures = array(
			'consumer_key' => $this->config_model->get('xero_consumer_key'),
            'shared_secret' => $this->config_model->get('xero_shared_secret'),
			# demo
            #'consumer_key' => 'U8PV3ETRIVPW7F6NVCP7BICHBIT4QS',
            #'shared_secret' => '6CHG5QVKWGREAYMCW23BHC6KDBZZW3',
			
            // API versions
            'core_version' => '2.0',
            'payroll_version' => '1.0',
            'file_version' => '1.0',
            'rsa_private_key' => APPPATH . 'libraries/xero/certs/privatekey.pem',
            'rsa_public_key' => APPPATH . 'libraries/xero/certs/publickey.cer'
        );
        $this->XeroOAuth = new XeroOAuth ( array_merge ( array (
                'application_type' => $this->app_type,
                'oauth_callback' => $this->oauth_callback,
                'user_agent' => $this->user_agent
        ), $this->signatures ) );

        $this->XeroOAuth->config['access_token'] = $this->XeroOAuth->config['consumer_key'];
        $this->XeroOAuth->config['access_token_secret'] = $this->XeroOAuth->config['shared_secret'];

        $initialCheck = $this->XeroOAuth->diagnostics ();
        $checkErrors = count ( $initialCheck );
        if ($checkErrors > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
        }
    }

    function get_superfunds()
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('SuperFunds', 'payroll'), array());

        if ($this->XeroOAuth->response['code'] == 200) {
            $superfunds = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($superfunds->SuperFunds), TRUE);
            return $result['SuperFund'];
        }
    }

    function read_superfunds()
    {
        var_dump($this->get_superfunds());
    }

    function get_superfund($id)
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('SuperFunds/' . $id, 'payroll'), array());

        if ($this->XeroOAuth->response['code'] == 200) {
            $superfunds = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($superfunds->SuperFunds), TRUE);
            return $result['SuperFund'];
        }
    }

    function read_superfund($id)
    {
        $s = $this->get_superfund($id);
        var_dump($s);
    }

    function get_employees() {
       /* $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees', 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            return $result['Employee'];
        }
        return null;*/
		$count = 1;
		$staff = array();
		$more_staff = true;
		
		while($more_staff){
			$response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees', 'payroll'), array('page' => $count));
			if ($this->XeroOAuth->response['code'] == 200) {
				$employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
				$result = json_decode(json_encode($employees->Employees[0]), TRUE);
				if(isset($result['Employee'])){
					$staff = array_merge($staff,$result['Employee']);
				}else{
					$more_staff = false;	
				}
			}else{
				$more_staff = false;		
			}
			$count++;
		}
		return $staff;
    }

    function read_employees() {
        var_dump($this->get_employees());
    }

    function get_employee($id) {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees/' . $id, 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            return $result['Employee'];
			#var_dump($result['Employee']);
        }
        return null;
    }

    function read_employee($id) {
        $e = $this->get_employee($id);
        var_dump($e);
    }

    function add_employee($user_id, $bypass_error = false) {
        $staff = modules::run('staff/get_staff', $user_id);
        if (!$staff)
        {
            return false;
        }

        $dob = '';
        if ($staff['dob'] && $staff['dob'] != '0000-00-00') {
            $dob = $staff['dob'];
        }
        $city = $staff['city'];
        if (!$city) { $city = $staff['suburb']; }
        if (!$city) { $city = 'Not Specified'; }	
	
		$xml = "<Employees>
                    <Employee>
                        <FirstName>" . $staff['first_name'] . "</FirstName>
                        <LastName>" . $staff['last_name'] . "</LastName>
                        <Email>" . $staff['email_address'] . "</Email>
                        <Title>" . $staff['title'] . "</Title>
                        <DateOfBirth>$dob</DateOfBirth>
                        <Gender>" . ucwords($staff['gender']) . "</Gender>
                        <Phone>" . ($staff['phone'] ? $staff['phone'] : "Not Specified" ) . "</Phone>
                        <Mobile>" . ($staff['mobile'] ? $staff['mobile'] : "Not Specified" ) . "</Mobile>
                        <HomeAddress>
                            <AddressLine1>" . ($staff['address'] ? $staff['address'] : "Not Specified") . "</AddressLine1>
                            <City>$city</City>
                            <Region>" . ($staff['state'] ? $staff['state'] : "VIC") . "</Region>
                            <PostalCode>" . ($staff['postcode'] ? $staff['postcode'] : "0000") . "</PostalCode>
                            <Country>" . ($staff['country'] ? $staff['country'] : "Not Specified") . "</Country>
                        </HomeAddress>
                    </Employee>
                </Employees>";
			
        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Employees', 'payroll'), array(), $xml);
		
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            // var_dump($result['Employee']);

            $this->load->model('staff/staff_model');
            $this->staff_model->update_staff($user_id, array('external_staff_id' => $result['Employee']['EmployeeID']),true);
			
			#update staff other informations
			return $this->update_employee($result['Employee']['EmployeeID'], $bypass_error);
			
            #return $result['Employee'];
        }
		
		# Api exception
		if ($this->XeroOAuth->response['code'] == 400){
			# When this happens an Api Excetion has happened, as the code to add employee has been pre validated for all required fields.
			# this exception can be because of bad data format such as year being over the current year such as 2092 etc			
			echo 'api-exception';
			return;
		}
    }

    function update_employee($external_id, $bypass_error = false)
    {
        $staff = modules::run('staff/get_staff_by_external_id', $external_id);
        if (!$staff)
        {
            return false;
        }
        $employee = $this->get_employee($external_id);
		#echo '<pre>'.print_r($employee,true).'</pre>';exit;
        $dob = '';
        if ($staff['dob'] && $staff['dob'] != '0000-00-00') {
            $dob = $staff['dob'];
        }
        $city = $staff['city'];
        if (!$city) { $city = $staff['suburb']; }
        if (!$city) { $city = 'Not Specified'; }
		
		# staff optional fields
		$staff_phone = '';
		if($staff['phone']){
			$staff_phone = "<Phone>" . $staff['phone']. "</Phone>";
		}
		
		$staff_mobile = '';
		if($staff['mobile']){
			$staff_mobile = "<Mobile>" . $staff['mobile']. "</Mobile>";
		}
		
		$staff_gender = '';
		if($staff['gender']){
			$staff_gender = "<Gender>" . strtoupper($staff['gender']) . "</Gender>";
		}
		
        $super = '';
		
		# check if staff has super set up in xero
		$super_membership_id = '';
		if (isset($employee['SuperMemberships']['SuperMembership'])){
					
			# check for multiple super in xero
			$xero_super_accounts = $employee['SuperMemberships'];
			if(isset($employee['SuperMemberships']['SuperMembership'][0])){
				$xero_super_accounts = $employee['SuperMemberships']['SuperMembership'];
			}
			foreach($xero_super_accounts as $sup_account) {
				# get super membership id of the first one
				$super_membership_id = $sup_account['SuperMembershipID'];
				break; 	
			 }
		}	
			
		 # check if staff has chosen his own super fund
		 if(trim($staff['s_employee_id'])){	
			 if($staff['s_choice'] == 'own'){
				if($staff['s_external_id'] && $staff['s_employee_id']){
					
					# if super account is set on xero
					if ($super_membership_id){
						$super .= "<SuperMemberships>
									<SuperMembership>
									  <SuperMembershipID>" . $super_membership_id . "</SuperMembershipID>
									  <SuperFundID>" . $staff['s_external_id'] . "</SuperFundID>
									  <EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
									</SuperMembership>
								  </SuperMemberships>";
		
					}else{ 
						# create new super on xero
						$super .= "<SuperMemberships>
									<SuperMembership>
									  <SuperFundID>" . $staff['s_external_id'] . "</SuperFundID>
									  <EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
									</SuperMembership>
								  </SuperMemberships>";	
					}
				}
			  }else{
					# if staff has chosen employer super fund i.e. s_choice == employer
					$id = modules::run('setting/superinformasi', 'super_fund_external_id');
					if ($id) {
						if ($super_membership_id){
						$super .= "<SuperMemberships>
									<SuperMembership>
										<SuperMembershipID>" . $super_membership_id . "</SuperMembershipID>
										<SuperFundID>" . $id. "</SuperFundID>
										<EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
									</SuperMembership>
								  </SuperMemberships>";
		
						}else{ 
							# create new super on xero
							$super .= "<SuperMemberships>
										<SuperMembership>
										  <SuperFundID>" . $id . "</SuperFundID>
										  <EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
										</SuperMembership>
									  </SuperMemberships>";	
						}
					}else{
						echo json_encode(array('ok' => false, 'error_id' => '', 'msg' => 'Your employer has not set any default Super Funds. Please select your own super.'));
						exit;return;	
					}
			  }
		  }
	
		
        $bank_accounts = '';
	
        if (isset($employee['BankAccounts']['BankAccount']))
        {
            $bank_accounts .= "<BankAccounts>";
			
			# check if staff has more than one bank accoun in xero
			$emp_bank_accounts = $employee['BankAccounts'];
			if(isset($employee['BankAccounts']['BankAccount'][0])){
				$emp_bank_accounts = $employee['BankAccounts']['BankAccount'];
			}
			
            foreach($emp_bank_accounts as $account) {
				
                if (isset($account['Remainder']) && $account['Remainder'] == "true") {
                    $bank_accounts .= "
                            <BankAccount>
                                <StatementText>" . $account['StatementText'] . "</StatementText>
                                <AccountName>" . $staff['f_acc_name'] . "</AccountName>
                                <BSB>" . $staff['f_bsb'] . "</BSB>
                                <AccountNumber>" . $staff['f_acc_number'] . "</AccountNumber>
                                <Remainder>true</Remainder>
                            </BankAccount>";
                } else {
                    $bank_accounts .= "
                            <BankAccount>
                                <StatementText>" . $account['StatementText'] . "</StatementText>
                                <AccountName>" . $account['AccountName'] . "</AccountName>
                                <BSB>" . $account['BSB'] . "</BSB>
                                <AccountNumber>" . $account['AccountNumber'] . "</AccountNumber>
                                <Remainder>" . $account['Remainder'] . "</Remainder>
                                <Amount>" . $account['Amount'] . "</Amount>
                            </BankAccount>";
                }
            }
            $bank_accounts .= "
                </BankAccounts>";

				
		}else{
			# if no bank account has been set
			if($staff['f_acc_name'] && $staff['f_bsb'] && $staff['f_acc_number']){
				$bank_accounts = "<BankAccounts>
									<BankAccount>
										<StatementText>Saving</StatementText>
										<AccountName>" . $staff['f_acc_name'] . "</AccountName>
										<BSB>" . $staff['f_bsb'] . "</BSB>
										<AccountNumber>" . $staff['f_acc_number'] . "</AccountNumber>
										<Remainder>true</Remainder>
									</BankAccount>
								</BankAccounts>";	
							
			}
		}
	
		
		# staff tfn - xero validates valid tfn
		$tax = '';
		if(trim($staff['f_tfn'])){	
			# Check EmploymentBasis
			$employment_basis = isset($employee['TaxDeclaration']['EmploymentBasis']) ? $employee['TaxDeclaration']['EmploymentBasis'] : 'CASUAL';
			
			$tax = "
				<TaxDeclaration>
					<EmploymentBasis>" . $employment_basis . "</EmploymentBasis>
					<TFNPendingOrExemptionHeld>false</TFNPendingOrExemptionHeld>
					<AustralianResidentForTaxPurposes>" . ($staff['f_aus_resident'] ? 'true' : 'false') . "</AustralianResidentForTaxPurposes>
					<TaxFreeThresholdClaimed>" . ($staff['f_tax_free_threshold'] ? 'true' : 'false') . "</TaxFreeThresholdClaimed>
					<HasHELPDebt>" . ($staff['f_help_debt'] ? 'true' : 'false') . "</HasHELPDebt>
					<TaxFileNumber>" . $staff['f_tfn'] . "</TaxFileNumber>
					<EmploymentBasis>" . (isset($employee['TaxDeclaration']['EmploymentBasis']) ? $employee['TaxDeclaration']['EmploymentBasis'] : 'LABOURHIRE') . "</EmploymentBasis>
				</TaxDeclaration>
				";
		}	

        $xml = "<Employees>
                    <Employee>
                        <EmployeeID>$external_id</EmployeeID>
                        <FirstName>" . $staff['first_name'] . "</FirstName>
                        <LastName>" . $staff['last_name'] . "</LastName>
						<Email>" . $staff['email_address'] . "</Email>
						$staff_gender
						$staff_mobile
						$staff_phone
                        <DateOfBirth>$dob</DateOfBirth>
                        <Status>ACTIVE</Status>
                        <HomeAddress>
                            <AddressLine1>" . ($staff['address'] ? $staff['address'] : "Not Specified") . "</AddressLine1>
                            <City>$city</City>
                            <Region>" . ($staff['state'] ? $staff['state'] : "VIC") . "</Region>
                            <PostalCode>" . ($staff['postcode'] ? $staff['postcode'] : "0000") . "</PostalCode>
                            <Country>" . ($staff['country'] ? $staff['country'] : "Not Specified") . "</Country>
                        </HomeAddress>
						$tax	
                        $bank_accounts
                        $super
                    </Employee>
                </Employees>";
       	#var_dump($xml); die();
        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Employees', 'payroll'), array(), $xml);
        #var_dump($response);exit();
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            #var_dump($result['Employee']);exit;
			if($bypass_error){
				return array('xero_exception_occured' => false);
			}else{
            	return $result['Employee'];
			}
        }
		
		# validation error 
		if ($this->XeroOAuth->response['code'] == 400){
						
			$validation_err = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$result = json_decode(json_encode($validation_err->Employees[0]), TRUE);
			
			$xml = $this->XeroOAuth->response['response'];
			#var_dump($xml);
			$regex = "#<ValidationErrors><ValidationError><Message>(.*?)</Message></ValidationError></ValidationErrors>#";
			$message = preg_match($regex, $xml, $errors);
			#print_r($errors);
			#var_dump($xml);
			#var_dump($errors);exit;
			#var_dump($result['Employee']);exit;return;
			
			if($bypass_error){
				return array('xero_exception_occured' => $errors[1]);
			}else{
				# this is when individual staff is being updated.
				echo json_encode(array('ok' => false, 'error_id' => '', 'msg' => $errors[1]));
				exit;return;
			}
		}
        return false;
    }

    function get_payruns()
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('PayRuns', 'payroll'), array('Where' => 'PayRunStatus=="DRAFT"'));
        if ($this->XeroOAuth->response['code'] == 200) {
            $payruns = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($payruns->PayRuns), TRUE);
            return isset($result['PayRun']) ? $result['PayRun'] : false;
        }
    }

    function read_payruns()
    {
        var_dump($this->get_payruns());
    }

    function get_payrun($id)
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('PayRuns/' . $id, 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $payruns = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($payruns->PayRuns), TRUE);
            return $result['PayRun'];
        }
    }
	
	function read_payrun($id)
	{
		var_dump($this->get_payrun($id));	
	}

    function get_payitems()
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('PayItems', 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $payitems = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($payitems->PayItems), TRUE);
            return $result['EarningsRates']['EarningsRate'];
        }
    }

    function read_payitems()
    {
        var_dump($this->get_payitems());
    }

    function get_timesheets()
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Timesheets', 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $timesheets = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($timesheets->Timesheets), TRUE);
            return $result['Timesheet'];
        }
    }

    function read_timesheets()
    {
        var_dump($this->get_timesheets());
    }

    function get_timesheet($id)
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Timesheets/' . $id, 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $timesheet = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($timesheet), TRUE);
            return $result['Timesheet'];
        }
    }

    function read_timesheet($id)
    {
        $t = $this->get_timesheet($id);
        var_dump($t);
    }

    function validate_timesheet_payitems($timesheet_id)
    {
        $timesheet = modules::run('timesheet/get_timesheet', $timesheet_id);

        # Check payitem for employee on Xero
        $pay_items = array();
        foreach($this->get_payitems() as $pay_item)
        {
            $pay_items[] = $pay_item['Name'];
        }

        $pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
        $not_found = array();
        foreach($pay_rates as $pay_rate)
        {
            $earningID = $pay_rate['group'];
            if (!$earningID)
            {
                $payrate = modules::run('attribute/payrate/get_payrate', $timesheet['payrate_id']);
                $earningID = $payrate['name'];
            }

            # Make sure all the payroll categories are set up on Xero
            if (!in_array($earningID, $pay_items))
            {
                $not_found[] = $earningID;
            }
        }
       return $not_found;

        if (count($not_found) > 0) {
            $result = array(
                'ok' => false,
                'msg' => "<p>Pay Item <b>" . implode(", ", $not_found) . "</b> is not found in XERO</p>"
            );
            return $result;
        }
    }
	
	
    function validate_timesheet_employee_payitems($timesheet_id,$xero_payrun_id = '')
    {
        $timesheet = modules::run('timesheet/get_timesheet', $timesheet_id);
        $staff = modules::run('staff/get_staff', $timesheet['staff_id']);
		
        $errors = array();
        if ($staff['external_staff_id']) {
            #$employee = $this->read_employee($staff['external_staff_id']);
			$employee = $this->get_employee($staff['external_staff_id']);
			
			#echo '<pre>'.print_r($employee,true).'</pre>';exit;
			
            if ($employee) {				
				# Check if employee has Pay calendar & OrdinaryEarningsRateID 
				if(!isset($employee['PayrollCalendarID'])){
					$errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - has no payroll calendar<br>";
				}else{
					# Check if Pay Period falls under 
					$cur_payrun = $this->get_payrun($xero_payrun_id);
					if($cur_payrun['PayrollCalendarID'] != $employee['PayrollCalendarID']){
						$errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - payrun calender do not match the selected payrun calender<br>";
					}
				}
				
				if(!isset($employee['OrdinaryEarningsRateID'])){
					$errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - has no ordinary earning rate<br>";
				}
				
				
                $pay_items = $this->get_payitems();
				# Extract employee earning ids
				$earnings = array();
				
				# Check if any payrates has been set for this employee
				if(isset($employee['PayTemplate']['EarningsLines']['EarningsLine'])){
					
					# Convert employee earning ids -> names
					# Check if multiple payrates has been set for this employee in xero
					if(isset($employee['PayTemplate']['EarningsLines']['EarningsLine'][0])){		
						foreach($employee['PayTemplate']['EarningsLines']['EarningsLine'] as $earning_line)
						{
							foreach($pay_items as $item)
							{
								if ($item['EarningsRateID'] == $earning_line['EarningsRateID'])
								{
									$earnings[] = $item['Name'];
								}
							}
						}
					}else{
						foreach($pay_items as $item)
							{
								if ($item['EarningsRateID'] == $employee['PayTemplate']['EarningsLines']['EarningsLine']['EarningsRateID'])
								{
									$earnings[] = $item['Name'];
								}
							}
					}
				}
				
                # Check if time sheet pay rate is in employee earnings

                $pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
                foreach($pay_rates as $pay_rate)
                {
                    $earningID = $pay_rate['group'];
                    if (!$earningID)
                    {
                        $payrate = modules::run('attribute/payrate/get_payrate', $timesheet['payrate_id']);
                        $earningID = $payrate['name'];
                    }
                    if (!in_array($earningID, $earnings))
                    {
                        $errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - is missing the pay template [$earningID]<br>";
                    }
                }
            }
            else {
                $errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - was found<br>";
            }
        }
        else {
            $errors[] = "Employee " . $staff['first_name'] . " " . $staff['last_name'] . " - was not found<br>";
        }
		#var_dump($errors);die();
        return $errors;

    }
	
	# function to create an array of EarningRateID with their Name as key.
	# this is usefull when pushing timesheet to xero
	function get_payitems_by_name(){
		$pay_items = $this->get_payitems();
		#var_dump($pay_items);exit;
		foreach($pay_items as $item){
			$earnings[$item['Name']] = $item['EarningsRateID'];
		}
		return $earnings;
	}

    function create_timesheets($payrun_id)
    {	
		#echo $payrun_id;exit;return;
        $this->load->model('payrun/payrun_model');
        $timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		$payrun = $this->payrun_model->get_payrun($payrun_id);
		
		# get payrates from zero
		$xero_payrates = $this->get_payitems_by_name();
		
		# number of days in payrun
		$date_diff = (strtotime($payrun['date_to']) - strtotime($payrun['date_from'])) / (60*60*24);
		
		$xero_arr = $this->sort_array($timesheets,'external_staff_id');
		
		#echo '<pre>' . print_r($xero_arr,true) . '</pre>';exit;
		$xml = "";
		foreach($xero_arr as $key => $val){
			$xml .= "
					<Timesheet>
						<EmployeeID>" . $key . "</EmployeeID>
						<StartDate>" . $payrun['date_from'] . "</StartDate>
						<EndDate>" . $payrun['date_to']. "</EndDate>
						<Status>Draft</Status>
						<TimesheetLines>
					";
			
			 # this returns an array for each staff's timesheet grouped by payrate			
			 $line_arr = $this->sort_array($val,'payrate');	
			 
			 # the key for this array is the payrate, which we will use to get the payrate id or EarningsRateID in xero
			 foreach($line_arr as $k => $v){
				$xml .= $this->create_number_of_units($v,$date_diff,$payrun['date_from'],$xero_payrates[$k],$xero_payrates);	
			 } #foreaeach ($line_arr...)
				
			 $xml .= "	</TimesheetLines>
                	  </Timesheet>
					";
			
		}
		$final_xml = " <Timesheets>$xml</Timesheets>";
		
		$response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Timesheets', 'payroll'), array(), $final_xml);
		#return var_dump($response);
		if ($this->XeroOAuth->response['code'] == 200) {
			$timesheet = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$result = json_decode(json_encode($timesheet->Timesheets), TRUE);

			
			$result_arr = $result;
			if(isset($result['Timesheet'][0])){
				$result_arr = $result['Timesheet'];
			}
			
			
			
			$msg = array(
							'msg' => 'Xero Push Successful',
							'pay_period_to' => $payrun['date_to'],
							'pay_period_from' => $payrun['date_from'] 
						);
			
			foreach($result_arr as $t){
				#echo $t['EmployeeID']."<br>".$t['TimesheetID'];
				foreach($xero_arr as $key => $val){
					if($t['EmployeeID'] == $key){
						foreach($val as $v){
							$this->payrun_model->update_synced($v['timesheet_id'], array(
								'external_id' => $t['TimesheetID'],
								'external_msg' => json_encode($msg)
							));	
						}
					}
				}
			}
			return json_encode(array('ok' => true, 'error_id' => '', 'msg' => ''));
		}
		# error
		if ($this->XeroOAuth->response['code'] == 400) {
			$validation_err = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$result = json_decode(json_encode($validation_err->Employees[0]), TRUE);
			
			$xml = $this->XeroOAuth->response['response'];
			#var_dump($xml);exit;
			$regex = "#<Message>(.*?)</Message>#";
			$message = preg_match($regex, $xml, $errors);
			#print_r($errors);exit;
			#var_dump($xml);
			#var_dump($errors);exit;
			#var_dump($result['Employee']);exit;return;
			return json_encode(array('ok' => false, 'error_id' => '', 'msg' => $errors[1]));
		}
    }
	
	# for testing the payrun xml output
	function xero_ts()
	{
		die();
		$payrun_id = 1;
		$this->load->model('payrun/payrun_model');
        $timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		
		
		$payrun = $this->payrun_model->get_payrun($payrun_id);
		
		#print_r($timesheets);exit;
		
		# get payrates from zero
		$xero_payrates = $this->get_payitems_by_name();
		
		# number of days in payrun
		$date_diff = (strtotime($payrun['date_to']) - strtotime($payrun['date_from'])) / (60*60*24);
		
		$xero_arr = $this->sort_array($timesheets,'external_staff_id');
		#echo '<pre>' . print_r($xero_arr,true) . '</pre>';exit;
		$xml = "";
		foreach($xero_arr as $key => $val){
			$xml .= "
					<Timesheet>
						<EmployeeID>" . $key . "</EmployeeID>
						<StartDate>" . $payrun['date_from'] . "</StartDate>
						<EndDate>" . $payrun['date_to']. "</EndDate>
						<Status>Draft</Status>
						<TimesheetLines>
				    ";
			
			 # this returns an array for each staff's timesheet grouped by payrate			
			 $line_arr = $this->sort_array($val,'payrate');	
			 
			 # the key for this array is the payrate, which we will use to get the payrate id or EarningsRateID in xero
			 foreach($line_arr as $k => $v){
				$xml .= $this->create_number_of_units($v,$date_diff,$payrun['date_from'],$xero_payrates[$k],$xero_payrates);
			 } #foreaeach ($line_arr...)
				
			 $xml .= "	 
						</TimesheetLines>
                	</Timesheet>
					";
		}
		
		$final_xml = " <Timesheets>$xml</Timesheets>";
		
		echo $final_xml;exit;
		
		#$response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Timesheets', 'payroll'), array(), $final_xml);
		#return var_dump($response);exit;
		if ($this->XeroOAuth->response['code'] == 200) {
			$timesheet = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$result = json_decode(json_encode($timesheet->Timesheets), TRUE);

			
			$result_arr = $result;
			if(isset($result['Timesheet'][0])){
				$result_arr = $result['Timesheet'];
			}
			
			
			
			$msg = array(
							'msg' => 'Xero Push Successful',
							'pay_period_to' => $payrun['date_to'],
							'pay_period_from' => $payrun['date_from'] 
						);
			
			foreach($result_arr as $t){
				#echo $t['EmployeeID']."<br>".$t['TimesheetID'];
				foreach($xero_arr as $key => $val){
					if($t['EmployeeID'] == $key){
						foreach($val as $v){
							$this->payrun_model->update_synced($v['timesheet_id'], array(
								'external_id' => $t['TimesheetID'],
								'external_msg' => json_encode($msg)
							));	
						}
					}
				}
			}
			
			echo json_encode(array('ok' => true, 'error_id' => '', 'msg' => ''));
			return;
		}
		# error
		if ($this->XeroOAuth->response['code'] == 400) {
			$validation_err = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$result = json_decode(json_encode($validation_err->Employees[0]), TRUE);
			
			$xml = $this->XeroOAuth->response['response'];
			#var_dump($xml);exit;
			$regex = "#<Message>(.*?)</Message>#";
			$message = preg_match($regex, $xml, $errors);
			#print_r($errors);exit;
			#var_dump($xml);
			#var_dump($errors);exit;
			#var_dump($result['Employee']);exit;return;
			echo json_encode(array('ok' => false, 'error_id' => '', 'msg' => $errors[1]));
			return; exit;
		}
	
		
	}
	
	function create_number_of_units($timesheet,$no_of_days,$payrun_start_date,$xero_earning_rate_id,$xero_payrates)
	{
		$no_of_units = array();
		$cur_ts_id = '';
		$get_diff_payrate = true;
		$temp_no_of_units = array();

		for($i = 0; $i <= $no_of_days; $i++){
			#$no_of_units[$i] = "<NumberOfUnit>0.00</NumberOfUnit>";	
			foreach($timesheet as $line){
				#$earning_rate_id = $xero_earning_rate_id;
				# check if timesheet has different payrates depending on the time of the day configured in StaffBooks payrate template
				# not ideal but this was added later on to the system on a short notice - to be made more robust on future updates
				
				# a check to avoid quering the extract_timesheet_payrate for the same timesheet over and over again 
				if(!$cur_ts_id){
					$cur_ts_id = $line['timesheet_id'];
				}else{
					if($cur_ts_id != $line['timesheet_id']){
						#new timesheet
						$get_diff_payrate = true;
						$cur_ts_id = $line['timesheet_id'];	
						
					}else{
						$get_diff_payrate = false;	
					}
				}
				# get timesheet payrates
				if($get_diff_payrate){
					$diff_payrates = modules::run('timesheet/extract_timesheet_payrate',$line['timesheet_id'], $user_type = 0);
				}


				foreach($diff_payrates as $dp){
					$total_hour = $dp['hours'];
					if($dp['group'] != ''){
						$earning_rate_id = $xero_payrates[$dp['group']];
					}else{
						# use xero_earning_rate_id passed to the function
						$earning_rate_id = $xero_earning_rate_id;	
					}
					if($line['job_date'] == date('Y-m-d',strtotime($payrun_start_date . "+$i days"))){
						if($temp_no_of_units[$earning_rate_id][$i]){
							$total_hour += $temp_no_of_units[$earning_rate_id][$i];	
						}
						$no_of_units[$earning_rate_id][$i] = "<NumberOfUnit>" . $total_hour . "</NumberOfUnit>";	
						$temp_no_of_units[$earning_rate_id][$i] = $total_hour;	
						
					}else{
						if($temp_no_of_units[$earning_rate_id][$i]){
							$total_hour = $temp_no_of_units[$earning_rate_id][$i];	
						}else{
							$total_hour = '0.00';	
						}
						$no_of_units[$earning_rate_id][$i] = "<NumberOfUnit>" . $total_hour . "</NumberOfUnit>";		
					}
				}
			} 	 #foreach timesheet as line				
		}
	
		#$units = implode("",$no_of_units);
		$xml = "";
		foreach($no_of_units as $key => $nou){
			$xml .= "<TimesheetLine>
						<EarningsRateID>" . $key . "</EarningsRateID>
							<NumberOfUnits>
								" . implode("",$nou) . "
							</NumberOfUnits>
					</TimesheetLine>"; 	
		}
		
		/*$xml = "<TimesheetLine>
					<EarningsRateID>" . $xero_earning_rate_id . "</EarningsRateID>
						<NumberOfUnits>
							$units
						</NumberOfUnits>
				</TimesheetLine>";*/
		return $xml;
	}
	
	# sorts timesheet by key
	function sort_array($array,$sort_key)
	{
		$sorted = array();
		foreach($array as $arr){
			$sorted[$arr[$sort_key]][] = $arr;	
		}
		return $sorted;
		
	}
	
	function get_staff_csv()
	{
		$staff = $this->get_employees();
		
		$csvname = 'anderson_staff.csv';
		
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		
		$fp = fopen("php://output", 'w');
		
		$headings = array(
								'EmployeeID',
								'FirstName',
								'LastName',
								'Email'
							);
		
		fputcsv($fp,$headings);
		
		foreach($staff as $s){
			fputcsv($fp,
						array(
							isset($s['EmployeeID']) ? $s['EmployeeID'] : 'NA',
							isset($s['FirstName']) ? $s['FirstName'] : 'NA',
							isset($s['LastName']) ? $s['LastName'] : 'NA',
							isset($s['Email']) ? $s['Email'] : 'NA'
							)
					);	
		}
		fclose($fp);
	}
}
