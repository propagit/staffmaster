<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	function get_total_stocks()
	{
		$this->db->where('type', 'EXCHANGE');
		$this->db->where('customer_name', NULL);
		$query = $this->db->get('orders');
		return $query->num_rows();
	}
	
	function get_total_products()
	{
		$query = $this->db->get('products');
		return $query->num_rows();
	}
	
	function get_total_accounts()
	{
		$this->db->where('parent_id', 0);
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	
	function get_total_users()
	{		
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	
	function get_random_resource()
	{
		$this->db->where('active', 1);
		$this->db->order_by('resource_id', 'random');
		$query = $this->db->get('resources');
		return $query->first_row('array');
	}
	
	
}