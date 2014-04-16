<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Shift extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('job_shift_model');
	}
	
	
	function form_create($job_id)
	{
		$data['job_id'] = $job_id;
		$this->load->view('shift_create_form', isset($data) ? $data : NULL);
	}
	
	function search_staff_form($shift_id) {
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['shift'] = $shift;
		$location_id = null;
		$parent_id = null;
		$venue = modules::run('attribute/venue/get_venue', $shift['venue_id']);
		if ($venue) {
			$location = modules::run('attribute/location/get_location', $venue['location_id']);
			if ($location) {
				$location_id = $location['location_id'];
				$parent_id = $location['parent_id'];
			}
		}
		$data['parent_id'] = $parent_id;
		$data['location_id'] = $location_id;
		$this->load->view('shift/search_staff/search_form', isset($data) ? $data : NULL);
	}
	
	function add_expense_form($shift_id) {
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/expense/add_form', isset($data) ? $data : NULL);
	}
	
	function get_shift($shift_id) {
		return $this->job_shift_model->get_job_shift($shift_id);
	}
	
	/**
	*	@name: field_select_status
	*	@desc: custom select shift status field
	*	@access: public
	*	@param: - $field_name
	*			- $field_value (optional)
	*			- $size (optional)
	*	@return: custom select staff status field
	*/
	function field_select_status($field_name, $field_value=null, $size=null)
	{
		$temp_field_value = $field_value;
		$array = array(
			array('value' => SHIFT_UNASSIGNED, 'label' => 'Un-Filled Shifts'),
			array('value' => SHIFT_UNCONFIRMED, 'label' => 'Un-Confirmed Shifts'),
			array('value' => SHIFT_REJECTED, 'label' => 'Rejected Shifts'),
			array('value' => SHIFT_CONFIRMED, 'label' => 'Confirmed Shifts'),
			array('value' => SHIFT_FINISHED, 'label' => 'Completed Shifts')
		);
		if(!$field_value){
			$temp_field_value = 'Un-Filled Shifts';
		}
		if($field_value == -2){
			$temp_field_value = 'Rejected Shifts';
		}
		return modules::run('common/field_select', $array, $field_name, $temp_field_value, $size);
	}
	
	function field_select_fields($field_name, $field_value=null, $size=null)
	{
		$fields = array(
			#array('value' => 'job_date', 'label' => 'Job Date'),
			array('value' => 'start_time', 'label' => 'Start Time'),
			array('value' => 'finish_time', 'label' => 'Finish Time'),
			#array('value' => 'break_time', 'label' => 'Break Time'),
			array('value' => 'venue_id', 'label' => 'Venue'),
			array('value' => 'role_id', 'label' => 'Role'),
			array('value' => 'uniform_id', 'label' => 'Uniform'),
			array('value' => 'payrate_id', 'label' => 'Pay Rate'),
			#array('value' => 'supervisor_id', 'label' => 'Supervisor'),
			#array('value' => 'staff_id', 'label' => 'Staff'),
			#array('value' => 'expenses', 'label' => 'Expenses')
		);
		return modules::run('common/field_select', $fields, $field_name, $field_value, $size);
	}
	
	function status_to_text($status)
	{
		$text = '';
		switch($status)
		{
			case SHIFT_REJECTED: $text = 'rejected';
				break;
			case SHIFT_UNCONFIRMED: $text = 'unconfirmed';
				break;
			case SHIFT_CONFIRMED: $text = 'confirmed';
				break;
			case SHIFT_FINISHED: $text = 'finished';
				break;
		}
		return $text;
	}
	
	function get_shift_second($shift)
	{
		$s = $shift['finish_time'] - $shift['start_time'];
		$a = json_decode($shift['break_time']);
		
		if (count($a) > 0) 
		{
			foreach($a as $break)
			{
				$s -= $break->length;
			}
		}
		return $s;
	}
	/**
	*	@name: update_shift_time
	*	@desc: Update shift time - this function is mostly used while updating time for multiple shifts
	*	@access: public
	*	@param: ([array]) shift ids, start time or finish time to update, new time
	*	@return: null
	*/
	function update_shift_time($params)
	{
		if(isset($params['shift_ids'])){
			$shift_time_mode = $params['shift_time_mode'];
			foreach($params['shift_ids'] as $shift_id){
				$shift_info = $this->job_shift_model->get_job_shift($shift_id);
				$old_shift_time_date_only = date('Y-m-d',$shift_info[$shift_time_mode]);
				$new_shift_start_or_finish_time = strtotime($old_shift_time_date_only.' '.$params['time_hour'].':'.$params['time_minutes'].':'.'00');	
				$this->job_shift_model->update_job_shift($shift_id, array($shift_time_mode => $new_shift_start_or_finish_time));
			}
		}
	}
}