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
		$message = json_encode($data);
		//echo pack("H*", $messages[0][7]);

		$number = $data[0][1];
		$text = pack("H*", $data[0][7]);
		
		$cc = $this->Contact_model->get_user_optout($text);
		
		if($cc > 0)
		{
			$dd['msg'] = $ab;
			$dd['number'] = $number;
			$dd['text'] = $text;
			
			$this->Contact_model->add_mobile_optout($dd);
			
			//$data['actived_sms'] = 0;
			$this->Contact_model->set_mobile_optout($number);
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
}