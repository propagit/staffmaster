<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Dashboard extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('job/job_model');
		$this->load->model('page/page_model');
	}
	
	public function index()
	{
		$data['user'] = $this->session->userdata('user_data');
		
		$this->load->view('dashboard', isset($data) ? $data : NULL);
	}

		
}