<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: apply controller for staff
*/

class Work_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('work_model');
	}
	
	public function index()
	{
		$active_month = date('Y-m');
		$months = $this->work_model->get_work_months($active_month);
		if ($this->session->userdata('active_month_work'))
		{
			$active_month = date('Y-m', $this->session->userdata('active_month_work'));
		}
		else
		{
			$this->session->set_userdata('active_month_work', strtotime($active_month));
		}
		$data['active_month'] = $active_month;
		$data['months'] = $months;
		
		
		$this->load->view('staff/work_main_view', isset($data) ? $data : NULL);
	}
	
	
	
}