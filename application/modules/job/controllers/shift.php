<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Shift extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function form_create($job_id)
	{
		$data['job_id'] = $job_id;
		$this->load->view('shift_create_form', isset($data) ? $data : NULL);
	}
	
	
}