<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrun_model extends CI_Model {
	
	function count_staff($tfn=0) {
		$sql = "SELECT u.* FROM `job_shift_timesheets` j
					LEFT JOIN `user_staffs` u ON j.staff_id = u.user_id
					WHERE j.status = " . TIMESHEET_PROCESSING . " AND u.f_employed = " . $tfn . " GROUP BY j.staff_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function get_total_amount($tfn=0) {
		$sql = "SELECT sum(j.total_amount_staff) as `total` FROM `job_shift_timesheets` j
					LEFT JOIN `user_staffs` u ON j.staff_id = u.user_id
					WHERE j.status = " . TIMESHEET_PROCESSING . " AND u.f_employed = " . $tfn;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result && isset($result['total'])) {
			return $result['total'];
		}
		return 0;
	}
	
	function get_staffs() {
		$sql = "SELECT u.* FROM `job_shift_timesheets` j
					LEFT JOIN `users` u ON j.staff_id = u.user_id
					LEFT JOIN `user_staffs` s ON j.staff_id = s.user_id";
		$prf_status = $this->session->userdata('prf_status');
		if ($prf_status != "") {
			$sql .= " WHERE j.status = '" . $prf_status . "'";
		}
		else {
			$sql .= " WHERE j.status >= " . TIMESHEET_BATCHED;
		}
		$prf_state = $this->session->userdata('prf_state');
		if ($prf_state) {
			$sql .= " AND u.state = '" . $prf_state . "'";
		}
		$prf_tfn = $this->session->userdata('prf_tfn');
		if ($prf_tfn != "") {
			$sql .= " AND s.f_employed = '" . $prf_tfn . "'";
		}
		
			
		$sql .= " GROUP BY j.staff_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_staff_timesheets($user_id)
	{
		$this->db->where('staff_id', $user_id);
		$prf_status = $this->session->userdata('prf_status');
		if ($prf_status != "") {
			$this->db->where('status', $prf_status);
		}
		else
		{
			$this->db->where('status >=', TIMESHEET_BATCHED);
		}
		
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	function process_staff_payruns($staff_id) 
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_PROCESSING));
	}
	function process_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_PROCESSING));
	}
	function unprocess_staff_payruns($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_BATCHED));
	}
	function unprocess_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_BATCHED));
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