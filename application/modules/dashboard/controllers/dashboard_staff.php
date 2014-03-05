<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Dashboard_staff
 * @author: namnd86@gmail.com
 */

class Dashboard_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('staff/dashboard', isset($data) ? $data : NULL);
	}
	
	public function activity_log()
	{
		$this->load->view('staff/activity_log', isset($data) ? $data : NULL);
	}
}