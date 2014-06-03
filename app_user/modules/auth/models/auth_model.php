<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	function get_user($username, $password)
	{
		$this->db->where('email_address', $username);
		$this->db->where('password', md5($password));
		$this->db->where('status',1);
		$query = $this->db->get('users');
		return $query->first_row('array');
	}
	
	function get_user_by_username($username)
	{
		$user = $this->db->where('email_address',$username)
						 ->where('status',1)
						 ->get('users')
						 ->row();
		return $user;
			
	}
	
}