<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource_model extends CI_Model {
	
	function insert_resource($data)
	{
		$this->db->insert('resources', $data);
		return $this->db->insert_id();
	}
	
	function insert_resource_file($data)
	{
		$this->db->insert('resources_files', $data);
		return $this->db->insert_id();
	}
	
	function get_resources($active=NULL)
	{
		if ($active)
		{
			$this->db->where('active', 1);
		}
		$query = $this->db->get('resources');
		return $query->result_array();
	}
	
	function search_resources($keywords)
	{
		if ($keywords)
		{
			$sql = "SELECT DISTINCT r.* FROM resources r
				LEFT JOIN resources_files rf ON r.resource_id = rf.resource_id
				WHERE rf.orig_name LIKE '%" . $keywords . "%'";
		}
		else
		{
			$sql = "SELECT * FROM resources";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function search_resource_files($resource_id, $keywords)
	{
		$sql = "SELECT * FROM resources_files WHERE resource_id = '" . $resource_id . "' AND orig_name LIKE '%" . $keywords . "%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_resource_files($resource_id)
	{
		$this->db->where('resource_id', $resource_id);
		$query = $this->db->get('resources_files');
		return $query->result_array();
	}
	
	function get_resource_file($file_id)
	{
		$this->db->where('file_id', $file_id);
		$query = $this->db->get('resources_files');
		return $query->first_row('array');
	}
	
	function update_resource_file($file_id, $data)
	{
		$this->db->where('file_id', $file_id);
		return $this->db->update('resources_files', $data);
	}
	
	function delete_resource_file($file_id)
	{
		$this->db->where('file_id', $file_id);
		return $this->db->delete('resources_files');
	}
	
	function update_resource($resource_id, $data)
	{
		$this->db->where('resource_id', $resource_id);
		return $this->db->update('resources', $data);
	}
	
	function get_resource($resource_id)
	{
		$this->db->where('resource_id', $resource_id);
		$query = $this->db->get('resources');
		return $query->first_row('array');
	}
	
	function delete_resource($resource_id)
	{
		$this->db->where('resource_id', $resource_id);
		return $this->db->delete('resources');
	}
}