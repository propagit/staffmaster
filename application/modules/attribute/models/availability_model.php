<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Availability_model extends CI_Model {
	
	function get_availability()
	{
		$query = $this->db->get('attribute_availability');
		return $query->result_array();
	}
	
		
}