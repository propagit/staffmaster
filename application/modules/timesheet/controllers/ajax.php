<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('job/job_shift_model');
	}
	
	
	function list_timesheets()
	{
		$params = $this->input->post('params',true);
		$sort_params = '';
		if($params){
			$sort_params = $params;	
		}
		
		$data['timesheets'] = $this->timesheet_model->get_timesheets($sort_params);
		$this->load->view('timesheets_list', isset($data) ? $data : NULL);
	}
	
	function batch_timesheet()
	{
		$timesheet_id = $this->input->post('timesheet_id');
		modules::run('timesheet/update_timesheet_hour_rate', $timesheet_id);
		$this->timesheet_model->update_timesheet($timesheet_id, array('status' => TIMESHEET_BATCHED));
	}
	
	/**
	*	@name: timesheet_details
	*
	*
	*
	*
	*/
	function details($timesheet_id) {
		$data['timesheet'] = $this->timesheet_model->get_timesheet($timesheet_id);
		$this->load->view('details_modal_view', isset($data) ? $data : NULL);
	}
	
	
	function delete_timesheet()
	{
		$timesheet_id = $this->input->post('timesheet_id');
		# First get the timesheet
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		
		# Delete the timesheet
		$this->timesheet_model->delete_timesheet($timesheet['shift_id']);
		
		# Unlock the shift
		$this->job_shift_model->update_job_shift($timesheet['shift_id'], array('status' => SHIFT_CONFIRMED));
	}
	
	function update_timesheet_start_time()
	{
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$new_start_time = strtotime($this->input->post('value') . ':00');
		if ($new_start_time >= $timesheet['finish_time'])
		{
			$this->output->set_status_header('400');
			echo 'Start time cannot be greater than finish time';
		}
		else
		{
			$this->timesheet_model->update_timesheet($timesheet_id, array('start_time' => $new_start_time));
			echo json_encode(array('status' => 'success', 'value' => $new_start_time));
		}
	}
	function update_timesheet_finish_time()
	{
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$new_finish_time = strtotime($this->input->post('value') . ':00');
		if ($new_finish_time <= $timesheet['start_time'])
		{
			$this->output->set_status_header('400');
			echo 'Finish time cannot be less than start time';
		}
		else
		{
			$this->timesheet_model->update_timesheet($timesheet_id, array('finish_time' => $new_finish_time));
			echo json_encode(array('status' => 'success', 'value' => $new_finish_time));
		}
	}
	
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		echo modules::run('timesheet/row_timesheet', $timesheet_id);
	}
	
	function update_timesheet_payrate()
	{
		$timesheet_id = $this->input->post('pk');
		$this->timesheet_model->update_timesheet($timesheet_id, array('payrate_id' => $this->input->post('value')));
	}
	
	function load_ts_breaks() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['breaks'] = json_decode($timesheet['break_time']);
		$data['timesheet_id'] = $timesheet_id;
		$data['timesheet'] = $timesheet;
		$this->load->view('edit/break/list_view', isset($data) ? $data : NULL);
	}
	
	function add_ts_break() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['timesheet'] = $timesheet;
		$this->load->view('edit/break/add_form', isset($data) ? $data : NULL);
	}
	
	function update_ts_breaks() {
		$length = $this->input->post('break_length');
		$start_at = $this->input->post('break_start_at');
		$timesheet = $this->timesheet_model->get_timesheet($this->input->post('timesheet_id'));
		
		$breaks = array();
		foreach($length as $index => $value)
		{
			if ($value > 0)
			{
				$break_time = array(
					'length' => $value * 60,
					'start_at' => strtotime($start_at[$index])
				);
				
				if ($break_time['start_at'] <= $timesheet['start_time'] || $break_time['start_at'] >= $timesheet['finish_time'])
				{
					echo json_encode(array('ok' => false, 'number' => $index));
					return;
				}
				$breaks[] = $break_time;
			}
		}
		
		if ($this->timesheet_model->update_timesheet($timesheet['timesheet_id'], array('break_time' => json_encode($breaks))))
		{
			echo json_encode(array('ok' => true));
		}
	}
	
	function load_ts_staff() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['timesheet'] = $timesheet;
		$data['staff'] = modules::run('staff/get_staff', $timesheet['staff_id']);
		$this->load->view('edit/staff_form', isset($data) ? $data : NULL);
	}
	
	function search_staff_for_ts() {
		$query = $this->input->post('query');
		$this->load->model('staff/staff_model');
		$data['staffs'] = $this->staff_model->search_staffs(array('keyword' => $query, 'limit' => 6));
		$this->load->view('edit/staffs_search_results_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	
	*
	*
	*
	*
	*/
	function update_ts_staff() {
		$data = $this->input->post();
		$update_ts_data = array();
		if ($data['ts_staff']) {
			$staff = modules::run('staff/get_staff_by_name', $data['ts_staff']);
			
			if ($staff) {
				$this->timesheet_model->update_timesheet($data['timesheet_id'], array('staff_id' => $data['ts_staff_id']));
				echo json_encode(array('ok' => true));
			}
			else {
				echo json_encode(array('ok' => false, 'msg' => 'Staff not found'));
				return;
			}
		}
		else {
			echo json_encode(array('ok' => false, 'msg' => 'This field cannot be empty'));
			return;
		}		
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
		$this->load->view('edit/expense/modal_view', isset($data) ? $data : NULL);
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
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		if($timesheet) {
			$data['expenses'] = unserialize($timesheet['expenses']);
		}
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('edit/expense/table_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_expense
	*	@desc: ajax function to add an expense item of a timesheet
	*	@access: public
	*	@param: (POST) 	- description
	*					- staff_cost
	*					- client_cost
	*					- tax
	*					- timesheet_id
	*	@return: (json_encode) array ({ok} => (boolean))
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
		if (!is_numeric($data['client_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'client_cost'));
			return;
		}
		$timesheet = $this->timesheet_model->get_timesheet($data['timesheet_id']);
		$expenses = $timesheet['expenses'];
		if ($expenses == '') {
			$expenses = array();
		} else {
			$expenses = unserialize($expenses);
		}
		array_push( $expenses, array(
			'description' => $data['description'],
			'staff_cost' => $data['staff_cost'],
			'client_cost' => $data['client_cost'],
			'tax' => $data['tax']
		));
		$updated = $this->timesheet_model->update_timesheet($data['timesheet_id'], array(
			'expenses' => serialize($expenses)
		));
		if ($updated) {
			echo json_encode(array('ok' => true));
		}
	}
	
	/**
	*	@name: delete_expense
	*	@desc: ajax function to delete an expense item of a timesheet
	*	@access: public
	*	@param: (POST) 	- timesheet_id
	*					- i: index of the expense item
	*	@return: (void)
	*/
	function delete_expense() {
		$timesheet_id = $this->input->post('timesheet_id');
		$index = $this->input->post('i');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$expenses = unserialize($timesheet['expenses']);
		$array = array();
		if ($expenses) {
			$i = 0;
			foreach($expenses as $expense) {
				if ($i!=$index) {
					$array[] = $expense;
				}
				$i++;
			}
		}
		$this->timesheet_model->update_timesheet($timesheet_id, array(
			'expenses' => serialize($array)
		));
	}
}