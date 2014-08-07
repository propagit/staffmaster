<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model {
	
	function add($data)
	{
		if (!isset($data['key']) || !isset($data['value']) || $data['key'] == '')
		{
			return false;
		}
		if ($this->get($data['key']) !== false) # Found the config, update the value
		{
			$this->db->where('key', $data['key']);
			return $this->db->update('config', $data);
		}
		else # New config, add to database
		{
			$this->db->insert('config', $data);
			return $this->db->insert_id();
		}
		
	}
	
	function get($key)
	{
		$this->db->where('key', $key);
		$query = $this->db->get('config');
		$config = $query->first_row('array');
		if ($config)
		{
			return $config['value'];
		}
		return false;
	}
}