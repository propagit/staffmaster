<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrate_model extends CI_Model {
	
	function get_payrate($payrate_id)
	{
		$this->db->where('payrate_id', $payrate_id);
		$query = $this->db->get('attribute_payrates');
		return $query->first_row('array');
	}
	
	function get_payrates()
	{
		$query = $this->db->get('attribute_payrates');
		return $query->result_array();
	}
	
	function insert_payrate($data)
	{
		$this->db->insert('attribute_payrates', $data);
		return $this->db->insert_id();
	}
	
	function identify($id)
	{
		$this->db->where('payrate_id', $id);
		$query = $this->db->get('attribute_payrates');
		return $query->first_row('array');
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
	
	function get_payrate_data($payrate_id, $type, $day, $hour)
	{
		$this->db->where('payrate_id', $payrate_id);
		$this->db->where('type', $type);
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		$query = $this->db->get('attribute_payrate_data');
		$result = $query->first_row('array');
		return $result['value'];
	}
	
	function update_payrate_data($payrate_id, $type, $day, $hour, $value)
	{
		$this->db->where('payrate_id', $payrate_id);
		$this->db->where('type', $type);
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		return $this->db->update('attribute_payrate_data', array('value' => $value));
	}
	
	function insert_payrate_data($payrate_id, $data)
	{
		$this->db->insert('attribute_payrate_data', $data);
		return $this->db->insert_id();
	}
	
	function clean_payrate_data($payrate_id)
	{
		$this->db->where('payrate_id', $payrate_id);
		return $this->db->delete('attribute_payrate_data');
	}
	
}