<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	
	function get_credits($type)
	{
		$query = $this->db->get('account');
		$result = $query->first_row('array');
		return (int) $result[$type . '_credits'];
	}
	
	function add_credits($type, $credits)
	{
		$credits += $this->get_credits($type);
		return $this->db->update('account', array($type . '_credits' => $credits));
	}
	
	function deduct_credits($type, $credits)
	{
		$credits = $this->get_credits($type) - $credits;
		return $this->db->update('account', array($type . '_credits' => $credits));
	}
	
	function create_order($data)
	{
		$this->db->insert('orders', $data);
		return $this->db->insert_id();
	}
	
	function update_order($order_id, $data)
	{
		$this->db->where('order_id', $order_id);
		return $this->db->update('orders', $data);
	}
}