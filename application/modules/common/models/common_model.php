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
	
}