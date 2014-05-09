<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('wizard_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view($param);
				break;
		}
		
	}
	
	function main_view($step) 
	{
		if ($this->session->userdata('turnoff_wizard') || modules::run('auth/is_staff') || modules::run('auth/is_client'))
		{
			return;
		}
		$data['company_profile'] = $this->wizard_model->check_company_profile();
		$data['has_staff'] = $this->wizard_model->check_has_staff();
		$data['has_client'] = $this->wizard_model->check_has_client();
		$data['has_payrate'] = $this->wizard_model->check_has_payrate();
		$data['has_venue'] = $this->wizard_model->check_has_venue();
		$data['has_role'] = $this->wizard_model->check_has_role();
		$data['has_uniform'] = $this->wizard_model->check_has_uniform();
		$data['has_job'] = $this->wizard_model->check_has_job();
		foreach($data as $condition)
		{
			if (!$condition) 
			{
				if ($step == 'dashboard')
				{
					$this->load->view('popup_view', isset($data) ? $data : NULL);
					return;
				}
				else
				{
					$data['step'] = $step;
					$this->load->view('main_view', array('data' => $data));
					return;
				}				
			}
		}
		
	}
	
	
}