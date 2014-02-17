<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrun_model extends CI_Model {
	
	function get_staffs() {
		$sql = "SELECT u.* FROM `job_shift_timesheets` j
					LEFT JOIN `users` u ON j.staff_id = u.user_id
					WHERE j.status = " . TIMESHEET_BATCHED . " GROUP BY j.staff_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_staff_timesheets($user_id)
	{
		$this->db->where('staff_id', $user_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	function revert_staff_payruns($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_APPROVED));
	}
	
	function revert_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_APPROVED));
	}
}