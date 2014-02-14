<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Timesheet_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_staff_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->list_timesheets();
				break;
		}
		
	}
	
	function list_timesheets()
	{
		$data['timesheets'] = $this->timesheet_staff_model->get_timesheets();
		$this->load->view('staff/main_view', isset($data) ? $data : NULL);
	}
	

}