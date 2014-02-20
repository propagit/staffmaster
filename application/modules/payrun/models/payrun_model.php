<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrun_model extends CI_Model {
	
	/**
	*	@name: count_staff
	*	@desc: count the number of staffs ready for pay run
	*	@access: public
	*	@param: (int) $tfn (1: TFN, 2: ABN)
	*	@return: (int) number of staffs
	*/
	function count_staff($tfn=0) {
		$sql = "SELECT u.* FROM `job_shift_timesheets` j
					LEFT JOIN `user_staffs` u ON j.staff_id = u.user_id
					WHERE j.status = " . TIMESHEET_BATCHED . " 
					AND j.status_payrun_staff = " . PAYRUN_READY . " 
					AND u.f_employed = " . $tfn . " GROUP BY j.staff_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	/**
	*	@name: get_total_amount
	*	@desc: get total amount ready for staff pay run
	*	@access: public
	*	@param: (int) $tfn (1: TFN, 2: ABN)
	*	@return: (decimal) total amount to pay
	*/
	function get_total_amount($tfn=0) {
		$sql = "SELECT sum(j.total_amount_staff) as `total` FROM `job_shift_timesheets` j
					LEFT JOIN `user_staffs` u ON j.staff_id = u.user_id
					WHERE j.status = " . TIMESHEET_BATCHED . " 
					AND j.status_payrun_staff = " . PAYRUN_READY . " 
					AND u.f_employed = " . $tfn;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		if ($result && isset($result['total'])) {
			return $result['total'];
		}
		return 0;
	}
	
	/**
	*	@name: get_staffs
	*	@desc: get all staffs have timesheets need to be paid
	*	@access: public
	*	@param: (void)
	*	@return: (array) of staff object
	*/
	function get_staffs() {
		$sql = "SELECT u.* FROM `job_shift_timesheets` j
					LEFT JOIN `users` u ON j.staff_id = u.user_id
					LEFT JOIN `user_staffs` s ON j.staff_id = s.user_id
					WHERE j.status = " . TIMESHEET_BATCHED;
		
		$prf_state = $this->session->userdata('prf_state');
		if ($prf_state) {
			$sql .= " AND u.state = '" . $prf_state . "'";
		}
		$prf_tfn = $this->session->userdata('prf_tfn');
		if ($prf_tfn != "") {
			$sql .= " AND s.f_employed = '" . $prf_tfn . "'";
		}
		$prf_status = $this->session->userdata('prf_status');
		if ($prf_status != "") {
			$sql .= " AND j.status_payrun_staff = '" . $prf_status . "'";
		}
			
		$sql .= " GROUP BY j.staff_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: get_timesheet
	*	@desc: get batched timesheet
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (obj) timesheet object
	*/
	function get_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$query = $this->db->get('job_shift_timesheets');
		return $query->first_row('array');
	}
	
	/**
	*	@name: get_staff_timesheets
	*	@desc: get all timesheets by a staff
	*	@access: public
	*	@param: (int) $user_id
	*	@return: (array) of timesheet objects
	*/
	function get_staff_timesheets($user_id)
	{
		$this->db->where('staff_id', $user_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		
		$prf_status = $this->session->userdata('prf_status');
		if ($prf_status != "") {
			$this->db->where('status_payrun_staff', $prf_status);
		}
		
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	/**
	*	@name: process_staff_payruns
	*	@desc: set all timesheets of a staff to be ready for pay run
	*	@access: public
	*	@param: (int) $staff_id
	*	@return: (boolean)
	*/
	function process_staff_payruns($staff_id) 
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status_payrun_staff' => PAYRUN_READY));
	}
	
	/**
	*	@name: process_payrun
	*	@desc: set a timesheet to be ready for pay run
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (boolean)
	*/
	function process_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_payrun_staff' => PAYRUN_READY));
	}
	
	/**
	*	@name: unprocess_staff_payruns
	*	@desc: set all timesheets of a staff to not be ready for pay run
	*	@access: public
	*	@param: (int) $staff_id
	*	@return: (boolean)
	*/
	function unprocess_staff_payruns($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status_payrun_staff' => PAYRUN_PENDING));
	}
	
	/**
	*	@name: unprocess_payrun
	*	@desc: set a timesheet to not be ready for pay run
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (boolean)
	*/
	function unprocess_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_payrun_staff' => PAYRUN_PENDING));
	}
	
	/**
	*	@name: revert_staff_payruns
	*	@desc: revert all timesheets of a staff to previous status (not batched)
	*	@access: public
	*	@param: (int) $staff_id
	*	@return: (boolean)
	*/
	function revert_staff_payruns($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_APPROVED));
	}
	
	/**
	*	@name: revert_payrun
	*	@desc: revert a timesheet to previous status (not batched)
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (boolean)
	*/
	function revert_payrun($timesheet_id)
	{
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status' => TIMESHEET_APPROVED));
	}
}