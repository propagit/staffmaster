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

}