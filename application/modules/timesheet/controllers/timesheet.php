<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Timesheet extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('job/job_shift_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'generate':
					$this->generate();
				break;
			case 'truncate':
					$this->truncate();
				break;
			default:
					$this->list_timesheets();
				break;
		}
		
	}
	
	function list_timesheets()
	{
		$data['timesheets'] = $this->timesheet_model->get_timesheets();
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function generate() {
		$shifts = $this->timesheet_model->get_finished_shifts();
		foreach($shifts as $shift)
		{
			$this->job_shift_model->update_job_shift($shift['shift_id'], array('status' => SHIFT_FINISHED));
			unset($shift['status']);
			unset($shift['created_on']);
			unset($shift['modified_on']);
			unset($shift['payrate_type']);
			$this->timesheet_model->insert_timesheet($shift);
		}
		redirect('timesheet');
	}
	
	
	function truncate() {
		$shifts = $this->timesheet_model->get_timesheets();
		foreach($shifts as $shift)
		{
			$this->job_shift_model->update_job_shift($shift['shift_id'], array('status' => SHIFT_CONFIRMED));
		}
		$this->timesheet_model->truncate();
		redirect('timesheet');
	}
	
	function status_to_class($status)
	{
		$class = '';
		switch($status)
		{
			case TIMESHEET_SUBMITTED: $class = 'warning';
				break;
			case TIMESHEET_APPROVED: $class = 'success';
				break;
			case SHIFT_UNASSIGNED:
			default: $class = '';
				break;
		}
		return $class;
	}

}