<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {
	
	function get_groups($params = '')
	{
		$sql = "select * from attribute_groups";
		if($params){
			$sort_param = json_decode($params);	
			$sql .= " order by $sort_param->sort_by $sort_param->sort_order";
		}else{
			$sql .= " order by name asc";
		}

		$query = $this->db->query($sql);
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