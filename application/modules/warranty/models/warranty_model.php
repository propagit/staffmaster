<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warranty_model extends CI_Model {
	
	function get_warranty($reg_no)
	{
		$sql = "SELECT o.*, p.title as product_name, p.pic_url as pic_url
					FROM orders o
					LEFT JOIN products p ON o.product_part_no = p.part_no
					WHERE o.req_no = '" . $reg_no . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function update_warranty($order_id, $data)
	{
		if (isset($data['product_name']))
		{
			unset($data['product_name']);
		}
		if (isset($data['pic_url']))
		{
			unset($data['pic_url']);
		}
		$this->db->where('order_id', $order_id);
		return $this->db->update('orders', $data);
	}
	
	function get_warranties($distributor_company_name, $keywords = '', $status = '', $date_from = false, $date_to = false, $job_sort_key = '', $job_sort_value = '', $limit = null)
	{
		$sql = "SELECT o.*, p.title as product_name
					FROM orders o
					LEFT JOIN products p ON o.product_part_no = p.part_no
					WHERE o.distributor_company_name = '" . $distributor_company_name . "' AND o.sale_date IS NOT NULL";
		# Keywords
		if ($keywords)
		{
			$sql .= " AND (p.title LIKE '%" . $keywords . "%' OR o.customer_name LIKE '%" . $keywords . "%')";
		}
		
		# Status
		if ($status == 'Activated Warranty')
		{
			$sql .= " AND o.warranty_start_date > 0";
		}
		else if ($status == 'Not Yet Activated Warranty')
		{
			$sql .= " AND o.warranty_start_date = 0";
		}
		else if ($status == 'Expired Warranty')
		{
			$sql .= " AND o.warranty_finish_date > 0 AND o.warranty_finish_date < CURRENT_TIMESTAMP";
		}
		
		# Date from
		if ($date_from)
		{
			$sql .= " AND o.sale_date > " . $date_from;
		}
		
		# Date to
		if ($date_to)
		{
			$sql .= " AND o.sale_date < " . $date_to;
		}
		
		switch($job_sort_key)
		{
			case 'product_name':
					$sql .= " ORDER BY p.title " . $job_sort_value;
				break;
			case 'customer_name':
					$sql .= " ORDER BY o.customer_name " . $job_sort_value;
				break;
			case 'order_type':
					$sql .= " ORDER BY o.type " . $job_sort_value;
				break;
			case 'order_date':					
					$sql .= " ORDER BY o.sale_date " . $job_sort_value;
				break;
			case 'received_date':					
					$sql .= " ORDER BY o.received_date " . $job_sort_value;
				break;
			case 'ship_date':
					$sql .= " ORDER BY o.ship_date " . $job_sort_value;
				break;
			default:
					$sql .= " ORDER BY o.sale_date DESC";
				break;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}