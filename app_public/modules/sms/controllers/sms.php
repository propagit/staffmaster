<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function init() {
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
		if (is_array($datas)) {
			foreach($datas as $data) {
				#var_dump($data);
			
				$result = array(
					'sender' => $data[1], # Sender number
					'receiver' => $data[2], # Virtual number
					'msg' => pack("H*", $data[7]),
					'received_on' => date('Y-m-d H:i:s', $data[5])
				);
				#var_dump($result);
				
				$this->load->model('sms_model');
				# Log the response
				$response_id = $this->sms_model->insert_response($result);
				
				# Now checking the request
				$code = substr($result['msg'], 1);
				$ans = substr($result['msg'], 0, 1);
				
				$request = $this->sms_model->get_request($result['sender'], $code);
				if ($request) {
				
					# Update: request is answered
					$this->sms_model->update_request($request['request_id'], array('processed' => 1));
					
					
					$this->load->model('account_sms_model');
					# Get shift information
					$shift = $this->account_sms_model->get_job_shift($request['subdomain'], $request['shift_id']);
					
					if ($shift['staff_id'] != $request['user_id']) # Invalid code
					{
						$invalid_sms = $this->account_sms_model->get_sms_template($request['subdomain'], 3);
						if ($invalid_sms['status']) # Active
						{
							#$this->load->model('cbf_model');
														
							$msg = $invalid_sms['msg'];
							$msg = str_replace('{Code}', $result['msg'], $msg);
							#$this->cbf_model->send_2ways_sms($data[1], $msg);
						}
					}
					else # Valid code
					{
						if (strtolower($ans) == 'y') # Confirm
						{
							$status = 2; # SHIFT_CONFIRMED
							$confirm_sms = $this->account_sms_model->get_sms_template($request['subdomain'], 2);
							if ($confirm_sms['status']) # Active
							{
								#$this->load->model('cbf_model');
								
								$msg = $confirm_sms['msg'];
								$msg = str_replace('{Date}', date('d/m/Y', $shift['start_time']), $msg);
								$msg = str_replace('{StartTime}', date('H:i', $shift['start_time']), $msg);
								$msg = str_replace('{FinishTime}', date('H:i', $shift['finish_time']), $msg);
								#$this->cbf_model->send_2ways_sms($data[1], $msg);
							}
						} 
						else # Reject 
						{
							$status = -1; # SHIFT_REJECTED
						}
						$this->account_sms_model->update_job_shift($request['subdomain'], $request['shift_id'], $request['user_id'], $status);
					}					
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
	
	function send_1way_sms($to, $message) {
		$this->load->library('cbf');
		$sendsms = $this->cbf->load();
		
		$sendsms->setDA($to);
		$sendsms->setSA(VIRTUAL_NUMBER);
		#$sendsms->setDR("1");
		$sendsms->setMSG($message);
		$sendsms->setST("5");
		
		return $sendsms->send_sms_object();
	}
}