<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_field_model extends CI_Model {
	
	function add_field($data) {
		$this->db->insert('custom_fields',$data);
		$field_id = $this->db->insert_id();
		$this->update_field($field_id, array('field_order' => $field_id));
	}
	
	function update_field($field_id, $data) {
		$this->db->where('field_id', $field_id);
		return $this->db->update('custom_fields', $data);
	}
	
	function get_fields() {
		$this->db->order_by('field_order', 'asc');
		$query = $this->db->get('custom_fields');
		return $query->result_array();
	}
	
	function get_field($field_id) {
		$this->db->where('field_id', $field_id);
		$query = $this->db->get('custom_fields');
		return $query->first_row('array');
	}
	
	function delete_field($field_id) {
		$this->db->where('field_id', $field_id);
		return $this->db->delete('custom_fields');
	}
}