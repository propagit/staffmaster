<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Dashboard_staff
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('roster_model');
	}
	
	
	function load_month_rosters()
	{
		$this->session->set_userdata('active_month', $this->input->post('ts'));
	}
	
	public function load_rosters()
	{
		$active_month = $this->session->userdata('active_month');
		$data['rosters'] = $this->roster_model->get_rosters(date('Y-m', $active_month));
		$this->load->view('staff/list_rosters_table', isset($data) ? $data : NULL);
	}

		
}