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
		$this->load->model('usr/user_model');
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
	
	function get_staff_card($user_id)
	{
		$data['staff'] = $this->staff_model->get_staff_with_age_group($user_id);
		$data['photo'] = $this->staff_model->get_hero($user_id);
		$this->load->view('staff/card_view', isset($data) ? $data : NULL);	
	}
}