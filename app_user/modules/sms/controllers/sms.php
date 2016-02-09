<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('sms_model');
	}

	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'topup':
					$this->topup_view();
				break;
			case 'test1':
					$this->test1();
				break;
			case 'test2':
					$this->test2();
				break;
			default:
					$this->main_view();
				break;
		}
	}
	function test1() {
		$to = '61402133066';
		$msg = 'One way sms';
		$a = $this->send_1way_sms($to, $msg);
		var_dump($a);
	}
	function test2() {
		$to = '61402133066';
		$msg = 'Two way sms';
		$a = $this->send_2ways_sms($to, $msg);
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
		#$sendsms->setDR("1");
		$sendsms->setMSG($message);
		$sendsms->setST("5");

		return $sendsms->send_sms_object();
	}

	function send_2ways_sms($to, $message) {
		$this->load->library('cbf');
		$sendsms = $this->cbf->load();

		$sendsms->setDA($to);
		$sendsms->setSA(VIRTUAL_NUMBER);
		$sendsms->setDR("1");
		$sendsms->setMSG($message);
		$sendsms->setST("1");

		return $sendsms->send_sms_object();
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
