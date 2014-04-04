<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Timesheet_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_staff_model');
		$this->load->model('job/job_shift_model');
		$this->load->model('expense/expense_model');
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
		$data['timesheets'] = $this->timesheet_staff_model->get_timesheets();
		$this->load->view('staff/main_view', isset($data) ? $data : NULL);
	}
	
	function row_timesheet($timesheet_id) {
		$timesheet = $this->timesheet_staff_model->get_timesheet($timesheet_id);
		$data['client'] = modules::run('client/get_client', $timesheet['client_id']);
		$data['staff'] = modules::run('staff/get_staff', $timesheet['staff_id']);
		$data['timesheet'] = $timesheet;
		$data['shift'] = $this->job_shift_model->get_job_shift($timesheet['shift_id']);
		
		$total_expenses = 0;
		$expenses = unserialize($timesheet['expenses']);
		if (is_array($expenses)) {
			foreach($expenses as $e) {
				$staff_cost = $e['staff_cost'];
				if ($e['tax'] == GST_ADD) {
					$staff_cost *= 1.1;
				}
				$total_expenses += $staff_cost;
			}
		}
		$paid_expenses = $this->expense_model->get_timesheet_expenses($timesheet_id);
		foreach($paid_expenses as $e) {
			$staff_cost = $e['staff_cost'];
			if ($e['tax'] == GST_ADD) {
				$staff_cost *= 1.1;
			}
			$total_expenses += $staff_cost;
		}
		$data['total_expenses'] = $total_expenses;
		
		$this->load->view('staff/timesheet_row_view', isset($data) ? $data : NULL);
	}
	
	
	/**
	*	@name: add_expense_form
	*	@desc: load add expense form view
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) add expense form view
	*/
	function add_expense_form($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('staff/edit/expense/add_form', isset($data) ? $data : NULL);
	}
}