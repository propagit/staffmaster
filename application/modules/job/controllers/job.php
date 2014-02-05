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
		
		$this->load->view('job_details', isset($data) ? $data : NULL);		
	}
		
	function search_jobs()
	{
		if ($this->input->post())
		{
			$data['jobs'] = $this->job_model->search_jobs($this->input->post('keyword'));	
		}		
		$this->load->view('jobs_search', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: count_job_shifts
	*	@desc: function to count number of shifts in a job, optionally in a specified date
	*	@access: public
	*	@param: (int) $job_id, (int - timestamp) $job_date
	*	@return: (int)
	*/
	function count_job_shifts($job_id, $job_date = null)
	{
		if ($job_date)
		{
			$job_date = date('Y-m-d', $job_date);
		}
		echo $this->job_shift_model->count_job_shifts($job_id, $job_date);
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
	
	
	function status_to_class($status)
	{
		$class = '';
		switch($status)
		{
			case 1: $class = 'active';
				break;
			case 2: $class = 'success';
				break;
			case 3: $class = 'danger';
				break;
			case 0:
			default: $class = '';
				break;
		}
		return $class;
	}
	
}