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
		$this->load->model('job/job_shift_model');
		$this->load->model('page/page_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() 
	{
		$data['user'] = $this->session->userdata('user_data');	
		$this->load->view('dashboard', isset($data) ? $data : NULL);
	}
	
	function load_daily_statistics()
	{
		$today = date('Y-m-d');
		$today_shifts = $this->job_shift_model->search_shifts(array(
			'date_from' => $today,
			'date_to' => $today
		));
		$data['today_shifts'] = count($today_shifts);
		
		# This week
		$this_week = modules::run('common/the_week', $today);
		$this_week_shifts = $this->job_shift_model->search_shifts(array(
			'date_from' => date('Y-m-d', $this_week['start']),
			'date_to' => date('Y-m-d', $this_week['end'])
		));
		$data['this_week_shifts'] = count($this_week_shifts);
		
		# This month
		$month_days = date('t');
		$this_month_shifts = $this->job_shift_model->search_shifts(array(
			'date_from' => date('Y-m') . '-01',
			'date_to' => date('Y-m') . '-' . $month_days
		));
		$data['this_month_shifts'] = count($this_month_shifts);
		$data['active_jobs'] = $this->job_model->count_active_jobs();
		$this->load->view('daily_statistics', isset($data) ? $data : NULL);	
	}
	
	function today_shifts()
	{
		$data = array(
						'client_user_id' => '',
						'client_client_id' => '',
						'shift_date' => date('d-m-Y', now()),
						'search_shift_date_to' => date('d-m-Y', now()),
						'shift_status' => 'shifts'
					);
		$this->session->set_flashdata('search_shift_filters',$data);
		redirect('job/search');
	}
	
	function this_week_shifts()
	{
		$today = date('Y-m-d');
		$this_week = modules::run('common/the_week', $today);
		$data = array(
						'client_user_id' => '',
						'client_client_id' => '',
						'shift_date' => date('d-m-Y', $this_week['start']),
						'search_shift_date_to' => date('d-m-Y', $this_week['end']),
						'shift_status' => 'shifts'
					);
		$this->session->set_flashdata('search_shift_filters',$data);
		redirect('job/search');
	}
	
	function this_month_shifts()
	{
		$start = date('Y-m') . '-01';
		$month_days = date('t');
		$end = date('Y-m') . '-' . $month_days;
		$data = array(
						'client_user_id' => '',
						'client_client_id' => '',
						'shift_date' => date('d-m-Y', strtotime($start)),
						'search_shift_date_to' => date('d-m-Y', strtotime($end)),
						'shift_status' => 'shifts'
					);
		$this->session->set_flashdata('search_shift_filters',$data);
		redirect('job/search');
	}
	
	function active_campaigns()
	{
		$data = array(
						'client_user_id' => '',
						'client_client_id' => '',
						'shift_date' => '',
						'search_shift_date_to' => '',
						'shift_status' => 'job_campaign'
					);
		$this->session->set_flashdata('search_shift_filters',$data);
		redirect('job/search');
	}
	
	function load_conversations()
	{
			
	}

	public function activity_log()
	{
		$this->load->view('activity_log', isset($data) ? $data : NULL);
	}	
}