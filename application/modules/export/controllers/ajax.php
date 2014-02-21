<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('export_model');
	}
	
	function load_objects($object) {
		$data['object'] = $object;
		$this->load->view('object_view', isset($data) ? $data : NULL);
	}
	
	function load_templates() {
		$object = $this->input->post('object');
		$format = $this->input->post('format');
		$templates = $this->export_model->get_templates($object, $format);
		$data = array();
		foreach($templates as $template) {
			$data[] = array(
				'value' => $template['export_id'],
				'label' => $template['name']
			);
		}
		echo modules::run('common/field_select', $data, 'export_id', '','', false);
	}
	
	function load_template() {
		$export_id = $this->input->post('export_id');
		$data['fields'] = $this->export_model->get_fields($export_id);
		$this->load->view('template_view', isset($data) ? $data : NULL);
	}
	
	function load_preset() {
		$object = $this->input->post('object');
		$format = $this->input->post('format');
		$data['fields'] = $this->export_model->get_template_fields($object, $format);
		$this->load->view('preset_view', isset($data) ? $data : NULL);
	}
	
	function add_field() {
		$data = array(
			'export_id' => $this->input->post('export_id'),
			'title' => $this->input->post('title'),
			'value' => $this->input->post('value')
		);
		$field_id = $this->export_model->add_field($data);
		$this->export_model->update_field($field_id, array('order' => $field_id));
	}
	
	function update_fields_order() {
		$order = explode(',', $this->input->post('order'));
		foreach($order as $key => $field_id) {
			$this->export_model->update_field($field_id, array('order' => $key));
		}
	}
	
	function remove_field() {
		$this->export_model->remove_field($this->input->post('field_id'));
	}
}