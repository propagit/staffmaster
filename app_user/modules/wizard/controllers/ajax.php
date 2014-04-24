<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function turnoff()
	{
		if($this->input->post('turnoff') == "true")
		{
			$this->session->set_userdata('turnoff_wizard', true);
		}
	}
	
}