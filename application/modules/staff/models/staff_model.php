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
	
	function update_available_data($user_id,$day,$hour)
	{
		$this->db->where('user_id', $user_id);		
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		return $this->db->update('user_staff_availability', array('value' => $value));
	}
	
	
	function get_all_photos($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		$query = $this->db->get('user_staff_picture');
		return $query->result_array();
	}
	function get_hero($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		$this->db->where('hero', 1);
		$query = $this->db->get('user_staff_picture');
		return $query->first_row('array');
	}
	
}