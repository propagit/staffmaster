<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model {
	
	function get_template($template_id) {
		$this->db->where('template_id', $template_id);
		$query = $this->db->get('sms_templates');
		return $query->first_row('array');
	}
	
	function get_templates() {
		$this->db->order_by('template_id', 'asc');
		$query = $this->db->get('sms_templates');
		return $query->result_array();
	}
	
	function update_template($template_id, $data) {
		$this->db->where('template_id', $template_id);
		return $this->db->update('sms_templates', $data);
	}
	
}