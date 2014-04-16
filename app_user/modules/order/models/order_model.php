<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
	
	function prepare_order_data($data)
	{
		$data['fault'] = htmlentities($data['fault']);
		return $data;	
	}
	
	function insert_order($data)
	{
		$data = $this->prepare_order_data($data);
		$this->db->insert('orders', $data);
		return $this->db->insert_id();
	}
	
	function update_order($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('orders', $data);
	}
	
	function get_total_orders($distributor_name='', $order_type='')
	{
		if ($distributor_name != '')
		{
			$this->db->where('distributor_company_name', $distributor_name);
		}
		if ($order_type == 'REP/RTN')
		{
			$this->db->where('type', 'REP/RTN');
		}
		else if ($order_type == 'EXCHANGE')
		{
			$this->db->where('type', 'EXCHANGE');
			$this->db->where('sys_rma', NULL);
		}
		else
		{
			$this->db->where('type', 'EXCHANGE');
			$this->db->where('sys_rma !=', '');
		}
		$query = $this->db->get('orders');
		return $query->num_rows();
	}
	
	function get_order($order_id)
	{
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('orders');
		return $query->first_row('array');
	}
	
	function get_order_available($distributor_company_name, $part_no, $req_no)
	{
		$this->db->where('distributor_company_name', $distributor_company_name);
		$this->db->where('product_part_no', $part_no);
		$this->db->where('req_no', $req_no);
		$this->db->where('customer_name', NULL);
		$this->db->where('sale_date', NULL);
		$query = $this->db->get('orders');
		return $query->first_row('array');
	}
	
	function search_orders($keywords)
	{
		$sql = "SELECT o.*, p.title as product_name FROM
				orders o
				LEFT JOIN products p ON o.product_part_no = p.part_no
				WHERE p.title LIKE '%" . $keywords . "%' OR o.distributor_company_name LIKE '%" . $keywords . "%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_orders($per_page = NULL, $offset = NULL, $distributor_name = '', $order_type='')
	{
		$offset = ($offset) ? $offset : 0;
		$sql = "SELECT o.*, p.title as product_name, p.pic_url FROM
			orders o
			LEFT JOIN products p ON o.product_part_no = p.part_no";
		if ($distributor_name != '')
		{
			$sql .= " WHERE o.distributor_company_name = '" . $distributor_name . "'";
		}
		if ($order_type != '')
		{
			if ($distributor_name != '')
			{
				$sql .= " AND";
			}
			else
			{
				$sql .= " WHERE";
			}
			if ($order_type == "REP/RTN")
			{
				$sql .= " o.type='REP/RTN'";
			}
			else if ($order_type == "EXCHANGE")
			{
				$sql .= " o.type='EXCHANGE' AND o.sys_rma IS NULL";				
			}
			else
			{
				$sql .= " o.type='EXCHANGE' AND o.sys_rma IS NOT NULL";	
			}
		}
		if ($per_page != NULL)
		{
			$sql .= " ORDER BY o.sale_date DESC LIMIT " . $offset . ", " . $per_page;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
	
	function get_product($part_no)
	{
		$this->db->where('part_no', $part_no);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	
	function generate_sys_rma()
	{
		$this->db->order_by('sys_rma', 'desc');
		$query = $this->db->get('orders');
		$order = $query->first_row('array');
		$sys_rma = $order['sys_rma'];
		$sys_rma = str_replace('PQ','',$sys_rma);
		$sys_rma = intval($sys_rma);
		$sys_rma++;
		return sprintf('PQ%06d', $sys_rma);
	}
}