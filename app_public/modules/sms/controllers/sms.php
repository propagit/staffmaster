<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function incoming() 
	{
		$input = $_POST['INCOMING'];
		$data = $this->processIncoming($input);
		
		$from = $data[0][1]; # Sender number
		$to = $data[0][2]; # Virtual number
		$text = pack("H*", $data[0][7]); # Text
		$received_on = $data[0][5]; # Timestamp
		$udh = $data[0][6];
		
		$cc = $this->Contact_model->get_user_optout($text);
		
		
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
}