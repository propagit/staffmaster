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
            var_dump($result['SuperFund']);
            return $result['SuperFund'];
        }
    }

    function get_superfund($id)
    {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('SuperFunds/' . $id, 'payroll'), array());

        if ($this->XeroOAuth->response['code'] == 200) {
            $superfunds = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            $result = json_decode(json_encode($superfunds->SuperFunds), TRUE);
            var_dump($result['SuperFund']);
            return $result['SuperFund'];
        }
    }

    function get_employees() {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees', 'payroll'), array());
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            // echo "There are " . count($employees->Employees[0]). " employees in this Xero organisation, the first one is: </br>";
            // var_dump($employees->Employees[0]);
            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            var_dump($result['Employee']);
            return $result['Employee'];
        }
        return null;
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
        var_dump($xml); die();
        $response = $this->XeroOAuth->request('POST', $this->XeroOAuth->url('Employees', 'payroll'), array(), $xml);
        var_dump($response);
        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);

            $result = json_decode(json_encode($employees->Employees[0]), TRUE);
            var_dump($result['Employee']);
            return $result['Employee'];
        }
        return false;
    }
}
