<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
		
	function get_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function get_user_by_email($email) {
		$this->db->where('email_address', $email);
		$this->db->where('status != ', USER_DELETED);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function check_user_email($email, $user_id = null)
	{
		if ($user_id)
		{
			$this->db->where('user_id !=', $user_id);
		}
		$this->db->where('status != ', USER_DELETED);
		$this->db->where('email_address', $email);
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	
	function get_user_client($user_id)
	{
		$sql = "SELECT u.*, uc.*
					FROM users u
					LEFT JOIN user_clients uc ON uc.user_id = u.user_id
					WHERE u.user_id = $user_id";
		$query = $this->db->query($sql);
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
		$sql = "SELECT u.user_id, u.is_client, u.first_name, u.last_name, c.company_name
					FROM users u
					LEFT JOIN user_clients c ON c.user_id = u.user_id
				WHERE u.status = " . ACTIVE;
		$query = $this->db->query($sql);
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
		$data['modified_on'] = date('Y-m-d H:i:s');
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
		$sql = "UPDATE users SET status = " . CLIENT_DELETED . " WHERE user_id IN (".$user_ids.")";
		return $this->db->query($sql);
	}
	
	/**
	*
	*
	*
	*
	*
	*/
	function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->update('users', array(
			'status' => USER_DELETED
		));
		#return $this->db->delete('users');
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
	/**
	*	@name: get_user_email_from_user_id
	*	@desc: Get user email address from user id
	*	@access: public
	*	@param: (int) user id
	*/
	function get_user_email_from_user_id($user_id)
	{
		$sql = "SELECT email_address from users WHERE user_id = ".$user_id;
		$user = $this->db->query($sql)->row();
		if($user){
			return $user->email_address;	
		}
		return false;
	}
	
	/**
	*	@name: get_users_from_ids
	*	@desc: Get users from user ids
	*	@access: public
	*	@param: ([string]) user ids
	*/
	function get_users_from_ids($user_ids)
	{
		$sql = "SELECT * from users WHERE user_id IN (".$user_ids.")";
		$users = $this->db->query($sql)->result();
		return $users;
	}
	
	
}