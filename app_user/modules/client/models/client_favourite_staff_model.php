<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_favourite_staff_model extends CI_Model {
	
	function __construct() 
	{
		parent::__construct();
		
	}
	
	function insert($data)
	{
		$this->db->insert('client_favourite_staff',$data);
		return $this->db->insert_id();	
	}
	
	function update($client_user_id,$staff_user_id,$data)
	{
		$this->db->where('client_user_id',$client_user_id)
				 ->where('staff_user_id',$staff_user_id)
				 ->update('client_favourite_staff',$data);	
	}
	
	function get($client_user_id,$staff_user_id)
	{
		$result = $this->db->where('client_user_id',$client_user_id)
						  ->where('staff_user_id',$staff_user_id)
						  ->get('client_favourite_staff')
						  ->first_row('array');
		return $result;	
	}
	
	function is_liked($client_user_id,$staff_user_id)
	{
		$result = $this->get($client_user_id,$staff_user_id);
		if($result){
			return $result['status'];	
		}
		return false;
	}
}