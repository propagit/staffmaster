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
	
	function get_company_calendar_data()
	{
		$shifts = $this->job_shift_model->get_shift_by_year_and_month(02,2014);

	}
	
}