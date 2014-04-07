<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: job
*	@controller: job_client
*/

class Job_client extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		#$this->load->model('job_shift_model');
		#$this->load->model('client/client_model');
		$user = $this->session->userdata('user_data');
		$this->user = modules::run('user/get_user_client', $user['user_id']);
	}

	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		
		switch($method)
		{
			case 'calendar':
					echo modules::run('job/calendar/index', $param1, $param2, $param3, $param4);
				break;
			case 'create':
					$this->create_job();
				break;
			case 'search':
					echo modules::run('job/search_jobs', $param1, $param2, $param3, $param4);
				break;
			case 'details':
					echo modules::run('job/job_details', $param1, $param2, $param3, $param4);
				break;
			default:					
				break;
		}
	}
	
	function create_job()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'name', 'label' => 'Job Group Name', 'rules' => 'required')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			$data = $this->input->post();
			$data['user_id'] = $this->user['user_id'];
			$data['client_id'] = $this->user['user_id'];
			$job_id = $this->job_model->insert_job($data);
			redirect('job/details/' . $job_id);
		}
		$this->load->view('create', isset($data) ? $data : NULL);
	}
	
	
}