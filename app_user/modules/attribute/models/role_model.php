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
	
	
	/**
	*	@desc This function queries the database and returns the list of roles based on the sort parameter. The roles are sorted in the ascending order of their name by default.
	*
	*   @name get_roles
	*	@access public
	*	@param string(sort parameter)
	*	@return Returns array of avaliable roles
	*	
	*/

	function get_roles($params = '')
	{
		$sql = "SELECT ar.*, 
				(SELECT COUNT(staff_roles_id) FROM staff_roles sr, users u 
					WHERE ar.role_id = sr.attribute_role_id
					AND sr.user_id = u.user_id 
					AND u.status = " . STAFF_ACTIVE . ") AS frequency 
				FROM attribute_roles ar";
		if($params){
			$sort_param = json_decode($params);	
			$sql .= " ORDER BY $sort_param->sort_by $sort_param->sort_order";
		}else{
			$sql .= " ORDER BY name ASC";
		}
		$query = $this->db->query($sql);
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