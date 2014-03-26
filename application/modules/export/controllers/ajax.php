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
	
	/**
	*	@name: load_object
	*	@desc: ajax function to load (abstract) view of an export template
	*	@access: public
	*	@param: (string) $object
	*	@return: (html) (abstract) view of export template configuration
	*/
	function load_object($object='invoice') {
		$data['object'] = $object;
		$this->load->view('object_view', isset($data) ? $data : NULL);
	}
	
	function load_templates() {		
		$object = $this->input->post('object');
		$format = $this->input->post('format');
		$templates = $this->export_model->get_templates($object, $format);
		$array = array();
		foreach($templates as $template) {
			$array[] = array(
				'value' => $template['export_id'],
				'label' => $template['name']
			);
		}
		$data['templates'] = $array;
		$data['fields'] = $this->export_model->get_template_fields($object, $format);
		$data['object'] = $object;
		$this->load->view('templates_view', isset($data) ? $data : NULL);
	}
	
	function load_template() {
		$export_id = $this->input->post('export_id');
		$data['fields'] = $this->export_model->get_fields($export_id);
		$data['export_id'] = $export_id;
		$this->load->view('template_view', isset($data) ? $data : NULL);
	}
	
	
	function add_field() {
		$field = array(
			'export_id' => $this->input->post('export_id'),
			'title' => $this->input->post('title'),
			'value' => $this->input->post('value')
		);
		$field_id = $this->export_model->add_field($field);
		$this->export_model->update_field($field_id, array('order' => $field_id));
		$data['field'] = array(
			'field_id' => $field_id,
			'title' => $field['title'],
			'value' => $field['value']
		);
		$this->load->view('row_field_view', isset($data) ? $data : NULL);
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