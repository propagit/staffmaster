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
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees', 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            return $result['Employee'];
        }
        return null;
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
        }
        return null;
    }

    function read_employee($id) {
        $e = $this->get_employee($id);
        var_dump($e);
    }

    function add_employee($user_id) {
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
            return $this->staff_model->update_staff($user_id, array('external_staff_id' => $result['Employee']['EmployeeID']),true);

            #return $result['Employee'];
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
		# if super account is set on xero
        if (isset($employee['SuperMemberships']['SuperMembership'])){
			
			# check for multiple super in xero
			$xero_super_accounts = $employee['SuperMemberships'];
			if(isset($employee['SuperMemberships']['SuperMembership'][0])){
				$xero_super_accounts = $employee['SuperMemberships']['SuperMembership'];
			}
			$super .= "<SuperMemberships>";
			$super_set = false; # to check while looping if a super fund has been set
			foreach($xero_super_accounts as $sup_account) {
				# since staffbooks do not support multiple super and hence no primary key to use, we have to make lemonade with what we have
				if($sup_account['SuperFundID'] == $staff['s_external_id'] && !$super_set){
					# found a matching super fund provider, and we are going to update it
					$super_set = true;
					$super .= "<SuperMembership>
									<SuperMembershipID>" . $sup_account['SuperMembershipID'] . "</SuperMembershipID>
									<SuperFundID>" . $staff['s_external_id'] . "</SuperFundID>
									<EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
								</SuperMembership>";
				}else{
					$super .= "<SuperMembership>
									<SuperMembershipID>" . $sup_account['SuperMembershipID'] . "</SuperMembershipID>
									<SuperFundID>" . $sup_account['SuperFundID'] . "</SuperFundID>
									<EmployeeNumber>" . $sup_account['EmployeeNumber'] . "</EmployeeNumber>
								</SuperMembership>";
				}
						
			 }
			 $super .= "</SuperMemberships>";
        }else{
			# if super details is set on staffbooks push this details to xero
			if($staff['s_external_id'] && $staff['s_employee_id']){
				$super .= "<SuperMemberships>
							<SuperMembership>
							  <SuperFundID>" . $staff['s_external_id'] . "</SuperFundID>
							  <EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
							</SuperMembership>
						  </SuperMemberships>";	
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
	
		
		# staff tfn - it looks like xero validates TFN - when i added my real TFN it worked but any garbage TFN was not added
		$tax = '';
		if($staff['f_tfn']){		
			$tax = "
				<TaxDeclaration>
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
            return $result['Employee'];
        }
		
		# validation error 
		if ($this->XeroOAuth->response['code'] == 400){
			# We have only check on TFN for now, later we need to parse into each array to get all errors
			
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
			echo json_encode(array('ok' => false, 'error_id' => '', 'msg' => $errors[1]));
			exit;return;
		}
        return false;
    }

    function get_payruns()
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('PayRuns', 'payroll'), array('Where' => 'PayRunStatus=="DRAFT"'));
        if ($this->XeroOAuth->response['code'] == 200) {
            $payruns = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($payruns->PayRuns), TRUE);
            return $result['PayRun'];
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

            # Make sure all the payroll categories are set up on MYOB
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
	
	# add a check so that any jobs that does not falls on the pay period is not added here
	# still to do
	
    function validate_timesheet_employee_payitems($timesheet_id)
    {
        $timesheet = modules::run('timesheet/get_timesheet', $timesheet_id);
        $staff = modules::run('staff/get_staff', $timesheet['staff_id']);
		
        $errors = array();
        if ($staff['external_staff_id']) {
            #$employee = $this->read_employee($staff['external_staff_id']);
			$employee = $this->get_employee($staff['external_staff_id']);
			
            if ($employee) {
                $pay_items = $this->get_payitems();

                # Extract employee earning ids
                $earnings = array();
                # Convert employee earning ids -> names
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
                        $errors[] = "<p>$earningID has not been set up for employee " . $staff['first_name'] . " " . $staff['last_name'] . " on Xero</p>";
                    }
                }
            }
            else {
                $errors[] = "<p>" . $staff['first_name'] . " " . $staff['last_name'] . " not found in Xero</p>";
            }
        }
        else {
            $errors[] = "<p>" . $staff['first_name'] . " " . $staff['last_name'] . " not found in Xero</p>";
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
				$xml .= $this->create_number_of_units($v,$date_diff,$payrun['date_from'],$xero_payrates[$k]);
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
		}
    }
	
	# for testing the payrun xml output
	function _xero_ts()
	{
		$payrun_id = 1;
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
			$xml = "
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
				$xml .= $this->create_number_of_units($v,$date_diff,$payrun['date_from'],$xero_payrates[$k] );
			 } #foreaeach ($line_arr...)
				
			 $xml .= "	 
						</TimesheetLines>
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
			
			$msg = "Payrun Period - " . $payrun['date_from'] . "-" . $payrun['date_to'];
			
			foreach($result_arr as $t){
				#echo $t['EmployeeID']."<br>".$t['TimesheetID'];
				foreach($xero_arr as $key => $val){
					if($t['EmployeeID'] == $key){
						foreach($val as $v){
							$this->payrun_model->update_synced($v['timesheet_id'], array(
								'external_id' => $msg . ". Ext ID: " . $t['TimesheetID'],
								'external_msg' => 'OK'
							));	
						}
					}
				}
			}
			
		}
		/*if ($this->XeroOAuth->response['code'] == 400) {
			$result = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
			$error = json_decode(json_encode($result), TRUE);
			
		}*/
	
		
	}
	
	function create_number_of_units($timesheet,$no_of_days,$payrun_start_date,$xero_earning_rate_id)
	{
		
		$no_of_units = array();
		for($i = 0; $i <= $no_of_days; $i++){
			$no_of_units[$i] = "<NumberOfUnit>0.00</NumberOfUnit>";	
			foreach($timesheet as $line){
				if($line['job_date'] == date('Y-m-d',strtotime($payrun_start_date . "+$i days"))){
					$no_of_units[$i] = "<NumberOfUnit>" . ( $line['total_minutes']/60 ) . "</NumberOfUnit>";		
				}
			} 					
		}
		$units = implode("",$no_of_units);
		$xml = "<TimesheetLine>
					<EarningsRateID>" . $xero_earning_rate_id . "</EarningsRateID>
						<NumberOfUnits>
							$units
						</NumberOfUnits>
				</TimesheetLine>";
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
	
	function _get_staff_csv()
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
