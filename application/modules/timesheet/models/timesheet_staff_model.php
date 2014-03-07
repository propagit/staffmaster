<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_staff_model extends CI_Model {
	
	var $user_id = null;
	function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function get_timesheets() {
		$sql = "SELECT t.*, j.name as job_name, j.client_id, v.name as venue_name, r.name as role_name
				FROM `job_shift_timesheets` t
					LEFT JOIN `attribute_venues` v ON v.venue_id = t.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = t.role_id
					LEFT JOIN `jobs` j ON j.job_id = t.job_id
				WHERE t.staff_id = " . $this->user_id . "
				AND t.status < " . TIMESHEET_BATCHED;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function update_timesheet($timesheet_id, $data) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
}