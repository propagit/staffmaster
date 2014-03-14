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
	}
	
	
	function list_timesheets() {
		$data['timesheets'] = $this->timesheet_staff_model->get_timesheets();
		$this->load->view('staff/timesheets_list', isset($data) ? $data : NULL);
	}
	
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet_id);
	}
	
	function submit_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->timesheet_staff_model->update_timesheet($timesheet_id, array('status' => TIMESHEET_SUBMITTED));
	}

}