<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Timesheet_staff extends MX_Controller {

	var $user_id = null;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('timesheet_staff_model');
		$this->load->model('job/job_shift_model');
		$this->load->model('expense/expense_model');
		if($this->session->userdata('user_data')){
			$user = $this->session->userdata('user_data');
			$this->user_id = $user['user_id'];
		}
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'generate':
					$this->generate();
				break;
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$data['supervised_timesheets'] = $this->timesheet_staff_model->get_supervised_timesheets();
		$this->load->view('staff/main_view', isset($data) ? $data : NULL);
	}
	
	function row_timesheet($timesheet_id, $is_supervised) {
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
		$data['is_supervised'] = $is_supervised;
		
		$updatable = false;
		if ($timesheet['status'] < TIMESHEET_SUBMITTED || # Timesheet never been submitted
				($timesheet['status'] < TIMESHEET_APPROVED && $timesheet['supervisor_id'] == $this->user_id)) {
			$updatable = true;
		}
		$data['updatable'] = $updatable;
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
	
	function generate()
	{
		$this->load->model('staff/staff_model');
		$shifts = $this->timesheet_staff_model->get_finished_shifts();
		foreach($shifts as $shift)
		{
			$this->job_shift_model->update_job_shift($shift['shift_id'], array('status' => SHIFT_FINISHED));
			# Update user_staffs table field - last_worked_date
			$data_user_staff = array('last_worked_date' => $shift['job_date'].' 00:00:00');
			$this->staff_model->update_staff($shift['staff_id'],$data_user_staff);
			
			unset($shift['status']);
			unset($shift['created_on']);
			unset($shift['modified_on']);
			unset($shift['payrate_type']);			
			unset($shift['is_alert']);
			unset($shift['information_sheet']);
			$job = modules::run('job/get_job', $shift['job_id']);
			$shift['client_id'] = $job['client_id'];
			$timesheet_id = $this->timesheet_model->insert_timesheet($shift);
			#$this->update_timesheet_hour_rate($timesheet_id);
		}
		redirect('timesheet');
	}
}