<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookbook_model extends CI_Model {
	
	function get_lookbook($key)
	{
		$lookbook = $this->db->where('key',$key)
							->get('lookbook')
							->row_array();
		return $lookbook;
	}
	
	function get_lookbook_config($type)
	{
		$config = $this->db->where('type',$type)
						  ->get('lookbook_config')
						  ->row_array();
		return $config;	
	}
	
	
}