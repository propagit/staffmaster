<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Timesheet
 *	@controller: Timesheet
 */

class Timesheet extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('job/job_shift_model');
		$this->load->model('attribute/payrate_model');
		$this->load->model('expense/expense_model');
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
	
	/**
	*	@name: main_view
	*	@desc: load main view of timesheet module (landing page)
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of the timesheet module landing page
	*/
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_form
	*	@desc: load search timesheets form view
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of search timesheets form
	*/
	function search_form() {
		$this->load->view('search_form_view', isset($data) ? $data : NULL);
	}
	
	function get_timesheet($timesheet_id) {
		return $this->timesheet_model->get_timesheet($timesheet_id);
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: load row view (tr) of one timesheet
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) tr view of one timesheet
	*/
	function row_timesheet($timesheet_id) {
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['client'] = modules::run('client/get_client', $timesheet['client_id']);
		$data['staff'] = modules::run('staff/get_staff', $timesheet['staff_id']);
		$data['timesheet'] = $timesheet;
		$data['shift'] = $this->job_shift_model->get_job_shift($timesheet['shift_id']);
		$data['job'] = modules::run('job/get_job', $timesheet['job_id']);
		
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
		$this->load->view('row_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_timesheet_hour_rate
	*	@desc: calculate and update client/staff cost of a timesheet based on hours & pay rate
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (boolean)
	*/
	function update_timesheet_hour_rate($timesheet_id) {
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$payrate_id = $timesheet['payrate_id'];
		$start_time = $timesheet['start_time'];
		$finish_time = $timesheet['finish_time'];
		$total_mins = 0;
		$total_amount_staff = 0;
		$total_amount_client = 0;
		for($i=$start_time; $i < $finish_time; $i = $i + 60*15) { # Every 15 minutes
			$day = date('N', $i); # Get day of the week (1: for monday, 7 for sunday)
			$hour = date('G', $i); # Get hour of the day (0 - 23)
			
			# Amount paid calculated by 15 minute
			
			$total_amount_staff += $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
			$total_amount_client += $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/4;
			$total_mins = $total_mins + 15;
		}
		
		# Deduct the break
		
		$breaks = json_decode($timesheet['break_time']);
		if (count($breaks) > 0) {
			foreach($breaks as $break)
			{
				$length = $break->length;
				$start_at = $break->start_at;
				for($i=0; $i < $length; $i = $i + 60*15) { # Every 15 minute
					$start_at = $start_at + $i;
					$day = date('N', $i);
					$hour = date('G', $i);
					$total_amount_staff -= $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
					$total_amount_client -= $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/4;
					$total_mins = $total_mins - 15;
				}
			}
		}
		
		# Update expenses cost
		
		$expenses = unserialize($timesheet['expenses']);
		if (count($expenses) > 0) {
			foreach($expenses as $exp) {
				$exp['job_id'] = $timesheet['job_id'];
				$exp['timesheet_id'] = $timesheet['timesheet_id'];
				$exp['staff_id'] = $timesheet['staff_id'];
				$exp['client_id'] = $timesheet['client_id'];		
				$this->expense_model->add_expense($exp);				
			}
		}
		$expenses_staff_cost = $this->calculate_expenses($timesheet_id, 'staff');
		$expenses_client_cost = $this->calculate_expenses($timesheet_id, 'client');
		
		return $this->timesheet_model->update_timesheet($timesheet_id, array(
			'expenses_staff_cost' => $expenses_staff_cost,
			'expenses_client_cost' => $expenses_client_cost,
			'total_minutes' => $total_mins,
			'total_amount_staff' => $total_amount_staff,
			'total_amount_client' => $total_amount_client
		));
		
	}
	
	/**
	*	@name: field_select_status
	*	@desc: custom field select timesheet status
	*	@access: public
	*	@param: $field_name, $field_value (optional), $size (optional)
	*	@return: (html) custom field select
	*/
	function field_select_status($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => TIMESHEET_PENDING, 'label' => 'Pending'),
			array('value' => TIMESHEET_SUBMITTED, 'label' => 'Submitted'),
			array('value' => TIMESHEET_APPROVED, 'label' => 'Approved')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: menu_dropdown_actions
	*	@desc: generate the dropdown menu of actions applied to timesheets
	*	@access: public
	*	@param: $id, $label
	*	@return: (html) dropdown menu of actions applied to timesheets
	*/
	function menu_dropdown_actions($id, $label) {
		$data = array(
			array('value' => 'batch', 'label' => '<i class="fa fa-share-square-o"></i> Batch Selected'),
			array('value' => 'revert', 'label' => '<i class="fa fa-times"></i> Delete Selected')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	/**
	*	@name: status_to_class
	*	@desc: convert timesheet status to css class
	*	@access: public
	*	@param: $status
	*	@return: class_name
	*/
	function status_to_class($status) {
		$class = '';
		switch($status) {
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
	
	/**
	*	@name: add_expense_form
	*	@desc: load add expense form view
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) add expense form view
	*/
	function add_expense_form($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('edit/expense/add_form', isset($data) ? $data : NULL);
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
			$job = modules::run('job/get_job', $shift['job_id']);
			$shift['client_id'] = $job['client_id'];
			$timesheet_id = $this->timesheet_model->insert_timesheet($shift);
			#$this->update_timesheet_hour_rate($timesheet_id);
		}
		redirect('timesheet');
	}
	
	/**
	*	@name: calculate_expenses
	*	@desc: calculate total expenses of a timesheet
	*	@access: public
	*	@param: $timesheet_id
	*	@return: $total_expenses
	*/
	function calculate_expenses($timesheet_id, $type='staff') {
		if ($type != 'staff' && $type != 'client') { return 0; }
		$type .= '_cost';
		$total_expenses = 0;
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		
		# If timesheet is not batched yet, include expenses in timesheet table
		$expenses = unserialize($timesheet['expenses']);
		if (is_array($expenses) && $timesheet['status'] < TIMESHEET_BATCHED) {
			foreach($expenses as $e) {
				$cost = $e[$type];
				if ($e['tax'] == GST_ADD) {
					$cost *= 1.1;
				}
				$total_expenses += $cost;
			}
		}
		# If timesheet is not batched yet, only get expenses already paid expenses in expenses table
		$status = EXPENSE_UNPAID;
		if ($timesheet['status'] < TIMESHEET_BATCHED) {
			$status = EXPENSE_PAID;
		}
		$paid_expenses = $this->expense_model->get_timesheet_expenses($timesheet_id, $status);
		foreach($paid_expenses as $e) {
			$cost = $e[$type];
			if ($e['tax'] == GST_ADD) {
				$cost *= 1.1;
			}
			$total_expenses += $cost;
		}
		return $total_expenses;
	}
}