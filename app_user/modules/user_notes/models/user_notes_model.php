<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_notes_model extends CI_Model {
	
	function insert_note($data){
		$this->db->insert('user_notes', $data);
		return $this->db->insert_id();	
	}
	
	function get_user_notes($user_id){	
		$sql = "SELECT * FROM user_notes un
				WHERE un.user_id = " . $user_id . "
				GROUP BY un.created_date, un.added_by 
				ORDER BY un.created_on DESC";
		$notes = $this->db->query($sql)
				 		  ->result_array();
		return $notes;
	}
	
	/*
		admin_id is the added_by field
	*/
	function get_user_notes_by_admin_id_and_date($user_id,$admin_id,$date)
	{
		$notes = $this->db->where('added_by',$admin_id)
						  ->where('user_id',$user_id)
						  ->where('created_date',$date)
						  ->order_by('created_on','DESC')
						  ->get('user_notes')
						  ->result_array();
		return $notes;	
	}
	
	function get_recent_notes($limit)
	{
		$sql = "SELECT * FROM user_notes un
				GROUP BY un.created_date, un.added_by, un.user_id  
				ORDER BY un.created_on DESC
				LIMIT $limit";
		$notes = $this->db->query($sql)
				 		  ->result_array();
		return $notes;
	}
	
}