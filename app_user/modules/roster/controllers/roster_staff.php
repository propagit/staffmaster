<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: roster controller for staff
*/

class Roster_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('roster_model');
	}
	
	function index($method='', $param='') {
		switch($method)
		{
			
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$active_month = date('Y-m');
		$months = $this->roster_model->get_roster_months($active_month);
		if ($this->session->userdata('active_month_roster'))
		{
			$active_month = date('Y-m', $this->session->userdata('active_month_roster'));
		}
		else
		{
			$this->session->set_userdata('active_month_roster', strtotime($active_month));
		}
		$data['active_month'] = $active_month;
		$data['months'] = $months;
		
		$this->load->view('staff/main_view', isset($data) ? $data : NULL);
	}

}