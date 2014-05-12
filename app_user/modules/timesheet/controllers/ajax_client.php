<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax_client extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_client_model');
		$this->load->model('timesheet_model');
		$this->load->model('expense/expense_model');
	}
	
	function generate_timesheets()
	{
		$this->load->model('staff/staff_model');
		$this->load->model('job/job_shift_model');
		$shifts = $this->timesheet_client_model->get_finished_shifts();
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
	
	function load_supervised_timesheets() 
	{
		$data['timesheets'] = $this->timesheet_client_model->get_supervised_timesheets();
		$this->load->view('client/timesheets_list', isset($data) ? $data : NULL);
	}
	
	
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		echo modules::run('timesheet/timesheet_client/row_timesheet', $timesheet_id);
	}
	
	function submit_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->timesheet_client_model->submit_timesheet($timesheet_id);
	}
	
	function update_timesheet_start_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$old_start_date = date('Y-m-d',$timesheet['start_time']);
		$new_start_time = strtotime($old_start_date.' '.$this->input->post('value') . ':00');
		if ($new_start_time >= $timesheet['finish_time']) {
			$this->output->set_status_header('400');
			echo 'Start time cannot be greater than finish time';
		} else {
			$this->timesheet_client_model->update_timesheet($timesheet_id, array('start_time' => $new_start_time));
			echo json_encode(array('status' => 'success', 'value' => $new_start_time));
		}
	}
	function update_timesheet_finish_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$old_finish_date = date('Y-m-d',$timesheet['finish_time']);
		$new_finish_time = strtotime($old_finish_date.' '.$this->input->post('value') . ':00');
		if ($new_finish_time <= $timesheet['start_time']) {
			$this->output->set_status_header('400');
			echo 'Finish time cannot be less than start time';
		} else {
			$this->timesheet_client_model->update_timesheet($timesheet_id, array('finish_time' => $new_finish_time));
			echo json_encode(array('status' => 'success', 'value' => $new_finish_time));
		}
	}
}