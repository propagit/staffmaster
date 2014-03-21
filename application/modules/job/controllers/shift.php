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
	
	function field_select_fields($field_name, $field_value=null, $size=null)
	{
		$fields = array(
			#array('value' => 'job_date', 'label' => 'Job Date'),
			#array('value' => 'start_time', 'label' => 'Start Time'),
			#array('value' => 'finish_time', 'label' => 'Finish Time'),
			#array('value' => 'break_time', 'label' => 'Break Time'),
			array('value' => 'venue_id', 'label' => 'Venue'),
			array('value' => 'role_id', 'label' => 'Role'),
			array('value' => 'uniform_id', 'label' => 'Uniform'),
			array('value' => 'payrate_id', 'label' => 'Pay Rate'),
			array('value' => 'supervisor_id', 'label' => 'Supervisor'),
			array('value' => 'staff_id', 'label' => 'Staff'),
			array('value' => 'expenses', 'label' => 'Expenses')
		);
		return modules::run('common/field_select', $fields, $field_name, $field_value, $size);
	}
}