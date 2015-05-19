<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Lookbook
 *	@controller: Lookbook
 */

class Lookbook extends MX_Controller {
	var $user = null;

	function __construct() {
		parent::__construct();
		$this->load->model('staff/staff_model');
		$this->load->model('user/user_model');
		$this->load->model('lookbook_model');
		$this->user = $this->session->userdata('user_data');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view()
	{
		$this->load->view('main_view', isset($data) ? $data : NULL);	
	}
	
	function get_lookbook($key)
	{
		return $this->lookbook_model->get_lookbook($key);	
	}
	
	function get_staff_card_preview($user_id)
	{
		$data['config_personal'] = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
		$data['config_custom'] = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
		$data['staff'] = $this->staff_model->get_staff_with_age_group($user_id);
		$data['photo'] = $this->staff_model->get_hero($user_id);
		$this->load->view('staff/card_view', isset($data) ? $data : NULL);	
	}
	
	function get_staff_card_publish_view($user_id,$config_personal,$config_custom)
	{
		$data['config_personal'] = $config_personal;
		$data['config_custom'] = $config_custom;
		$data['staff'] = $this->staff_model->get_staff_with_age_group($user_id);
		$data['photo'] = $this->staff_model->get_hero($user_id);
		$this->load->view('staff/card_view', isset($data) ? $data : NULL);
	}
}