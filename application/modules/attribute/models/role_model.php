<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends CI_Model {
	
	function insert_role($data)
	{
		$this->db->insert('attribute_roles', $data);
		return $this->db->insert_id();
	}
	
	function get_role($role_id)
	{
		$this->db->where('role_id', $role_id);
		$query = $this->db->get('attribute_roles');
		return $query->first_row('array');
	}
	
	function get_roles($sort_role=false)
	{
		if ($sort_role)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_roles');
		return $query->result_array();
	}
	
	function update_role($role_id, $data)
	{
		$this->db->where('role_id', $role_id);
		return $this->db->update('attribute_roles', $data);
	}
	
	function delete_role($role_id)
	{
		$this->db->where('role_id', $role_id);
		return $this->db->delete('attribute_roles');
	}
}