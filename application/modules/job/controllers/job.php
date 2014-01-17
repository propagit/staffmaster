<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Job extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->load->model('client/client_model');
	}
	
	public function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{
			case 'create':
					$this->create_job();
				break;
			case 'create_job_shifts':
					$this->create_job_shifts();
				break;
			case 'add_shift':
					$this->add_shift();
				break;
			case 'shift':
					$this->view_shift($param1);
				break;
			case 'details':
					$this->job_details($param1,$param2,$param3, $param4);
				break;
			case 'calendar':
					$this->job_calendar();
				break;
			case 'search':
					$this->search_jobs();
				break;
			default:
					
				break;
		}
	}
	
	function job_calendar()
	{
		$prefs['template'] = '
				
			{table_open}<table class="calendar" border="0" cellpadding="0" cellspacing="0" width="100%">{/table_open}
			
			{heading_row_start}<tr class="heading">{/heading_row_start}
			
			{heading_previous_cell}<th><a href="{previous_url}"><span class="label label-default"><i class="icon icon-caret-left"></i></span></a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}"></th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}"><span class="label label-default"><i class="icon icon-caret-right"></i></span></a></th>{/heading_next_cell}
			
			{heading_row_end}</tr>{/heading_row_end}
			
			{week_row_start}<tr class="week_day">{/week_row_start}
			{week_day_cell}<td>{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}
			
			{cal_row_start}<tr class="date-row">{/cal_row_start}
			{cal_cell_start}<td><div class="date">{/cal_cell_start}
			
			{cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
			{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
			
			{cal_cell_no_content}{day}{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
			
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
			
			{cal_cell_end}</div></td>{/cal_cell_end}
			{cal_row_end}</tr>{/cal_row_end}
			
			{table_close}</table>{/table_close}
		';
		$prefs['day_type'] = 'long';
		$prefs['start_day'] = 'monday';
		#$prefs['show_next_prev'] = TRUE;
		
		$this->load->library('calendar', $prefs);
		$data['calendar'] = $this->calendar->generate();
		
		$this->load->view('calendar', isset($data) ? $data : NULL);
	}
	
	function create_job()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'name', 'label' => 'Job Group Name', 'rules' => 'required'),
			array('field' => 'client_id', 'label' => 'Client', 'rules' => 'required')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			$data = $this->input->post();
			$job_id = $this->job_model->insert_job($data);
			redirect('job/details/' . $job_id);
		}
		$this->load->view('create', isset($data) ? $data : NULL);
	}
	
	
	function view_shift($shift_id)
	{
		$shift = $this->job_shift_model->get_shift($shift_id);
		$job = $this->job_model->get_job($shift['job_id']);
		$data['client'] = $this->client_model->get_client_by_client_id($job['client_id']);
		$data['job'] = $job;
		$data['shift'] = $shift;
		$this->load->view('job_card', isset($data) ? $data : NULL);
	}
	
	function job_details($job_id)
	{
		$this->session->unset_userdata('job_date');
		if (!$job_id)
		{
			redirect('job');
		}
		$job = $this->job_model->get_job($job_id);
		$data['job'] = $job;
		$data['client'] = $this->client_model->get_client_by_client_id($job['client_id']);
		
		$this->load->view('details', isset($data) ? $data : NULL);
		
	}
	
	/*
	function job_details($job_id, $view='list', $year='', $month='')
	{
		
		$year = ($year != '') ? $year : date('Y');
		$month = ($month != '') ? $month : date('m');
			
		$job = $this->job_model->get_job($job_id);
		$data['client'] = $this->client_model->get_client_by_client_id($job['client_id']);
		$data['job'] = $job;
		if ($view == 'calendar')
		{
			$prefs['template'] = '
				
				{table_open}<table class="calendar" border="0" cellpadding="0" cellspacing="0" width="100%">{/table_open}
				
				{heading_row_start}<tr class="heading">{/heading_row_start}
				
				
				{heading_previous_cell}<td colspan="2"></td><td colspan="3" class="right pull-right"><a href="{previous_url}"><span class="label label-default"><i class="icon icon-caret-left"></i></span></a></td>{/heading_previous_cell}
				
				{heading_title_cell}<td>{heading}</td>{/heading_title_cell}
				{heading_next_cell}<td colspan="3"><a href="{next_url}"><span class="label label-default"><i class="icon icon-caret-right"></i></span></a></td>{/heading_next_cell}
				
				{heading_row_end}</tr>{/heading_row_end}
				
				{week_row_start}<tr class="week_day">{/week_row_start}
				{week_day_cell}<td>{week_day}</td>{/week_day_cell}
				{week_row_end}</tr>{/week_row_end}
				
				{cal_row_start}<tr class="date-row">{/cal_row_start}
				{cal_cell_start}<td><div class="date">{/cal_cell_start}
				
				{cal_cell_content}{day}<div class="addjob" day="{day}">{content}</div>{/cal_cell_content}
				{cal_cell_content_today}<div class="highlight addjob" day="{day}">{day}{content}</div>{/cal_cell_content_today}
				
				{cal_cell_no_content}<div class="addjob" day="{day}">{day}</div>{/cal_cell_no_content}
				{cal_cell_no_content_today}<div class="highlight addjob" day="{day}">{day}</div>{/cal_cell_no_content_today}
				
				{cal_cell_blank}<div class="blank">&nbsp;</div>{/cal_cell_blank}
				
				{cal_cell_end}</div></td>{/cal_cell_end}
				{cal_row_end}</tr>{/cal_row_end}
				
				{table_close}</table>{/table_close}
			';
			$prefs['day_type'] = 'long';
			$prefs['start_day'] = 'monday';
			$prefs['show_next_prev'] = TRUE;
			$prefs['next_prev_url'] = base_url(). 'job/details/' . $job_id . '/calendar';
			
			$this->load->library('calendar', $prefs);
			$job_shifts = $this->job_shift_model->get_job_shifts_by_month($job['job_id'], $year, $month);
			$calendar_data = array();
			foreach($job_shifts as $shift)
			{
				$date_array = explode('-', $shift['job_date']);
				$index = intval($date_array[2]);
				$calendar_data[$index] = '<div class="clearfix"></div><div class="date_content pull-left"><a href="' . base_url() . 'job/shift/' . $shift['shift_id'] . '"><span class="label label-danger"><i class="icon-remove"></i></span></a></div>';
			}
			$data['calendar'] = $this->calendar->generate($year, $month, $calendar_data);
			$data['year'] = $year;
			$data['month'] = $month;
			$this->load->view('shifts_calendar_view', isset($data) ? $data : NULL);
		}
		else
		{
			$data['shifts'] = $this->job_shift_model->get_job_shifts($job['job_id']);
			$this->load->view('shifts_list_view', isset($data) ? $data : NULL);
		}
	}
	*/
	
	function search_jobs()
	{
		if ($this->input->post())
		{
			$data['jobs'] = $this->job_model->search_jobs($this->input->post('keyword'));	
		}

		
		$this->load->view('search', isset($data) ? $data : NULL);
	}
	
	/* 
	 *	Count job shifts
	 *	$date: timestamp 
	 */
	function count_job_shifts($job_id, $job_date = null)
	{
		if ($job_date)
		{
			$job_date = date('Y-m-d', $job_date);
		}
		echo $this->job_shift_model->count_job_shifts($job_id, $job_date);
	}
	
	function dropdown_engines($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_engines', isset($data) ? $data : NULL);
	}
	
}