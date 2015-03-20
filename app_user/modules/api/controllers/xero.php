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

    function employees() {
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

    function read_employee($id) {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees/' . $id, 'payroll'), array());
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


    function search_employees() {
        return array();
    }

    function total_employees() {
        $response = $this->XeroOAuth->request('GET', $this->XeroOAuth->url('Employees', 'payroll'), array());

        if ($this->XeroOAuth->response['code'] == 200) {
            $employees = $this->XeroOAuth->parseResponse($this->XeroOAuth->response['response'], $this->XeroOAuth->response['format']);
            return count($employees->Employees[0]);
        }
        return false;
    }
}
