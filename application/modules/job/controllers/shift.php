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
	
}