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
	
	/**
	*	@desc This function queries the database and returns the list of roles based on the sort parameter. The roles are sorted in the ascending order of their name by default.
	*
	*   @name get_roles
	*	@access public
	*	@param string(sort parameter)
	*	@return Returns array of avaliable roles
	*	
	*/

	function get_venues($params = '',$total = false)
	{
		$records_per_page = VENUES_PER_PAGE;
		$sql = "select attribute_venues.*,
				attribute_locations.location_id as location_id,
				attribute_locations.parent_id as location_parent_id, 
				attribute_locations.name as location_name 
				from
				attribute_venues, attribute_locations where attribute_venues.location_id = attribute_locations.location_id";
		if($params){
			$sort_param = json_decode($params);	
			$sql .= " order by $sort_param->sort_by $sort_param->sort_order";
		}else{
			$sql .= " order by name asc";
		}
		
		if(!$total){
			$page = json_decode($params);
			if(isset($page->current_page) && $page->current_page != ''){
				$sql .= " LIMIT ".(($page->current_page-1)*$records_per_page)." ,".$records_per_page;
			}
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function all_venues() {
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