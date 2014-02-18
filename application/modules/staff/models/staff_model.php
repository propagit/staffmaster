<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_model extends CI_Model {
		
	function prepare_staff_data($data)
	{
				
		return $data;
	}
	
	function insert_staff($data)
	{
		$data = $this->prepare_staff_data($data);
		$this->db->insert('user_staffs', $data);
		return $this->db->insert_id();
	}
	
	function search_staffs($params = array())
	{
		$sql = "SELECT s.*, u.*
				FROM user_staffs s
				LEFT JOIN users u ON s.user_id = u.user_id";
		
		if(isset($params['keyword'])) { $sql .= " WHERE u.first_name LIKE '%" . $params['keyword'] . "%'"; }				
		if(isset($params['limit'])) { $sql .= " LIMIT " . $params['limit']; }
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_staff($user_id)
	{
		$sql = "SELECT s.*, u.*
				FROM user_staffs s
				LEFT JOIN users u ON s.user_id = u.user_id WHERE s.user_id = '" . $user_id . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function update_staff($user_id, $data)
	{
		$data = $this->prepare_staff_data($data);
		$this->db->where('user_id', $user_id);
		return $this->db->update('user_staffs', $data);
	}
		
	function delete_staff($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->delete('user_staffs');
	}
	
	
	function insert_availability_data($user_id,$data)
	{
		$this->db->insert('user_staff_availability', $data);
		return $this->db->insert_id();
	}
	
	function get_availability($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_staff_availability');
		return $query->result_array();
	}
	
	function get_availability_data($user_id,$day,$hour)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		$query = $this->db->get('user_staff_availability');
		$result =$query->first_row('array');
		return $result['value'];
	}
	
	function update_available_data($user_id,$day,$hour,$value)
	{
		$this->db->where('user_id', $user_id);		
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		return $this->db->update('user_staff_availability', array('value' => $value));
	}
	
	
	function get_all_photos($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_staff_picture');		
		return $query->result_array();
	}
	function get_hero($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('hero', 1);
		$query = $this->db->get('user_staff_picture');
		return $query->first_row('array');
	}
	/**
	*	@name: get_total_staffs_count
	*	@desc: Returns total staff based on status. If status is not passed it returns the total staffs
	*	@access: public
	*	@param: string, int status
	*	@return: (int) total staff count
	*/
	function get_total_staffs_count($status='')
	{
		$sql = 'select count(staff_id) as total from user_staffs';
		if($status){
			$sql .= '';	
		}
		$total = $this->db->query($sql)->row();
		if($total){
			return $total->total;	
		}
		return 0;
	}
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name staff_has_role
	*	@access public
	*	@param null
	*	@return Returns true if this role has been assigned to staff and vice versa
	*	
	*/
	function staff_has_role($staff_user_id,$role_id)
	{
		$query = $this->db->where('user_id',$staff_user_id)->where('attribute_role_id',$role_id)->get('staffs_roles')->row();
		if($query){
			return true;	
		}
		return false;
		
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
		$sql = "SELECT count(staffs_roles_id) as total FROM `staffs_roles` WHERE `attribute_role_id` = ".$role_id;
		$total = $this->db->query($sql)->row_array();
		if($total){
			return $total['total'];	
		}
		return 0;
	}
	/**
	*	@name: update_staff_role
	*	@desc: Update staff role. Adds or deletes role based on user input
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function update_staff_role($user_staff_id,$role_id)
	{
		$staff_has_role = $this->staff_has_role($user_staff_id,$role_id);
		if($staff_has_role){
			return $this->delete_staff_role($user_staff_id,$role_id);
		}else{
			return $this->add_staff_role($user_staff_id,$role_id);
		}
	}
	/**
	*	@name: add_staff_role
	*	@desc: Assign role to a staff
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function add_staff_role($user_staff_id,$role_id)
	{
		$data = array(
					'user_id' => $user_staff_id,
					'attribute_role_id' => $role_id
				);
		$this->db->insert('staffs_roles', $data);
		return $this->db->insert_id();
	}
	/**
	*	@name: delete_staff_role
	*	@desc: Delete role from the staff
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function delete_staff_role($user_staff_id,$role_id)
	{
		$sql = "delete from staffs_roles where user_id = ".$user_staff_id." and attribute_role_id = ".$role_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name staff_has_role
	*	@access public
	*	@param null
	*	@return Returns true if this role has been assigned to staff and vice versa
	*	
	*/
	function staff_has_group($staff_user_id,$group_id)
	{
		$query = $this->db->where('user_id',$staff_user_id)->where('attribute_group_id',$group_id)->get('staffs_groups')->row();
		if($query){
			return true;	
		}
		return false;
		
	}
	/**
	*	@name: update_staff_group
	*	@desc: Update staff group. Adds or deletes group based on user input
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function update_staff_group($user_staff_id,$group_id)
	{
		$staff_has_group = $this->staff_has_group($user_staff_id,$group_id);
		if($staff_has_group){
			return $this->delete_staff_group($user_staff_id,$group_id);
		}else{
			return $this->add_staff_group($user_staff_id,$group_id);
		}
	}
	/**
	*	@name: add_staff_group
	*	@desc: Assign group to a staff
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function add_staff_group($user_staff_id,$group_id)
	{
		$data = array(
					'user_id' => $user_staff_id,
					'attribute_group_id' => $group_id
				);
		$this->db->insert('staffs_groups', $data);
		return $this->db->insert_id();
	}
	/**
	*	@name: delete_staff_group
	*	@desc: Delete group from the staff
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function delete_staff_group($user_staff_id,$group_id)
	{
		$sql = "delete from staffs_groups where user_id = ".$user_staff_id." and attribute_group_id = ".$group_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@name: delete_staff_custom_attributes
	*	@desc: Delete custom attributes of a staff
	*	@access: public
	*	@param: (int) user id of staff
	*	@return: null
	*/
	function delete_staff_custom_attributes($user_staff_id)
	{
		$sql = "delete from staffs_custom_attributes where file_upload = 'no' and user_id = ".$user_staff_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@name: insert_staff_custom_attributes
	*	@desc: Add custom attributes of staff.
	*	@access: public
	*	@param: (int) user id of staff
	*	@return: null
	*/
	function insert_staff_custom_attributes($data)
	{
		$this->db->insert('staffs_custom_attributes',$data);
	}
	/**
	*	@name: get_staff_custom_attribute
	*	@desc: Get staff customa attribute from user id and attribute name
	*	@access: public
	*	@param: int(user id), (string) attribute name
	*	@return: null
	*/
	function get_staff_custom_attribute($user_id,$attribute_name)
	{
		return $this->db->where('user_id',$user_id)->where('attribute_name',$attribute_name)->get('staffs_custom_attributes')->row();
	}
	
	function get_staff_custom_attribute_by_id($staffs_custom_attributes_id)
	{
		return $this->db->where('staffs_custom_attributes_id',$staffs_custom_attributes_id)->get('staffs_custom_attributes')->row();
	}
	/**
	*	@name: delete_staff_custom_attributes_by_id
	*	@desc: Delete custom attributes of a staff by delete_staff_custom_attributes_by_id
	*	@access: public
	*	@param: (int) delete_staff_custom_attributes_by_id
	*	@return: null
	*/
	function delete_staff_custom_attributes_by_id($staffs_custom_attributes_id)
	{
		$sql = "delete from staffs_custom_attributes where staffs_custom_attributes_id = ".$staffs_custom_attributes_id;
		return $this->db->query($sql);
	}
}