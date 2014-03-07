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
	
	function load_timesheet($timesheet_id) {
		$data['timesheet'] = $this->timesheet_model->get_timesheet($timesheet_id);
		$this->load->view('timesheet_details_modal', isset($data) ? $data : NULL);
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
}