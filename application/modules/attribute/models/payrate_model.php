<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrate_model extends CI_Model {
	
	function get_payrates($sort_payrate=false)
	{
		if ($sort_payrate)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_payrates');
		return $query->result_array();
	}
	
	function insert_payrate($data)
	{
		$this->db->insert('attribute_payrates', $data);
		return $this->db->insert_id();
	}
	
	function update_payrate($payrate_id, $data)
	{
		$this->db->where('payrate_id', $payrate_id);
		return $this->db->update('attribute_payrates', $data);
	}
	
	function delete_payrate($payrate_id)
	{
		$this->db->where('payrate_id', $payrate_id);
		return $this->db->delete('attribute_payrates');
	}
	
}