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
		$this->load->view('staff/rosters_list_table', isset($data) ? $data : NULL);
	}
	function confirm_rosters()
	{
		$rosters = $this->input->post('rosters');
		foreach($rosters as $roster)
		{
			$this->roster_model->update_roster($roster, array('status' => 2));
		}
	}
	function reject_rosters()
	{
		$rosters = $this->input->post('rosters');
		foreach($rosters as $roster)
		{
			$this->roster_model->update_roster($roster, array('status' => -2));
		}
	}
	
	function load_roster_venue($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('staff/roster_map', isset($data) ? $data : NULL);
	}
	
	function map($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('staff/map', isset($data) ? $data : NULL);
	}
}