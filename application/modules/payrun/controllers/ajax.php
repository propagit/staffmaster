<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrun_model');
	}
	
	function list_payruns() {		
		$data['staffs'] = $this->payrun_model->get_staffs();
		$this->load->view('payruns_list_view', isset($data) ? $data : NULL);
	}
	
	function load_staff_timesheets() {
		$user_id = $this->input->post('user_id');
		$data['payruns'] = $this->payrun_model->get_staff_payruns($user_id);
		$data['user_id'] = $user_id;
		$this->load->view('staff_timesheets_list_view', isset($data) ? $data : NULL);
	}
	
	function expand_staff_timehsheets() {
		$user_id = $this->input->post('user_id');
		$parent = modules::run('payrun/row_batched_staff', $user_id, true);
		$children = modules::run('payrun/row_timesheets_staff', $user_id);
		echo json_encode(array(
			'parent' => $parent,
			'children' => $children
		));
	}
	
	function revert_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->revert_staff_payruns($user_id);		
	}
	
	function revert_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->revert_payrun($timesheet_id);
	}

}