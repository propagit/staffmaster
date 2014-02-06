<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	
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
	
	function check_username($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function get_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function get_users()
	{
		$this->db->where('parent_id', 0);
		$query = $this->db->get('users');
		return $query->result_array();
	}
	
	function get_sub_users($user_id)
	{
		$this->db->where('parent_id', $user_id);
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
	
	function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->delete('users');
	}
	
	
}