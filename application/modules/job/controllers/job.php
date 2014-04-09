<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Job extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->load->model('client/client_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
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
					echo modules::run('job/calendar/index', $param1, $param2,$param3,$param4);	
				break;
			case 'search':
					$this->search_jobs($param1,$param2,$param3, $param4);
				break;
			default:
					
				break;
		}
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
			$data['user_id'] = $this->user['user_id'];
			$job_id = $this->job_model->insert_job($data);
			redirect('job/details/' . $job_id);
		}
		$this->load->view('create', isset($data) ? $data : NULL);
	}
	
	function job_details($job_id, $job_date = '', $status = '')
	{
		$this->session->unset_userdata('job_date');
		if (!$job_id)
		{
			redirect('job');
		}
		if ($job_date) {
			$this->session->set_userdata('job_date', $job_date);
		}
		$job = $this->job_model->get_job($job_id);
		$data['job'] = $job;
		$data['client'] = $this->client_model->get_client($job['client_id']);
		if ($status != '') {
			$this->session->set_userdata('shift_status_filter', $status);
		}
		else
		{
			$this->session->unset_userdata('shift_status_filter');
		}
		$data['is_client'] = $this->is_client;
		$this->load->view('job_details', isset($data) ? $data : NULL);		
	}
		
	function search_jobs($shift_status='', $params='')
	{
		$data['search_shift_filters'] = array(
			'client_user_id' => '',
			'staff_name' => '',
			'shift_date' => date('d-m-Y'),
			'search_shift_date_to' => '',
			'shift_status' => 'job_campaign'
		);
		if ($shift_status == 'shift')
		{
			//$data['search_shift_filters']['shift_status'] = 'shift';
			$params = explode(',', urldecode($params));
			$staff_id = $params[0];
			$staff = modules::run('user/get_user', $staff_id);
			$data['search_shift_filters']['staff_name'] = $staff['first_name'] . ' ' . $staff['last_name'];
			$data['search_shift_filters']['shift_date'] = $params[1];
			$data['search_shift_filters']['search_shift_date_to'] = $params[2];
		}
		if($this->session->flashdata('search_shift_filters'))
		{
			$data['search_shift_filters'] = $this->session->flashdata('search_shift_filters');
		}
		#if ($this->input->post())
		#{
		#	$data['jobs'] = $this->job_model->search_jobs($this->input->post('keyword'));	
		#}
		
		if (modules::run('auth/is_client'))
		{
			$data['search_shift_filters']['client_user_id'] = $this->user['user_id'];
		}
		
		$this->load->view('jobs_search_form', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: count_job_shifts
	*	@desc: function to count number of shifts in a job, optionally in a specified date
	*	@access: public
	*	@param: (int) $job_id, (int - timestamp) $job_date
	*	@return: (int)
	*/
	function count_job_shifts($job_id, $job_date = null, $status = null)
	{
		if ($job_date)
		{
			$job_date = date('Y-m-d', $job_date);
		}
		echo $this->job_shift_model->count_job_shifts($job_id, $job_date, $status);
	}
	/**
	*	@name: get_day_shifts
	*	@desc: function to get list of shifts in a day
	*	@access: public
	*	@param: (int) $job_id, (int - timestamp) $job_date
	*	@return: (array)
	*/
	function get_day_shifts($job_id, $job_date)
	{
		$job_date = date('Y-m-d', $job_date);
		$shifts = $this->job_shift_model->get_job_shifts($job_id, $job_date);
		$ids = array();
		foreach($shifts as $shift)
		{
			$ids[] = $shift['shift_id'];
		}
		return $ids;
	}
	
	function get_job($job_id)
	{
		return $this->job_model->get_job($job_id);
	}
	
	function get_job_by_name($name)
	{
		return $this->job_model->get_job_by_name($name);
	}
	
	function dropdown_status($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_status', isset($data) ? $data : NULL);
	}
	
	function dropdown_engines($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_engines', isset($data) ? $data : NULL);
	}
	
	function get_job_start_date($job_id)
	{
		return $this->job_model->get_job_start_date($job_id);
	}
	
	function get_job_finish_date($job_id)
	{
		return $this->job_model->get_job_finish_date($job_id);
	}

	
	function status_to_class($status)
	{
		$class = '';
		switch($status)
		{
			case SHIFT_UNCONFIRMED: $class = 'warning';
				break;
			case SHIFT_CONFIRMED: $class = 'success';
				break;
			case SHIFT_FINISHED: $class = 'disabled';
				break;
			case SHIFT_REJECTED: $class = 'danger';
				break;
			case SHIFT_UNASSIGNED:
			default: $class = '';
				break;
		}
		return $class;
	}
		
	/**
	*	@name: field_select_shift_status
	*	@desc: custom select shift status field
	*	@access: public
	*	@param: - $field_name
	*			- $field_value (optional)
	*			- $size (optional)
	*	@return: custom select staff status field
	*/
	function field_select_shift_status($field_name, $field_value=null, $size=null)
	{
		$array = array(
			array('value' => 'active', 'label' => 'All Active Shifts'),
			array('value' => 'unassigned', 'label' => 'Un-Filled Shifts'),
			array('value' => 'unconfirmed', 'label' => 'Un-Confirmed Shifts'),
			array('value' => 'confirmed', 'label' => 'Confirmed Shifts'),
			array('value' => 'completed', 'label' => 'Completed Shifts')
		);
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function field_select($field_name, $field_value=null)
	{
		$jobs = $this->job_model->search_jobs();
		$array = array();
		foreach($jobs as $job)
		{
			$array[] = array(
				'value' => $job['job_id'],
				'label' => $job['name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	function field_input($field_name, $field_value=null, $size=null) {
		$data['field_name'] = $field_name;
		$data['jobs'] = $this->job_model->search_jobs();
		
		$this->load->view('field_input', isset($data) ? $data : NULL);
	}
}