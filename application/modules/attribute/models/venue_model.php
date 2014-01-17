<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venue_model extends CI_Model {
	
	function get_venue($venue_id)
	{
		$this->db->where('venue_id', $venue_id);
		$query = $this->db->get('attribute_venues');
		return $query->first_row('array');
	}
	
	function get_venue_by_name($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('attribute_venues');
		return $query->first_row('array');
	}
	
	function get_venues($sort_venue=false)
	{
		if ($sort_venue)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		
		$query = $this->db->get('attribute_venues');
		return $query->result_array();
	}
	
	function insert_venue($data)
	{
		$this->db->insert('attribute_venues', $data);
		return $this->db->insert_id();
	}
	
	function update_venue($venue_id, $data)
	{
		$this->db->where('venue_id', $venue_id);
		return $this->db->update('attribute_venues', $data);
	}
	
	function delete_venue($venue_id)
	{
		$this->db->where('venue_id', $venue_id);
		return $this->db->delete('attribute_venues');
	}
}