<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax Dashboard
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('job/job_model');
		$this->load->model('job/job_shift_model');
		$this->load->model('page/page_model');
	}
	
	
	# get daily stats
	function get_completed_shift_count()
	{
		echo modules::run('timesheet/get_ungenerated_timesheet_count');
	}
}