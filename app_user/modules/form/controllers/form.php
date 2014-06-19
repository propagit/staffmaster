<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Form
 */

class Form extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('form_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'edit':
					$this->edit_view($param);
				break;
			default:
					$this->main_view();
				break;
		}
	}
	
	function main_view()
	{
		$data['forms'] = $this->form_model->get_forms();
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function edit_view($form_id)
	{
		$this->load->view('edit_view', isset($data) ? $data : NULL);
	}
	
}