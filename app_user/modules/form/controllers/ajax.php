<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('form_model');
	}
	
	function add_form() {
		$input = $this->input->post();
		if (!$input['name']) {
			echo json_encode(array('ok' => false));
			return;
		}
		$form_id = $this->form_model->add_form($input);
		echo json_encode(array('ok' => true, 'form_id' => $form_id));
	}
	
	function delete_form() {
		$form_id = $this->input->post('form_id');
		$this->form_model->delete_form($form_id);
	}
	
	function update_settings() {
		$input = $this->input->post();
		$this->form_model->update_form($input['form_id'], array('receive_email' => $input['receive_email']));
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
	
	function view_applicant($applicant_id) {
		$data['applicant_id'] = $applicant_id;
		$data['applicant'] = $this->form_model->get_applicant($applicant_id);
		$this->load->view('applicant/modal_view', isset($data) ? $data : NULL);
	}
	
	function reject_applicant() {
		$applicant_id = $this->input->post('applicant_id');
		$this->form_model->reject_applicant($applicant_id);
	}
}
	