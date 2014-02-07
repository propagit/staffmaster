<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {
	
	function get_groups($sort_group=false)
	{
		if ($sort_group)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_groups');
		return $query->result_array();
	}
	
	function insert_group($data)
	{
		$this->db->insert('attribute_groups', $data);
		return $this->db->insert_id();
	}
	
	function update_group($group_id, $data)
	{
		$this->db->where('group_id', $group_id);
		return $this->db->update('attribute_groups', $data);
	}
	
	function delete_group($group_id)
	{
		$this->db->where('group_id', $group_id);
		return $this->db->delete('attribute_groups');
	}
}