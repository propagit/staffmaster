<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: job
 *	@controller: ajax_client
 */

class Ajax_client extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}
	
	function create_job()
	{
		$input = $this->input->post();
		if (!$input['name']) {
			echo json_encode(array('ok' => false, 'error_id' => 'name'));
			return;
		}
		$input['client_id'] = $this->user['user_id'];
		$input['user_id'] = $this->user['user_id'];
		$job_id = $this->job_model->insert_job($input);
		echo json_encode(array('ok' => true, 'job_id' => $job_id));		
	}
	
}