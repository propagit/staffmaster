<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {
	
	function get_departments($sort_department=false)
	{
		if ($sort_department)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_departments');
		return $query->result_array();
	}
	
	function insert_department($data)
	{
		$this->db->insert('attribute_departments', $data);
		return $this->db->insert_id();
	}
	
	function update_department($department_id, $data)
	{
		$this->db->where('department_id', $department_id);
		return $this->db->update('attribute_departments', $data);
	}
	
	function delete_department($department_id)
	{
		$this->db->where('department_id', $department_id);
		return $this->db->delete('attribute_departments');
	}
}