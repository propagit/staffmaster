<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {
	
	function get_states()
	{
		$query = $this->db->get('states');
		return $query->result_array();
	}
	
}