<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: attribute
*	@controller: ajax_venue
*/

class Ajax_custom extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('custom_field_model');
	}

	function add_field() {
		$input = $this->input->post();
		if (in_array($input['type'], array('radio', 'checkbox', 'select'))) {
			$input['attributes'] = json_encode(array('Option one', 'Option two'));
		}
		if($input['type'] = 'fileDate'){
			$input['label'] = json_encode(array('file_label' => 'File Button With Date','date_label' => 'Date'));
		}
		$field_id = $this->custom_field_model->add_field($input);
		echo $field_id;
	}
	
	function get_fields() {
		$fields = $this->custom_field_model->get_fields();
		if (count($fields) == 0) {
			$this->load->view('custom/no_field');
		} else {
			foreach($fields as $field) { 
				$data['field'] = $field;
				$this->load->view('custom/field/' . $field['type'], isset($data) ? $data : NULL);
			}
		}
	}
	
	function load_field_edit_form() {
		$field_id = $this->input->post('field_id');
		$data['field'] = $this->custom_field_model->get_field($field_id);
		$this->load->view('custom/edit_form', isset($data) ? $data : NULL);		
	}
	
	function update_field() {
		$input = $this->input->post();
		if (isset($input['attributes'])) {
			$options = explode("\n", trim($input['attributes']));
			$input['attributes'] = json_encode($options);
		}
		if (isset($input['admin_only'])) {
			$input['admin_only'] = 1;
		} else {
			$input['admin_only'] = 0;
		}
		if(isset($input['fileDate'])){
			$input['label'] = json_encode(array('file_label' => $input['file_label'],'date_label' => $input['date_label']));
			unset($input['file_label']);
			unset($input['date_label']);
			unset($input['fileDate']);
		}
		
		$this->custom_field_model->update_field($input['field_id'], $input);
	}
	
	function delete_field() {
		$field_id = $this->input->post('field_id');
		if ($this->custom_field_model->delete_field($field_id)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
}