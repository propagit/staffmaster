<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
		
	function get_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function get_admin_users()
	{
		$this->db->where('is_admin', 1);
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	function get_users()
	{
		$this->db->where('parent_id', 0);
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	
	function prepare_user_data($data)
	{
		if (isset($data['password']))
		{
			if ($data['password'] == '')
			{
				unset($data['password']);
			}
			else
			{
				$data['password'] = md5($data['password']);
			}		
		}
		
		return $data;
	}
	
	function insert_user($data)
	{
		$data = $this->prepare_user_data($data);
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}
	
	function update_user($user_id, $data)
	{
		$data = $this->prepare_user_data($data);
		$this->db->where('user_id', $user_id);
		return $this->db->update('users', $data);
	}
	/**
	*	@name: delete_multi_users
	*	@desc: Delete multiple staffs
	*	@access: public
	*	@param: (int) user ids of staff
	*/
	function delete_multi_users($user_ids)
	{
		$sql = "UPDATE users SET status = 2 WHERE user_id IN (".$user_ids.")";
		return $this->db->query($sql);
	}
	
	function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->delete('users');
	}
	/**
	*	@name: update_rating_multi_staffs
	*	@desc: Update multiple users's status at once
	*	@access: public
	*	@param: (int) user ids of user and new status
	*/
	function update_status_multi_users($user_ids,$new_status)
	{
		$sql = "UPDATE users SET status = ".$new_status." WHERE user_id IN (".$user_ids.")";
		return $this->db->query($sql);
	}
	
	
}