<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Public_dispatcher
 * Description: control main flow of the public pages
 * @author: namnd86@gmail.com
 */

class Public_dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{		
		
	}
	
	function form($form_id)
	{
		if ($this->input->post()) {
			#var_dump($this->input->post());
		}
		#$this->output->enable_profiler();
		#error_reporting(4);
		$this->load->model('form/form_model');
		$form = $this->form_model->get_form($form_id);
		if (!$form) {
			show_error('Sorry, form not found');
			exit();
		}
		$data['form'] = $form;
		$fields = $this->form_model->get_fields($form_id);
		$data['personal_fields'] = modules::run('form/personal_fields', $fields);
		$data['extra_fields'] = modules::run('form/extra_fields', $fields);
		$data['custom_fields'] = $this->form_model->get_custom_fields();
		
		$data['roles'] = modules::run('attribute/role/get_roles');
		$data['groups'] = modules::run('attribute/group/get_groups');
		$this->load->view('public/form_view', isset($data) ? $data : NULL);
	}
	
}