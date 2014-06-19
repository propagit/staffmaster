<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_model extends CI_Model {
	
	function add_form($data) {
		$this->db->insert('forms', $data);
		return $this->db->insert_id();
	}
	
	function get_forms() {
		$query = $this->db->get('forms');
		return $query->result_array();
	}
}