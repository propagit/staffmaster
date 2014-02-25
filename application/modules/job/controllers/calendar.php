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
		$this->load->view('calendar/company_calendar', isset($data) ? $data : NULL);
	}
	
}