<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Role Model. Handles database operation regarding the attribute Role. 
*	
*/

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
	
	function get_roles($params)
	{
		switch($params){
			case 'name_desc':
				$this->db->order_by('name', 'desc');
			break;	
			
			case 'name_asc':
				$this->db->order_by('name', 'asc');
			break;
		}
		$query = $this->db->get('attribute_roles');
		return $query->result_array();
	}

	/**
	*	@desc This function returns the frequency of the role. It returns the number of times this role has been assigned to staffs.
	*
	*   @name get_role_frequency
	*	@access public
	*	@param null
	*	@return Return the number of times this roles has been assigned to staffs.
	*	
	*/
	
	function get_role_frequency($role_id)
	{
		$sql = "SELECT count(staff_id) as total FROM `user_staffs` WHERE `roles` LIKE '%".$role_id."%'";
		$total = $this->db->query($sql)->row_array();
		if($total){
			return $total['total'];	
		}
		return 0;
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