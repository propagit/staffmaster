<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_model extends CI_Model {
	
	function add_form($data) {
		$this->db->insert('forms', $data);
		return $this->db->insert_id();
	}
	
	function get_forms() {
		$this->db->where('status > ', DELETED);
		$query = $this->db->get('forms');
		return $query->result_array();
	}
	
	function get_form($form_id) {
		$this->db->where('status > ', DELETED);
		$this->db->where('form_id', $form_id);
		$query = $this->db->get('forms');
		return $query->first_row('array');
	}
	
	function update_form($form_id, $data) {
		$this->db->where('form_id', $form_id);
		return $this->db->update('forms', $data);
	}
	
	function delete_form($form_id) {
		$this->db->where('form_id', $form_id);
		return $this->db->update('forms', array('status' => DELETED));
	}
	
	function get_custom_fields($show_actived=false) {
		$sql = "SELECT c.*, f.form_field_id, f.required
				FROM custom_fields c
					LEFT JOIN form_fields f ON f.name = c.field_id";
		if ($show_actived) {
			$sql .= " WHERE f.form_field_id > 0";
		}
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
	
	function get_applicants() {
		$sql = "SELECT a.*, f.*, count(a.applicant_id) as total_fields 
				FROM form_applicants a, form_applicant_data d, forms f
				WHERE d.applicant_id = a.applicant_id
				AND f.form_id = a.form_id
				AND (d.value != '' OR d.value != NULL)
				AND a.status > " . APPLICANT_REJECTED . "
				GROUP BY a.applicant_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_applicant($applicant_id) {
		$sql = "SELECT f.label, f.name, d.value, c.type
				FROM form_applicant_data d
					LEFT JOIN form_fields f ON f.form_field_id = d.form_field_id
					LEFT JOIN custom_fields c ON c.field_id = f.name
				WHERE d.applicant_id = $applicant_id
				AND (d.value != '' OR d.value != NULL)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function reject_applicant($applicant_id) {
		$this->db->where('applicant_id', $applicant_id);
		return $this->db->update('form_applicants', array(
			'status' => APPLICANT_REJECTED,
			'rejected_on' => date('Y-m-d H:i:s')
		));
	}
	
	function accept_applicant($applicant_id) {
		$this->db->where('applicant_id', $applicant_id);
		return $this->db->update('form_applicants', array(
			'status' => APPLICANT_ACCEPTED,
			'accepted_on' => date('Y-m-d H:i:s')
		));
	}
}