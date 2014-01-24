<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model {
	
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

}