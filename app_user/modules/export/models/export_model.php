<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model {
	
	# Get levels of a export object 
	# Different objects have different levels, some have 2,3 levels, some just have one level
	function get_levels($object) {
		$sql = "SELECT DISTINCT level 
					FROM export_templates 
				WHERE object = '$object' 
					AND level != '' 
				ORDER BY status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	# Get templates of object and a particular level
	function get_templates($object, $level = '') {
		$this->db->where('object', $object);
		if ($level) {
			$this->db->where('level', $level);
		}		
		$this->db->order_by('status', 'DESC');
		$query = $this->db->get('export_templates');
		return $query->result_array();
	}
	
	function get_template($export_id) {
		$this->db->where('export_id', $export_id);
		$query = $this->db->get('export_templates');
		return $query->first_row('array');
	}
	
	function get_template_fields($object, $level) {
		$this->db->where('object', $object);
		$this->db->where('level', $level);
		$this->db->order_by('label', 'ASC');
		$query = $this->db->get('export_template_fields');
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