<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	
	function get_credits()
	{
		$query = $this->db->get('account');
		$result = $query->first_row('array');
		return (int) $result['credits'];
	}
	
	function add_credits($credits)
	{
		$credits += $this->get_credits();
		return $this->db->update('account', array('credits' => $credits));
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