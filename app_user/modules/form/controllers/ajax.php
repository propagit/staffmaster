<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('form_model');
	}
	
	function add_form() {
		$input = $this->input->post();
		$form_id = $this->form_model->add_form($input);
		echo $form_id;
	}
	
	function active_field() {
		$input = $this->input->post();
		if ($this->form_model->active_field($input['form_id'], $input['label'], $input['name'])) {
			echo 'success';
		} else {
			echo 'default';
		}
	}
	
	function require_field() {
		$input = $this->input->post();
		if ($this->form_model->require_field($input['form_id'], $input['name'])) {
			echo 'success';
		} else {
			echo 'default';
		}
	}
}
	