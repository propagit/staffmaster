<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
	
	function get_month_timesheets($month)
	{
		$sql = "SELECT * FROM job_shift_timesheets
					WHERE job_date LIKE '$month%'";
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
}