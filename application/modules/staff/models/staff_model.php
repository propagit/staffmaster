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
	
	function search_staffs($params)
	{
		$sql = "SELECT s.*, u.*
				FROM user_staffs s
				LEFT JOIN users u ON s.user_id = u.user_id";
		
		//if($params['staff_name']){$sql .= ' where s.first_name'}				
		
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
}