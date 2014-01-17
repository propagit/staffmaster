<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model {
	
	
	function get_location($location_id)
	{
		$this->db->where('location_id', $location_id);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function get_locations($sort_location_state=false, $sort_location_name=false)
	{
		if ($sort_location_state)
		{
			#$this->db->order_by('state', 'desc');
		}
		else
		{
			#$this->db->order_by('state', 'asc');
		}
		
		if ($sort_location_name)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
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