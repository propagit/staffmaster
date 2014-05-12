<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Ajax_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_staff_model');
		$this->load->model('timesheet_model');
		$this->load->model('expense/expense_model');
	}
	
	function generate_timesheets()
	{
		$this->load->model('staff/staff_model');
		$this->load->model('job/job_shift_model');
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
	}
	
	function list_timesheets() {
		$data['timesheets'] = $this->timesheet_staff_model->get_timesheets();
		$data['is_supervised'] = 0;
		$this->load->view('staff/timesheets_list', isset($data) ? $data : NULL);
	}
	
	function load_supervised_timesheets() {
		$data['timesheets'] = $this->timesheet_staff_model->get_supervised_timesheets();
		$data['is_supervised'] = 1;
		$this->load->view('staff/timesheets_list', isset($data) ? $data : NULL);
	}
	
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$is_supervised = $this->input->post('is_supervised');
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet_id, $is_supervised);
	}
	
	function submit_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->timesheet_staff_model->submit_timesheet($timesheet_id);
	}
	
	
	/**
	*	@name: load_expenses_modal
	*	@desc: ajax function to open modal of timesheet expenses
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (html) modal view of expense
	*/
	function load_expenses_modal($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('staff/edit/expense/modal_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: list_expenses
	*	@desc: ajax function to list expenses of a timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (html) list view of expense items
	*/
	function list_expenses() {
		$timesheet_id = $this->input->post('timesheet_id');
		$timesheet = $this->timesheet_staff_model->get_timesheet($timesheet_id);
		if($timesheet) {
			$data['expenses'] = unserialize($timesheet['expenses']);
		}
		$data['timesheet_id'] = $timesheet_id;
		$data['paid_expenses'] = $this->expense_model->get_timesheet_expenses($timesheet_id);
		$this->load->view('staff/edit/expense/table_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_expense
	*	@desc: ajax function to add an expense item of a timesheet
	*	@access: public
	*	@param: (POST) description, staff_cost, client_cost, tax, timesheet_id
	*	@return: (JSON) {ok:(boolean)}
	*/
	function add_expense() {
		$data = $this->input->post();
		if ($data['description'] == '') {
			echo json_encode(array('ok' => false, 'error_id' => 'description'));
			return;
		}
		if (!is_numeric($data['staff_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'staff_cost'));
			return;
		}
		$timesheet = $this->timesheet_staff_model->get_timesheet($data['timesheet_id']);
		$expenses = $timesheet['expenses'];
		if ($expenses == '') {
			$expenses = array();
		} else {
			$expenses = unserialize($expenses);
		}
		array_push( $expenses, array(
			'description' => $data['description'],
			'staff_cost' => $data['staff_cost'],
			'client_cost' => 0,
			'tax' => $data['tax']
		));
		$updated = $this->timesheet_staff_model->update_timesheet($data['timesheet_id'], array(
			'expenses' => serialize($expenses)
		));
		if ($updated) {
			echo json_encode(array('ok' => true));
		}
	}
	
	/**
	*	@name: update_timesheet_start_time
	*	@desc: ajax function to update timesheet start time (inline edit)
	*	@access: public
	*	@param: (POST) pk, value
	*	@return: (JSON) {status: boolean, value: $new_start_time}
	*/
	function update_timesheet_start_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$old_start_date = date('Y-m-d',$timesheet['start_time']);
		$new_start_time = strtotime($old_start_date.' '.$this->input->post('value') . ':00');
		if ($new_start_time >= $timesheet['finish_time']) {
			$this->output->set_status_header('400');
			echo 'Start time cannot be greater than finish time';
		} else {
			$this->timesheet_staff_model->update_timesheet($timesheet_id, array('start_time' => $new_start_time));
			echo json_encode(array('status' => 'success', 'value' => $new_start_time));
		}
	}
	
	/**
	*	@name: update_timesheet_finish_time
	*	@desc: ajax function to update timesheet finish time (inline edit)
	*	@access: public
	*	@param: (POST) pk, value
	*	@return: (JSON) {status: boolean, value: $new_finish_time}
	*/
	function update_timesheet_finish_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$old_finish_date = date('Y-m-d',$timesheet['finish_time']);
		$new_finish_time = strtotime($old_finish_date.' '.$this->input->post('value') . ':00');
		if ($new_finish_time <= $timesheet['start_time']) {
			$this->output->set_status_header('400');
			echo 'Finish time cannot be less than start time';
		} else {
			$this->timesheet_staff_model->update_timesheet($timesheet_id, array('finish_time' => $new_finish_time));
			echo json_encode(array('status' => 'success', 'value' => $new_finish_time));
		}
	}
}