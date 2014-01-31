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
	
	public function index()
	{
		$active_month = date('Y-m');
		$months = $this->roster_model->get_roster_months($active_month);
		if ($this->session->userdata('active_month'))
		{
			$active_month = date('Y-m', $this->session->userdata('active_month'));
		}
		else
		{
			$this->session->set_userdata('active_month', strtotime($active_month));
		}
		$data['active_month'] = $active_month;
		$data['months'] = $months;
		
		$this->load->view('staff/rosters_main_view', isset($data) ? $data : NULL);
	}
		
}