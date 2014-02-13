<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_model extends CI_Model {
	
	function get_finished_shifts() {
		$this->db->where('status', SHIFT_CONFIRMED);
		$query = $this->db->get('job_shifts');
		return $query->result_array();
	}
	
	function insert_timesheet($data) {
		$this->db->insert('job_shift_timesheets', $data);
		return $this->db->insert_id();
	}
	
	function get_timesheets() {
		$sql = "SELECT t.*, j.name as job_name, j.client_id, v.name as venue_name, r.name as role_name
				FROM `job_shift_timesheets` t
					LEFT JOIN `attribute_venues` v ON v.venue_id = t.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = t.role_id
					LEFT JOIN `jobs` j ON j.job_id = t.job_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function truncate() {
		$this->db->truncate('job_shift_timesheets'); 
	}
	
}