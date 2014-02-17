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
		$this->load->model('staff/staff_model');
		$this->load->model('attribute/payrate_model');
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
			case 'batched':
					$this->list_batched_timesheets();
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
			$timesheet_id = $this->timesheet_model->insert_timesheet($shift);
			$this->update_timesheet_hour_rate($timesheet_id);
		}
		redirect('timesheet');
	}
	
	function update_timesheet_hour_rate($timesheet_id)
	{
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$payrate_id = $timesheet['payrate_id'];
		$start_time = $timesheet['start_time'];
		$finish_time = $timesheet['finish_time'];
		$total_mins = 0;
		$total_amount_staff = 0;
		$total_amount_client = 0;
		for($i=$start_time; $i < $finish_time; $i = $i + 60) { # Every minute
			$day = date('N', $i); # Get day of the week (1: for monday, 7 for sunday)
			$hour = date('G', $i); # Get hour of the day (0 - 23)
			
			# Amount paid calculated by minute
			$total_amount_staff += $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/60;
			$total_amount_client += $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/60;
			$total_mins++;
		}
		
		# Deduct the break
		
		$breaks = json_decode($timesheet['break_time']);
		if (count($breaks) > 0) {
			foreach($breaks as $break)
			{
				$length = $break->length;
				$start_at = $break->start_at;
				for($i=0; $i < $length; $i = $i + 60) { # Every minute
					$start_at = $start_at + $i;
					$day = date('N', $i);
					$hour = date('G', $i);
					$total_amount_staff -= $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/60;
					$total_amount_client -= $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/60;
					$total_mins--;
				}
			}
		}
		
		return $this->timesheet_model->update_timesheet($timesheet_id, array(
			'total_minutes' => $total_mins,
			'total_amount_staff' => $total_amount_staff,
			'total_amount_client' => $total_amount_client
		));
		
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
	
	function field_select_status($field_name, $field_value=null, $size=null)
	{
		$array = array(
			array('value' => TIMESHEET_PENDING, 'label' => 'Pending'),
			array('value' => TIMESHEET_SUBMITTED, 'label' => 'Submitted'),
			array('value' => TIMESHEET_APPROVED, 'label' => 'Approved')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
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