<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@desc: Calendar controller
 *	
 */

class Calendar extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		//$this->user = $this->session->userdata('user_data');
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{
			default:
				$this->home();
			break;
		}
	}
	
	function home()
	{
		$date = date('Y-m-d');
		$event_date = strtotime($date) . '000';
		$out[] = array(
					'active_job_campaigns' => 12,
					'unfilled_shifts' => 2,
					'unconfirmed_shift' => 10,
					'confirmed_shift' => 4,
					'title' => 'Test',
					'url' => 'My Url',
					'start' => $event_date,
					'end' => $event_date,
				);
		$data['events_source'] = json_encode($out);
		$this->load->view('calendar/company_calendar', isset($data) ? $data : NULL);
	}
	
}