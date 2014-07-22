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
	
	/**
	*	@name: add_client_invoice
	*	@desc: create the client invoice
	*	@access: public
	*	@param: (array) $data
	*	@return: (int) invoice_id
	*/
	function add_client_invoice($data) {
		$this->db->insert('invoices', $data);
		return $this->db->insert_id();
	}
	
	/**
	*	@name: add_invoice_item
	*	@desc: add item to the invoice
	*	@access: public
	*	@param: (array) $data
	*	@return: (boolean)
	*/
	function add_invoice_item($data) {
		if ($data['job_id'] == NULL) {
			$data['job_id'] = 0;
		}
		if ($data['title'] == NULL) {
			$data['title'] = '';
		}
		$this->db->insert('invoice_items', $data);
		return $this->db->insert_id();
	}
	
	function update_invoice_item($item_id, $data) {
		$this->db->where('item_id', $item_id);
		return $this->db->update('invoice_items', $data);
	}
	
	/**
	*	@name: get_job_timesheets
	*	@desc: get invoiced time sheet of invoiced job
	*	@access: public
	*	@param: (int) $job_id
	*			(int) $invoice_status
	*	@return: (array) of time sheet objects
	*/
	function get_job_timesheets($job_id, $invoice_status) {
		$this->db->where('job_id', $job_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$this->db->where('status_invoice_client >=', $invoice_status);
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	/**
	*	@name: delete_invoice_item
	*	@desc: delete an item from the invoice
	*	@access: public
	*	@param: (int) $item_id
	*	@return: (boolean)
	*/
	function delete_invoice_item($item_id) {
		$this->db->where('item_id', $item_id);
		return $this->db->delete('invoice_items');
	}
	
	/**
	*	@name: delete_invoice_items
	*	@desc: delete all items of an invoice
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (boolean)
	*/
	function delete_invoice_items($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->delete('invoice_items');
	}
	
	/**
	*	@name: delete_invoice
	*	@desc: delete the invoice itselft
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (boolean)
	*/
	function delete_invoice($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('invoices', array('status' => INVOICE_DELETED));
		#return $this->db->delete('invoices');
	}
	
	/**
	*	@name: get_invoice_items
	*	@desc: get all items of an invoice
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (array) of item objects
	*/
	function get_invoice_items($invoice_id) {
		$this->db->where('invoice_id', $invoice_id);
		$this->db->order_by('job_id', 'asc');
		$query = $this->db->get('invoice_items');
		return $query->result_array();
	}
	
	/**
	*	@name: update_invoice
	*	@desc: update invoice object
	*	@access: public
	*	@param: (int) $invoice_id
	*			(array) $data
	*	@return: (boolean)
	*/
	function update_invoice($invoice_id, $data) {
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('invoices', $data);
	}
	
	/**
	*	@name: get_invoice
	*	@desc: get invoice object by id
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (object) invoice
	*/
	function get_invoice($invoice_id) {
		$sql = "SELECT i.*, c.external_client_id
				FROM invoices i, user_clients c 
				WHERE i.invoice_id = $invoice_id
				AND i.client_id = c.user_id";
		#$this->db->where('invoice_id', $invoice_id);
		#$query = $this->db->get('invoices');
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	/**
	*	@name: get_client_invoice
	*	@desc: get ready timesheet to be invoiced of a client
	*	@access: public
	*	@param: (int) $user_id
	*	@return: array of time sheet objects
	*/
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
	
	/**
	*	@name: get_invoiced_clients
	*	@desc: get clients that has temporary invoices
	*	@access: public
	*	@param:
	*	@return: array of client objects
	*/
	function get_invoiced_clients() {
		$sql = "SELECT uc.*, sum(j.expenses_client_cost) as `expenses`, sum(j.total_amount_client) as `total_amount`, count(*) as `total_timesheets` FROM `job_shift_timesheets` j
					LEFT JOIN `user_clients` uc ON j.client_id = uc.user_id
					WHERE j.status = " . TIMESHEET_BATCHED . "
					AND j.status_invoice_client = " . INVOICE_READY . "
					GROUP BY j.client_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: get_clients
	*	@desc: get list of clients that has timesheets can be billed
	*	@access: public
	*	@param:
	*	@return: (array) of client objects
	*/
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
	
	/**
	*	@name: get_client_jobs
	*	@desc: get list of jobs that has timesheets can be billed
	*	@access: public
	*	@param:
	*	@return: (array) of job objects
	*/
	function get_client_jobs($user_id) {
		$sql_select_job_id = "SELECT job_id 
								FROM `job_shift_timesheets` 
								WHERE status = " . TIMESHEET_BATCHED . "
								AND status_invoice_client <= " . INVOICE_READY . "
								GROUP BY job_id";
		$sql = "SELECT * FROM jobs WHERE client_id = " . $user_id . " AND job_id IN ($sql_select_job_id)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: get_job
	*	@desc: get a job object by id
	*	@access: public
	*	@param: (int) $job_id
	*	@return: (object) of job
	*/
	function get_job($job_id) {
		$this->db->where('job_id', $job_id);
		$query = $this->db->get('jobs');
		return $query->first_row('array');
	}
	
	/**
	*	@name: get_timesheet
	*	@desc: get a time sheet by id
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (object) of time sheet
	*/
	function get_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$query = $this->db->get('job_shift_timesheets');
		return $query->first_row('array');
	}
	
	/**
	*	@name: get_timesheets
	*	@desc: get list of ready time sheets oj a job
	*	@access: public
	*	@param: (int) $job_id
	*	@return: (array) of time sheet objects
	*/
	function get_timesheets($job_id) {
		$this->db->where('job_id', $job_id);
		$this->db->where('status', TIMESHEET_BATCHED);
		$this->db->where('status_invoice_client <=', INVOICE_READY);
		$query = $this->db->get('job_shift_timesheets');
		return $query->result_array();
	}
	
	function get_export_timesheets($invoice_id, $job_id) {
		$sql = "SELECT js.*,
					CONCAT(s.first_name, ' ', s.last_name) as `staff_name`,
					c.company_name
					FROM job_shift_timesheets js
						LEFT JOIN users s ON s.user_id = js.staff_id
						LEFT JOIN user_clients c ON c.user_id = js.client_id
					WHERE js.job_id = " . $job_id . "
					AND js.invoice_id = " . $invoice_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_export_expenses($expense_id) {
		$sql = "SELECT e.*,
					CONCAT(s.first_name, ' ', s.last_name) as `staff_name`,
					c.company_name,
					js.break_time, js.job_date, js.start_time, js.finish_time, js.total_minutes
					FROM expenses e
						LEFT JOIN users s ON s.user_id = e.staff_id
						LEFT JOIN user_clients c ON c.user_id = e.client_id
						LEFT JOIN job_shift_timesheets ON js.timesheet_id = e.timesheet_id
					WHERE e.expense_id = " . $expense_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: add_job_to_invoice
	*	@desc: add all time sheets of the job to the invoice
	*	@access: public
	*	@param: (int) $job_id
	*	@return: (boolean)
	*/
	function add_job_to_invoice($job_id) {
		$this->db->where('job_id', $job_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_READY));
	}
	
	/**
	*	@name: remove_job_from_invoice
	*	@desc: remove all time sheets of the job from the invoice
	*	@access: public
	*	@param: (int) $job_id
	*	@return: (boolean)
	*/
	function remove_job_from_invoice($job_id) {
		$this->db->where('job_id', $job_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_PENDING));
	}
	
	/**
	*	@name: add_timesheet_to_invoice
	*	@desc: update the timesheet invoice status to ready
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (boolean)
	*/
	function add_timesheet_to_invoice($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_READY));		
	}
	
	/**
	*	@name: remove_timesheet_from_invoice
	*	@desc: update the timesheet invoice status to pending
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (boolean)
	*/
	function remove_timesheet_from_invoice($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', array('status_invoice_client' => INVOICE_PENDING));
	}
	
	/**
	*	@name: generate_invoice_timesheets
	*	@desc: linked all timesheets to the invoice and update time sheets status to invoice generated
	*	@access: public
	*	@param: (int) $client_id
	*			(int) $invoice_id
	*	@return: (boolean)
	*/
	function generate_invoice_timesheets($client_id, $invoice_id) {
		$data = array(
			'invoice_id' => $invoice_id,
			'status_invoice_client' => INVOICE_GENERATED
		);
		$this->db->where('client_id', $client_id);
		$this->db->where('status_invoice_client', INVOICE_READY);
		#$this->db->where('invoice_id', 0);		
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	function edit_invoice_timesheets($client_id, $invoice_id) {
		$data = array(
			'invoice_id' => $invoice_id,
			'status_invoice_client' => INVOICE_READY
		);
		$this->db->where('client_id', $client_id);
		$this->db->where('status_invoice_client', INVOICE_GENERATED);
		#$this->db->where('invoice_id', 0);		
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	/**
	*	@name: mark_paid_timesheets
	*	@desc: update timesheets of an invoice to paid status
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (boolean)
	*/
	function mark_paid_timesheets($invoice_id) {
		$data = array(
			'status_invoice_client' => INVOICE_PAID,
			'client_paid_on' => date('Y-m-d H:i:s')
		);
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	/**
	*	@name: mark_unpaid_timesheets
	*	@desc: update timesheets of an invoice to unpaid status
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (boolean)
	*/
	function mark_unpaid_timesheets($invoice_id) {
		$data = array(
			'status_invoice_client' => INVOICE_GENERATED
		);
		$this->db->where('invoice_id', $invoice_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	/**
	*	@name: search_invoices
	*	@desc: search invoices by parameters
	*	@access: public
	*	@param: (array)
	*	@return: (array) of invoice objects
	*/
	function search_invoices($params,$total = false) {
		$records_per_page = INVOICE_PER_PAGE;
		if (isset($params['client_id']) && $params['client_id'] != 0 ) {
			$this->db->where('client_id', $params['client_id']);
		}
		if (isset($params['issued_by']) && $params['issued_by'] != 0) {
			$this->db->where('issued_by', $params['issued_by']);
		}
		if (isset($params['status']) && $params['status'] != 0) {
			$this->db->where('status', $params['status']);
		}
		if (isset($params['keywords']) && $params['keywords'] != '') {
			$this->db->like('jobs', $params['keywords']);
		}
		if (isset($params['date_from']) && $params['date_from'] != '') {
			$date_from = date('Y-m-d', strtotime($params['date_from']));
			$this->db->where('issued_date >=', $date_from);
		}
		if (isset($params['date_to']) && $params['date_to'] != '') {
			$date_to = date('Y-m-d', strtotime($params['date_to']));
			$this->db->where('issued_date <=', $date_to);
		}
		$this->db->where('status > ', 0);
		//sort
		if(isset($params['sort_by']) && $params['sort_by'] != ''){
			$this->db->order_by($params['sort_by'],$params['sort_order']);	
		}
		if(!$total){
			if(isset($params['current_page']) && $params['current_page'] != ''){
				$offset = ($params['current_page']-1)*$records_per_page;
				$this->db->limit($records_per_page,$offset);
			}
		}
		
		$query = $this->db->get('invoices');
		return $query->result_array();
	}
}