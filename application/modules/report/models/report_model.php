<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
	
	function get_forecast($month)
	{
		$sql = "SELECT * FROM forecast
					WHERE job_date LIKE '$month%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function clear_forecast()
	{
		$this->db->truncate('forecast'); 
	}
	
	function add_forecast($data)
	{
		$this->db->insert('forecast', $data);
		return $this->db->insert_id();
	}
	
	function get_month_shifts($month)
	{
		$sql = "SELECT * FROM job_shifts
					WHERE status > " . SHIFT_DELETED . "
					AND job_date LIKE '$month%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_expenses_cost($month)
	{
		$sql = "SELECT * FROM expenses
						WHERE paid_on LIKE '$month%'";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		$amount = 0;
		foreach($results as $r)
		{
			$cost = $r['staff_cost'];
			if ($r['tax'] == GST_ADD)
			{
				$cost = $cost * 1.1;
			}
			$amount += $cost;
		}
		return $amount;
	}
	
	function get_invoice_amount($month)
	{
		$sql = "SELECT sum(total_amount) as total_amount FROM invoices
					WHERE paid_on LIKE '$month%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		$amount = 0;
		if ($result['total_amount'] > 0)
		{
			$amount = $result['total_amount'];
		}
		return $amount;
	}
	
	function get_staff_cost($month)
	{
		$sql = "SELECT sum(amount) as total_amount FROM payruns
					WHERE created_on LIKE '$month%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		$amount = 0;
		if ($result['total_amount'] > 0)
		{
			$amount = $result['total_amount'];
		}
		return $amount;
	}
	
	function get_top_clients($year, $month='')
	{
		$paid_on = $year;
		if ($month != '')
		{
			$paid_on .= '-' . $month;
		}
		$sql = "SELECT c.company_name, sum(total_amount) as total_amount
					FROM invoices i
					LEFT JOIN user_clients c ON c.user_id = i.client_id
					WHERE i.paid_on LIKE '$paid_on%'
					GROUP BY i.client_id
					ORDER BY total_amount DESC
					LIMIT 10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_top_roles($year, $month='')
	{
		$date = $year;
		if ($month != '')
		{
			$date .= '-' . $month;
		}
		$sql = "SELECT r.name, count(*) as total
					FROM job_shifts js
					LEFT JOIN attribute_roles r ON r.role_id = js.role_id
					WHERE js.status > " . SHIFT_DELETED . "
					AND js.role_id != 0
					AND job_date LIKE '$date%'
					GROUP BY js.role_id
					ORDER BY total DESC
					LIMIT 10";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}