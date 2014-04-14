<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model {
	
	function get_config($config_name)
	{
		$this->db->where('config_name', $config_name);
		$query = $this->db->get('config');
		return $query->first_row('array');
	}
	
}