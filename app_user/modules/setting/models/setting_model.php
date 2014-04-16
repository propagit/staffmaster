<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {
	
	function get_profile()
	{
		$this->db->where('id', 1);
		$query = $this->db->get('company_profile');
		return $query->first_row('array');
	}
	
	function update_profile($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('company_profile', $data);
	}
	
	function create_company_profile($data)
	{
		$this->db->insert('company_profile', $data);
		return $this->db->insert_id();
	}
	
	function get_profile_email_template()
	{
		$this->db->where('company_profile_id', 1);
		$query = $this->db->get('company_profile_email_template');
		return $query->first_row('array');
	}
	
	function get_system_styles($id = 1)
	{
		$styles = $this->db->where('style_id',$id)
						   ->get('system_styles')
						   ->row_array();
		return $styles;
	}
	
	function update_system_styles($data)
	{
		return $this->db->where('style_id',1)->update('system_styles',$data);	
	}
}