<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_client_model extends CI_Model {
	
	var $user_id = null;
	var $module = 'job';
	var $object = 'timesheet';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('log/log_model');
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function get_finished_shifts() {
		$sql = "SELECT * FROM `job_shifts`
				WHERE `status` >= " . SHIFT_CONFIRMED . "
				AND `supervisor_id` = " . $this->user_id . " 
				AND `finish_time` < " . time() . " 
				AND `shift_id` NOT IN
					(SELECT `shift_id` FROM `job_shift_timesheets`)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_supervised_timesheets()
	{
		$sql = "SELECT t.*, j.name as job_name, j.client_id, v.name as venue_name, r.name as role_name
				FROM `job_shift_timesheets` t
					LEFT JOIN `attribute_venues` v ON v.venue_id = t.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = t.role_id
					LEFT JOIN `jobs` j ON j.job_id = t.job_id
				WHERE t.supervisor_id = " . $this->user_id . "
				AND t.status < " . TIMESHEET_BATCHED . 
				" ORDER BY t.job_date DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$query = $this->db->get('job_shift_timesheets');
		return $query->first_row('array');
	}
	
	function update_timesheet($timesheet_id, $data) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status < ', TIMESHEET_APPROVED);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	function submit_timesheet($timesheet_id) 
	{
		$timesheet = $this->get_timesheet($timesheet_id);
		$status = TIMESHEET_SUBMITTED;
		$action = 'submitted';
		if ($timesheet['supervisor_id'] == $this->user_id)
		{ # Approve timesheet
			$status = TIMESHEET_APPROVED;
			$action = 'approved';
		}
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $timesheet_id,
			'action' => $action
		);
		$this->log_model->insert_log($log_data);
		
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status' => $status));
	}
}