<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {
	
	function get_invoiced_clients() {
		$sql = "SELECT uc.*, sum(j.total_amount_client) as `total_amount`, count(*) as `total_timesheets` FROM `job_shift_timesheets` j
					LEFT JOIN `user_clients` uc ON j.client_id = uc.user_id
					WHERE j.status = " . TIMESHEET_BATCHED . "
					AND j.status_invoice_client = " . INVOICE_READY . "
					GROUP BY j.client_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_clients() {
		$sql_select_job_id = "SELECT job_id FROM `job_shift_timesheets` GROUP BY job_id";
		$sql = "SELECT uc.*, count(*) as `total_jobs` FROM user_clients uc
					LEFT JOIN jobs j ON j.client_id = uc.user_id
					WHERE j.job_id IN ($sql_select_job_id) GROUP BY uc.user_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_jobs($user_id) {
		$sql_select_job_id = "SELECT job_id FROM `job_shift_timesheets` GROUP BY job_id";
		$sql = "SELECT * FROM jobs WHERE client_id = " . $user_id . " AND job_id IN ($sql_select_job_id)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_job($job_id) {
		$this->db->where('job_id', $job_id);
		$query = $this->db->get('jobs');
		return $query->first_row('array');
	}
	
	function get_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$query = $this->db->get('job_shift_timesheets');
		return $query->first_row('array');
	}
	
	function get_timesheets($job_id) {
		$this->db->where('job_id', $job_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	function add_job_to_invoice($job_id) {
		$this->db->where('job_id', $job_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_READY));
	}	
	function add_timesheet_to_invoice($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_READY));		
	}	
	function remove_job_from_invoice($job_id) {
		$this->db->where('job_id', $job_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_PENDING));
	}
	function remove_timesheet_from_invoice($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_PENDING));
	}
}