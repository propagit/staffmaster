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
        $this->oauth_callback = 'oob';
        $this->user_agent = 'StaffBookks_Private';
        $this->signatures = array(
            'consumer_key' => 'U8PV3ETRIVPW7F6NVCP7BICHBIT4QS',
            'shared_secret' => '6CHG5QVKWGREAYMCW23BHC6KDBZZW3',
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
                        <Phone>" . $staff['phone'] . "</Phone>
                        <Mobile>" . $staff['mobile'] . "</Mobile>
                        <HomeAddress>
                            <AddressLine1>" . $staff['address'] . "</AddressLine1>
                            <City>$city</City>
                            <Region>" . $staff['state'] . "</Region>
                            <PostalCode>" . $staff['postcode'] . "</PostalCode>
                            <Country>" . $staff['country'] . "</Country>
                        </HomeAddress>
                    </Employee>
                </Employees>";

        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Employees', 'payroll'), array(), $xml);

        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            // var_dump($result['Employee']);

            $this->load->model('staff/staff_model');
            return $this->staff_model->update_staff($user_id, array('external_staff_id' => $result['Employee']['EmployeeID']));

            return $result['Employee'];
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
        // var_dump($employee);
        $dob = '';
        if ($staff['dob'] && $staff['dob'] != '0000-00-00') {
            $dob = $staff['dob'];
        }
        $city = $staff['city'];
        if (!$city) { $city = $staff['suburb']; }
        if (!$city) { $city = 'Not Specified'; }

        $super = '';
        if (isset($employee['SuperMemberships']) && count($employee['SuperMemberships']) > 0)
        {
            $super = "<SuperMemberships>
                            <SuperMembership>
                                <SuperMembershipID>" . $employee['SuperMemberships']['SuperMembership']['SuperMembershipID'] . "</SuperMembershipID>
                                <SuperFundID>" . $staff['s_external_id'] . "</SuperFundID>
                                <EmployeeNumber>" . $staff['s_employee_id'] . "</EmployeeNumber>
                            </SuperMembership>
                        </SuperMemberships>";
        }
        $bank_accounts = '';
        if (isset($employee['BankAccounts']) && count($employee['BankAccounts']) > 0)
        {
            $bank_accounts .= "<BankAccounts>";
            foreach($employee['BankAccounts']['BankAccount'] as $account) {
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
        }

        $xml = "<Employees>
                    <Employee>
                        <EmployeeID>$external_id</EmployeeID>
                        <FirstName>" . $staff['first_name'] . "</FirstName>
                        <LastName>" . $staff['last_name'] . "</LastName>
                        <DateOfBirth>$dob</DateOfBirth>
                        <Status>ACTIVE</Status>
                        <HomeAddress>
                            <AddressLine1>" . $staff['address'] . "</AddressLine1>
                            <City>$city</City>
                            <Region>" . $staff['state'] . "</Region>
                            <PostalCode>" . $staff['postcode'] . "</PostalCode>
                            <Country>" . $staff['country'] . "</Country>
                        </HomeAddress>

                        <TaxDeclaration>
                            <AustralianResidentForTaxPurposes>" . ($staff['f_aus_resident'] ? 'true' : 'false') . "</AustralianResidentForTaxPurposes>
                            <TaxFreeThresholdClaimed>" . ($staff['f_tax_free_threshold'] ? 'true' : 'false') . "</TaxFreeThresholdClaimed>
                            <HasHELPDebt>" . ($staff['f_help_debt'] ? 'true' : 'false') . "</HasHELPDebt>
                            <TaxFileNumber>" . $staff['f_tfn'] . "</TaxFileNumber>
                            <EmploymentBasis>" . $employee['TaxDeclaration']['EmploymentBasis'] . "</EmploymentBasis>
                        </TaxDeclaration>
                        $bank_accounts
                        $super
                    </Employee>
                </Employees>";
        // var_dump($xml); die();
        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Employees', 'payroll'), array(), $xml);
        // var_dump($response);
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            // var_dump($result['Employee']);
            return $result['Employee'];
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

    function validate_timesheet_employee_payitems($timesheet_id)
    {
        $timesheet = modules::run('timesheet/get_timesheet', $timesheet_id);
        $staff = modules::run('staff/get_staff', $timesheet['staff_id']);
        if ($staff['external_staff_id']) {
            $employee = $this->read_employee($staff['external_staff_id']);
            if ($employee) {
                $pay_items = $this->get_payitems();
                # Extract employee earning ids
                $earnings = array();
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



                $pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
                foreach($pay_rates as $pay_rate)
                {
                    $earningID = $pay_rate['group'];
                    if (!$earningID)
                    {
                        $payrate = modules::run('attribute/payrate/get_payrate', $timesheet['payrate_id']);
                        $earningID = $payrate['name'];
                    }

                }


                # Check payitem for employee on Xero
                $pay_items = array();
                foreach($this->get_payitems() as $pay_item)
                {
                    $pay_items[] = $pay_item['EarningsRateID'];
                }

            }
        }

        return array(
            'ok' => false,
            'staff' => $staff['first_name'] . ' ' . $staff['last_name']
        );

    }

    function create_timesheets($payrun_id)
    {
        $this->load->model('payrun/payrun_model');
        $timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
        usort($timesheets, function($a, $b) { // anonymous function
            // compare numbers only
            if (isset($a['external_staff_id'])) {
                return $a['external_staff_id'] - $b['external_staff_id'];
            }
        });
        foreach($timesheets as $timesheet) {

        }
    }

    function add_timesheet()
    {
        $xml =
            "<Timesheets>
                <Timesheet>
                    <EmployeeID>b85e47b3-a7d5-4d52-9382-e7f027132fa1</EmployeeID>
                    <StartDate>2015-03-15</StartDate>
                    <EndDate>2015-03-28</EndDate>
                    <Status>Draft</Status>
                    <TimesheetLines>
                        <TimesheetLine>
                            <EarningsRateID>845779c7-bf3c-4ebe-a1cc-89bc3eb50345</EarningsRateID>
                            <NumberOfUnits>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>0.00</NumberOfUnit>
                                <NumberOfUnit>0.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>8.00</NumberOfUnit>
                                <NumberOfUnit>0.00</NumberOfUnit>
                                <NumberOfUnit>0.00</NumberOfUnit>
                            </NumberOfUnits>
                        </TimesheetLine>
                    </TimesheetLines>
                </Timesheet>
            </Timesheets>";
        // var_dump($xml); die();
        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Timesheets', 'payroll'), array(), $xml);
        var_dump($response);
        if ($this->XeroOAuth->response['code'] == 200) {

        }
    }
}
