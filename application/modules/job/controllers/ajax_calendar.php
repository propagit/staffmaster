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
	
}