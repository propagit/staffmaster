<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {
	
	function check_client_invoice($user_id) {
		$this->db->where('client_id', $user_id);
		$this->db->where('status', 0);
		$query = $this->db->get('invoices');
		if ($query->num_rows() == 0) {
			return 0;
		} else {
			$result = $query->first_row('array');
			return $result['invoice_id'];
		}
	}
	
	function add_client_invoice($data) {
		$this->db->insert('invoices', $data);
		return $this->db->insert_id();
	}
	
	function add_invoice_item($data) {
		$this->db->insert('invoice_items', $data);
		return $this->db->insert_id();
	}
	
	function get_job_timesheets($job_id, $invoice_status) {
		$this->db->where('job_id', $job_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$this->db->where('status_invoice_client', $invoice_status);
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	function delete_invoice_item($item_id) {
		$this->db->where('item_id', $item_id);
		return $this->db->delete('invoice_items');
	}
	
	function delete_invoice_items($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->delete('invoice_items');
	}
	
	function delete_invoice($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->delete('invoices');
	}
	
	function get_invoice_items($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		$this->db->order_by('job_id', 'asc');
		$query = $this->db->get('invoice_items');
		return $query->result_array();
	}
	
	function update_invoice($invoice_id, $data) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('invoices', $data);
	}
	
	function get_invoice($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		$query = $this->db->get('invoices');
		return $query->first_row('array');
	}
	
	function get_client_invoice($user_id) {
		$sql = "SELECT j.*, sum(js.total_amount_client) as `total_amount` FROM `job_shift_timesheets` js
						LEFT JOIN `jobs` j ON js.job_id = j.job_id
						WHERE js.status = " . TIMESHEET_BATCHED . "
						AND js.status_invoice_client = " . INVOICE_READY . "
						AND js.client_id = " . $user_id . "
						GROUP BY js.job_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
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
		$sql_select_job_id = "SELECT job_id 
								FROM `job_shift_timesheets` 
								WHERE status = " . TIMESHEET_BATCHED . "
								AND status_invoice_client <= " . INVOICE_READY . "
								GROUP BY job_id";
		$sql = "SELECT uc.*, count(*) as `total_jobs` FROM user_clients uc
					LEFT JOIN jobs j ON j.client_id = uc.user_id
					WHERE j.job_id IN ($sql_select_job_id) GROUP BY uc.user_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_jobs($user_id) {
		$sql_select_job_id = "SELECT job_id 
								FROM `job_shift_timesheets` 
								WHERE status = " . TIMESHEET_BATCHED . "
								AND status_invoice_client <= " . INVOICE_READY . "
								GROUP BY job_id";
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
		$this->db->where('status_invoice_client <=', INVOICE_READY);
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
	
	function generate_invoice_timesheets($client_id, $invoice_id) {
		$data = array(
			'invoice_id' => $invoice_id,
			'status_invoice_client' => INVOICE_GENERATED
		);
		$this->db->where('client_id', $client_id);
		$this->db->where('status_invoice_client', INVOICE_READY);
		$this->db->where('invoice_id', 0);		
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	function mark_paid_timesheets($invoice_id) {
		$data = array(
			'status_invoice_client' => INVOICE_PAID,
			'client_paid_on' => date('Y-m-d H:i:s')
		);
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	function mark_unpaid_timesheets($invoice_id) {
		$data = array(
			'status_invoice_client' => INVOICE_GENERATED
		);
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	function search_invoices($params) {
		if (isset($params['client_id']) && $params['client_id'] != 0 ) {
			$this->db->where('client_id', $params['client_id']);
		}
		if (isset($params['issued_by']) && $params['issued_by'] != 0) {
			$this->db->where('issued_by', $params['issued_by']);
		}
		if (isset($params['status']) && $params['status'] != 0) {
			$this->db->where('status', $params['status']);
		} 
		$this->db->where('status > ', 0);
		$query = $this->db->get('invoices');
		return $query->result_array();
	}
}