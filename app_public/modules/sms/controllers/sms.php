<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function incoming() {
		$errstr = '';

		$username = urlencode(CBF_USER);
		$password = urlencode(CBF_PASS);

		$request = "http://sms1.cardboardfish.com:9001/ClientDR/ClientDR?&UN=${username}&P=${password}";
		$ch = curl_init($request);

		if (!$ch) {
			$errstr = "Could not connect to server.";
			return false;
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$serverresponse = curl_exec($ch);

		if ($serverresponse == "") {
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$errstr = "HTTP error: $code\n";
			return false;
		}

		$datas = $this->processIncoming($serverresponse);
		#var_dump($datas);
		if (is_array($datas)) {
			foreach($datas as $data) {
				#var_dump($data);

				$result = array(
					'sender' => $data[1], # Sender number
					'receiver' => $data[2], # Virtual number
					'msg' => pack("H*", $data[7]),
					'received_on' => date('Y-m-d H:i:s', $data[5])
				);
				// var_dump($result);
				if ($result['msg'] != '')
				{
					# Now checking the request
					$code = substr($result['msg'], 1);
					$ans = substr($result['msg'], 0, 1);
					$result['code'] = $code;
					$result['answer'] = strtolower($ans);

					$this->load->model('sms_model');
					# Log the response
					$response_id = $this->sms_model->insert_response($result);
				}
			}
		}


	}

	function processIncoming ($input)
	{
		if ($input == "0#")
		{
			return true;
		}
		$receipts = explode("#", $input);

		array_shift($receipts);

		$to_return = array();

		foreach ($receipts as $receipt)
		{
			if ($receipt == "")
			{
				continue;
			}
			$field = explode(":", $receipt);
			array_push($to_return, $field);
		}
		return $to_return;
	}

	function test() {
		$to = '61402133066';
		$msg = 'Hello how are you!';
		$a = $this->send_1way_sms($to, $msg, 'namnd');
		var_dump($a);

	}

	function send_1way_sms($to, $message, $subdomain) {
		$this->load->model('account_sms_model');
		#$company = $this->account_sms_model->get_company($subdomain);
		$credits = $this->account_sms_model->get_credits($subdomain);

		if ($credits > 0)
		{
			$this->load->library('cbf');
			$sendsms = $this->cbf->load();

			$sender = VIRTUAL_NUMBER;

			/* if ($company) {
				if ($company['company_name']) {
					$sender = $company['company_name'];
				}
			} */

			$sendsms->setDA($to);
			$sendsms->setSA($sender);
			$sendsms->setDR("1"); # Disable if send 1 way
			$sendsms->setMSG($message);
			$sendsms->setST("1"); # 1: 2 ways, 5: 1 way

			$result = $sendsms->send_sms_object();
			if ($result) {
				$this->account_sms_model->deduct_credits($subdomain);
			}
			return $result;
		}
		return false;
	}
}
