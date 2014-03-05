<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Job extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->load->model('client/client_model');
		$this->user = $this->session->userdata('user_data');
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
	
	function job_details($job_id, $job_date = '')
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
		
		$this->load->view('job_details', isset($data) ? $data : NULL);		
	}
		
	function search_jobs()
	{
		$data['search_shift_filters'] = array('client_user_id' => '','client_client_id' => '','shift_date' => date('d-m-Y'),'shift_status' => '');
		if($this->session->userdata('search_shift_filters')){
			$data['search_shift_filters'] = $this->session->userdata('search_shift_filters');	
		}
		if ($this->input->post())
		{
			$data['jobs'] = $this->job_model->search_jobs($this->input->post('keyword'));	
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
			array('value' => 'confirmed', 'label' => 'Confirmed Shifts')
		);
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function field_input($field_name, $field_value=null, $size=null) {
		$data['field_name'] = $field_name;
		$data['jobs'] = $this->job_model->all_jobs();
		$this->load->view('field_input', isset($data) ? $data : NULL);
	}
}