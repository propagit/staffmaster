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
	
	function check_company_profile()
	{
		$query = $this->db->get('company_profile');
		$result = $query->first_row('array');
		return $result['address'] != ''
			&& $result['abn_acn'] != '';
	}
	
	function check_has_staff()
	{
		$this->db->where('is_staff', 1);
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		return $query->num_rows() > 1;
	}
	
	function check_has_client()
	{
		$this->db->where('is_client', 1);
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		return $query->num_rows() > 0;
	}
	
	function check_has_payrate()
	{
		$query = $this->db->get('attribute_payrates');
		return $query->num_rows() > 0;
	}
	
	function check_has_venue()
	{
		$query = $this->db->get('attribute_venues');
		return $query->num_rows() > 0;
	}
	
}