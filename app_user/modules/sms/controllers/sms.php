<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbf_model');
		$this->load->model('sms_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'topup':
					$this->topup_view();
				break;
			case 'test':
					$this->test();
				break;
			default:
					$this->main_view();
				break;
		}
	}
	function test() {
		$to = '61402133066';
		$from = 'Propagate';
		$msg = 'Hello how are you!';
		$a = $this->send_1way_sms($to, $msg);
		var_dump($a);
		
	}
	
	function send_1way_sms($to, $message) {
		$this->load->library('cbf');
		$sendsms = $this->cbf->load();
		
		$sender = VIRTUAL_NUMBER;
		$company = modules::run('setting/company_profile');
		if ($company['company_name']) {
			$sender = $company['company_name'];
		}
		
		$sendsms->setDA($to);
		$sendsms->setSA($sender);
		$sendsms->setDR("1");
		$sendsms->setMSG($message);
		
		return $sendsms->send_sms_object();
	}
	
	function send_2ways_sms($to, $message) {
		$this->load->library('cbf');
		$sendsms = $this->cbf->load();
		$responses = $sendsms->send_sms ($to, VIRTUAL_NUMBER, $message, true);
	}
	
	function main_view() 
	{
		$templates = $this->sms_model->get_templates();
		$a = array();
		foreach($templates as $t) {
			$a[] = array('label' => $t['title'], 'value' => $t['template_id']);
		}
		$data['templates'] = $a;
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function topup_view() 
	{
		$this->load->view('topup_view', isset($data) ? $data : NULL);
	}
	
	function msg_form_view($selected_user_ids, $selected_module_ids) {
		$selected_user_ids = json_decode($selected_user_ids);
		$selected_module_ids = json_decode($selected_module_ids);
		
		$data['selected_user_ids'] = $selected_user_ids;
		if ($selected_module_ids == NULL) { # General message
			$this->load->view('general_form', isset($data) ? $data : NULL);
		} else { # Shift confirm
			$data['selected_module_ids'] = $selected_module_ids;
			$data['request_sms'] = $this->sms_model->get_template(1);
			$this->load->view('shift_request_form', isset($data) ? $data : NULL);
		}		
		
	}	
}