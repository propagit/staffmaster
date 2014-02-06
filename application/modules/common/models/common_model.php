<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
	
	function get_supers()
	{
		$query = $this->db->get('supers');
		return $query->result_array();
	}
	
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
	
	function get_locations()
	{
		$this->db->where('parent_id', 0);
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
	}
	function get_locations_child($param)
	{
		$this->db->where('parent_id', $param);
		$query = $this->db->get('attribute_locations');
		return $query->result_array();
	}
	function get_locations_detail($param)
	{
		$this->db->where('location_id', $param);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	
	function get_locations_byname($loc,$name)
	{		
		$this->db->where('name', $name);
		$query = $this->db->get('attribute_locations');
		return $query->first_row('array');
	}
	function get_user_data($staff_id)
	{
		$this->db->where('staff_id', $staff_id);
		$query = $this->db->get('user_staffs');
		return $query->first_row('array');
	}
	function add_picture($data)
	{
		$this->db->insert('user_staff_picture', $data);
		return $this->db->insert_id();
	}
	function get_picture($id)
	{

		$this->db->where('id', $id);
		$query = $this->db->get('user_staff_picture');
		return $query->first_row('array');
	}
	function update_hero($staff_id,$photo_id)
	{
		$data=array('hero' => 0);
		$this->db->where('staff_id', $staff_id);
		$this->db->update('user_staff_picture', $data);
		
		$data=array('hero' => 1);
		$this->db->where('staff_id', $staff_id);
		$this->db->where('id', $photo_id);
		return $this->db->update('user_staff_picture', $data);
		
	}
	function delete_photo($staff_id,$photo_id)
	{
		$image = $this->get_picture($photo_id);
		unlink('./uploads/staff/profile/'.md5($staff_id).'/'.$image['name']);
		unlink('./uploads/staff/profile/'.md5($staff_id).'/thumbnail/'.$image['name']);
		
		$this->db->where('staff_id', $staff_id);
		$this->db->where('id', $photo_id);
		return $this->db->delete('user_staff_picture');
	}
}