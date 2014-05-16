<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expense_model extends CI_Model {
	
	function add_expense($data) {
		$this->db->insert('expenses', $data);
		return $this->db->insert_id();
	}
	
	function get_expense($expense_id) {
		$this->db->where('expense_id', $expense_id);
		$query = $this->db->get('expenses');
		return $query->first_row('array');
	}
	
	function get_export_expense($expense_id) {
		$sql = "SELECT e.*, 
					j.name as job_name,
					js.job_date,
					s.first_name, s.last_name,
					c.company_name FROM expenses e
				LEFT JOIN jobs j ON j.job_id = e.job_id
				LEFT JOIN job_shift_timesheets js ON js.timesheet_id = e.timesheet_id
				LEFT JOIN users s ON s.user_id = e.staff_id
				LEFT JOIN user_clients c ON c.user_id = e.client_id
					WHERE e.expense_id = " . $expense_id;
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function update_expense($expense_id, $data) {
		$this->db->where('expense_id', $expense_id);
		return $this->db->update('expenses', $data);
	}
	
	function delete_timesheet_expenses($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status !=', EXPENSE_PAID);
		return $this->db->delete('expenses');
	}
	
	function get_detailed_expense($expense_id) {
		$sql = "SELECT e.*, 
					j.name as job_name,
					js.job_date,
					CONCAT(s.first_name, ' ', s.last_name) as `staff_name`,
					c.company_name FROM expenses e
				LEFT JOIN jobs j ON j.job_id = e.job_id
				LEFT JOIN job_shift_timesheets js ON js.timesheet_id = e.timesheet_id
				LEFT JOIN users s ON s.user_id = e.staff_id
				LEFT JOIN user_clients c ON c.user_id = e.client_id
					WHERE e.expense_id = $expense_id";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function search_expenses($params = array()) {
		$sql = "SELECT e.*, 
					j.name as job_name,
					js.job_date,
					CONCAT(s.first_name, ' ', s.last_name) as `staff_name`,
					c.company_name FROM expenses e
				LEFT JOIN jobs j ON j.job_id = e.job_id
				LEFT JOIN job_shift_timesheets js ON js.timesheet_id = e.timesheet_id
				LEFT JOIN users s ON s.user_id = e.staff_id
				LEFT JOIN user_clients c ON c.user_id = e.client_id
					WHERE 1=1";
		if (isset($params['expense_id']) && $params['expense_id'] != '') {
			$sql .= " AND e.expense_id = " . $params['expense_id'];
		}
		if (isset($params['staff_name']) && $params['staff_name'] != '') {
			$sql .= " AND CONCAT(s.first_name, ' ', s.last_name) LIKE '%" . $params['staff_name'] . "%'";
		}
		if (isset($params['staff_id']) && $params['staff_id'] != '') {
			$sql .= " AND s.user_id = " . $params['staff_id'];
		}
		if (isset($params['description']) && $params['description'] != '') {
			$sql .= " AND e.description LIKE '%" . $params['description'] . "%'";
		}
		if (isset($params['client_id']) && $params['client_id'] != '') {
			$sql .= " AND e.client_id = " . $params['client_id'];
		}
		if (isset($params['job_name']) && $params['job_name'] != '') {
			$sql .= " AND j.name LIKE '%" . $params['job_name'] . "%'";
		}
		if (isset($params['date_from']) && $params['date_from'] != '') {
			$date_from = date('Y-m-d', strtotime($params['date_from']));
			$sql .= " AND js.job_date >= '$date_from'";
		}
		if (isset($params['date_to']) && $params['date_to'] != '') {
			$date_to = date('Y-m-d', strtotime($params['date_to']));
			$sql .= " AND js.job_date <= '$date_to'";
		}
		if (isset($params['status']) && $params['status'] != '') {
			$sql .= " AND e.status = " . $params['status'];
		}
		if (isset($params['paid_date_from']) && $params['paid_date_from'] != '') {
			$paid_date_from = date('Y-m-d', strtotime($params['paid_date_from'])) . ' 00:00:00';
			$sql .= " AND e.paid_on >= '$paid_date_from'";
		}
		if (isset($params['paid_date_to']) && $params['paid_date_to'] != '') {
			$paid_date_to = date('Y-m-d', strtotime($params['paid_date_to'])) . ' 23:59:59';
			$sql .= " AND e.paid_on <= '$paid_date_to'";
		}
		if (isset($params['timesheet_id']) && $params['timesheet_id'] != '') {
			$sql .= " AND e.timesheet_id = " . $params['timesheet_id'];
		}
		$sql .= " ORDER BY e.expense_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_timesheet_expenses($timesheet_id, $status = EXPENSE_UNPAID) {
		$this->db->where('timesheet_id', $timesheet_id);
		$this->db->where('status >= ', $status);
		$query = $this->db->get('expenses');
		return $query->result_array();
	}
}