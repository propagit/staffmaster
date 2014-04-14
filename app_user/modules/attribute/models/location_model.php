<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model {
	
	
	function get_location($location_id)
	{
		$this->db->where('location_id', $location_id);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function get_locations($parent_id=0)
	{
		$this->db->where('parent_id', $parent_id);		
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
	}
	
	function get_location_by_name($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function get_child_location_by_name($parent_id, $name)
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->where('name', $name);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function insert_location($data)
	{
		$this->db->insert('attribute_locations', $data);
		return $this->db->insert_id();
	}
	
	function update_location($location_id, $data)
	{
		$this->db->where('location_id', $location_id);
		return $this->db->update('attribute_locations', $data);
	}
	
	function delete_location($location_id)
	{
		$this->db->where('location_id', $location_id);
		return $this->db->delete('attribute_locations');
	}
}