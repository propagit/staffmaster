<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payrate_model extends CI_Model {
	
	function get_payrate($payrate_id)
	{
		$this->db->where('payrate_id', $payrate_id);
		$query = $this->db->get('attribute_payrates');
		return $query->first_row('array');
	}
	
	function count_payrate_shifts($payrate_id)
	{
		$sql = "SELECT count(*) as total
					FROM job_shifts
					WHERE status > " . SHIFT_DELETED . "
					AND payrate_id = " . $payrate_id;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		return $result['total'];
	}
	
	function count_payrate_timesheets($payrate_id)
	{
		$sql = "SELECT count(*) as total
					FROM job_shift_timesheets
					WHERE payrate_id = " . $payrate_id;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		return $result['total'];
	}
	
	function get_payrates()
	{
		$this->db->where('status > ', PAYRATE_DELETED);
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
	
	function get_payrate_groups($payrate_id)
	{
		$sql = "SELECT * FROM attribute_payrate_data WHERE payrate_id = $payrate_id AND `group` != '' AND `group` != '0' AND `color` != '#ffffff'
					GROUP BY `group`, `type`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_payrate_full_data($payrate_id, $type, $day, $hour)
	{
		$this->db->where('payrate_id', $payrate_id);
		$this->db->where('type', $type);
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		$query = $this->db->get('attribute_payrate_data');
		return $query->first_row('array');
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
	
	function get_minimum_payrate($payrate_id,$payrate_type = 0)
	{
		$payrate = $this->db->select_min('value')
							->where('payrate_id',$payrate_id)
							->where('type',$payrate_type)
							->get('attribute_payrate_data')
							->row();
		return $payrate->value;
	}
	
}