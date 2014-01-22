<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
	
	function get_supers()
	{
		$query = $this->db->get('supers');
		return $query->result_array();
	}
	
	function get_states()
	{
		$query = $this->db->get('states');
		return $query->result_array();
	}
	
	function get_countries()
	{
		$query = $this->db->get('countries');
		return $query->result_array();
	}
	
	function get_locations()
	{
		$this->db->where('parent_id', 0);
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
	}
	function get_locations_child($param)
	{
		$this->db->where('parent_id', $param);
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
	}
	function get_locations_detail($param)
	{
		$this->db->where('location_id', $param);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function get_locations_byname($loc,$name)
	{
		$this->db->where('parent_id', $loc);
		$this->db->where('name', $name);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
		
}