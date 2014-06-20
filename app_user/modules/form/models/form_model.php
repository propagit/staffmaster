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
	
	function get_form($form_id) {
		$this->db->where('form_id', $form_id);
		$query = $this->db->get('forms');
		return $query->first_row('array');
	}
	
	function update_form($form_id, $data) {
		$this->db->where('form_id', $form_id);
		return $this->db->update('forms', $data);
	}
	
	function get_custom_fields() {
		$sql = "SELECT c.*, f.form_field_id, f.required
				FROM custom_fields c
					LEFT JOIN form_fields f ON f.name = c.field_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function active_field($form_id, $label, $name) {
		$field = $this->get_field($form_id, $name);
		if ($field) { # Delete
			$this->delete_field($form_id, $name);
			return 0;
		} else { # Insert
			$this->db->insert('form_fields', array(
				'form_id' => $form_id,
				'label' => $label,
				'name' => $name
			));
			return $this->db->insert_id();
		}
	}
	
	function require_field($form_id, $name) {
		$field = $this->get_field($form_id, $name);
		if ($field) {
			if ($field['required']) { # If required, update to not required
				$this->update_field($field['form_field_id'], array('required' => 0));
				return 0;
			} else {
				$this->update_field($field['form_field_id'], array('required' => 1));
				return 1;
			}
		} else {
			return 0;
		}
	}
	
	function get_fields($form_id) {
		$this->db->where('form_id', $form_id);
		$query = $this->db->get('form_fields');
		return $query->result_array();
	}
	
	function get_field($form_id, $name) {
		$this->db->where('form_id', $form_id);
		$this->db->where('name', $name);
		$query = $this->db->get('form_fields');
		return $query->first_row('array');
	}
	
	function delete_field($form_id, $name) {
		$this->db->where('form_id', $form_id);
		$this->db->where('name', $name);
		$this->db->delete('form_fields');
	}
	
	function update_field($form_field_id, $data) {
		$this->db->where('form_field_id', $form_field_id);
		$this->db->update('form_fields', $data);
	}
	
	function add_applicant($data) {
		$this->db->insert('form_applicants', $data);
		return $this->db->insert_id();
	}
	
	function add_applicant_data($data) {
		$this->db->insert('form_applicant_data', $data);
		return $this->db->insert_id();
	}

}