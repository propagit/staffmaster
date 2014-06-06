<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbf_model');
	}
	
	function test()
	{
		$a = $this->cbf_model->test();
		var_dump($a);
	}
	
	function msg_form_view($selected_module_ids) {
		$data['selected_module_ids'] = json_decode($selected_module_ids);
		$this->load->view('msg_form_view', isset($data) ? $data : NULL);
	}	
}