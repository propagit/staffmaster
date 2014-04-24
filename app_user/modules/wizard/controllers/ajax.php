<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('wizard_model');
	}
	
	function turnoff()
	{
		if($this->input->post('turnoff') == "true")
		{
			$this->session->set_userdata('turnoff_wizard', true);
		}
	}
	
	
	function reload_wizard()
	{
		$data['company_profile'] = $this->wizard_model->check_company_profile();
		$data['has_staff'] = $this->wizard_model->check_has_staff();
		$data['has_client'] = $this->wizard_model->check_has_client();
		$data['has_payrate'] = $this->wizard_model->check_has_payrate();
		$data['has_venue'] = $this->wizard_model->check_has_venue();
		$data['has_role'] = $this->wizard_model->check_has_role();
		$data['has_uniform'] = $this->wizard_model->check_has_uniform();
		$data['has_job'] = $this->wizard_model->check_has_job();
		$data['step'] = $this->input->post('step');
		$this->load->view('steps_view', isset($data) ? $data : NULL);
		
	}
}