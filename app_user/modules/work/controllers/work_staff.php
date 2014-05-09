<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: controller handle apply for work by staff
*/

class Work_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('work_model');
	}
	
	function index($method='', $param='') {
		if (!modules::run('auth/is_staff'))
		{
			echo modules::run('auth/staff_protected_view', 'roster');
			return;
		}
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$active_month = date('Y-m');
		$months = $this->work_model->get_work_months($active_month);
		if ($this->session->userdata('active_month_work')) {
			$active_month = date('Y-m', $this->session->userdata('active_month_work'));
		}
		else {
			$this->session->set_userdata('active_month_work', strtotime($active_month));
		}
		$data['active_month'] = $active_month;
		$data['months'] = $months;
		
		
		$this->load->view('staff/main_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: count_applied_shifts
	*	@desc: count total shifts applied in a day
	*	@access: public
	*	@param: (string) $date (YYYY-MM-DD)
	*	@return: (int) total shifts applied
	*/
	function count_applied_shifts($date) {
		return $this->work_model->count_applied_shifts($date);
	}
	
}