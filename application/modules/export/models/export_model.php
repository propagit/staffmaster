<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {
		
	function get_templates($object, $format) {
		$this->db->where('object', $object);
		$this->db->where('format', $format);
		$this->db->where('status', ACTIVE);
		$query = $this->db->get('export_templates');
		return $query->result_array();
	}	
	
	function get_template_fields($object, $format) {
		$this->db->where('object', $object);
		$this->db->where('format', $format);
		$this->db->order_by('label', 'asc');
		$query = $this->db->get('export_fields');
		return $query->result_array();
	}
	
	function get_fields($export_id) {
		$this->db->where('export_id', $export_id);
		$this->db->order_by('order', 'asc');
		$query = $this->db->get('export_template_data');
		return $query->result_array();
	}
	
	function add_field($data) {
		$this->db->insert('export_template_data', $data);
		return $this->db->insert_id();
	}
	
	function update_field($field_id, $data) {
		$this->db->where('field_id', $field_id);
		return $this->db->update('export_template_data', $data);
	}
	
	function remove_field($field_id) {
		$this->db->where('field_id', $field_id);
		return $this->db->delete('export_template_data');
	}
	
}