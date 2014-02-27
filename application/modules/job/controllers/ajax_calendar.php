<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@desc: Ajax controller for calenadar
 *	
 */

class Ajax_calendar extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
	}
	
	function get_calendar_data()
	{
		$new_date = $this->input->post('new_date',true);
		$month = date('m',strtotime($new_date));
		$year = date('Y',strtotime($new_date));
		$data['custom_date'] = $new_date;
		$data['events_source'] = modules::run('job/calendar/get_company_calendar_data',$month,$year);
		$this->load->view('calendar/company_calendar', isset($data) ? $data : NULL);
		
	}
	
}