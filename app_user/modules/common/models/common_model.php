<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

	function get_supers()
	{
		$query = $this->db->get('supers');
		return $query->result_array();
	}

	function get_super_name($super_id)
	{
		$this->db->where('super_id', $super_id);
		$query = $this->db->get('supers');
		$super = $query->first_row('array');
		return $super['name'];
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

	function get_country_name_from_country_code($country_code)
	{
		return $this->db->where('code',$country_code)
						->get('countries')
						->row();
	}

}
