<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uniform_model extends CI_Model {
	
	function get_uniforms($sort_uniform=false)
	{
		if ($sort_uniform)
		{
			$this->db->order_by('name', 'desc');
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('attribute_uniforms');
		return $query->result_array();
	}
	
	function insert_uniform($data)
	{
		$this->db->insert('attribute_uniforms', $data);
		return $this->db->insert_id();
	}
	
	
	function update_uniform($uniform_id, $data)
	{
		$this->db->where('uniform_id', $uniform_id);
		return $this->db->update('attribute_uniforms', $data);
	}
	
	function delete_uniform($uniform_id)
	{
		$this->db->where('uniform_id', $uniform_id);
		return $this->db->delete('attribute_uniforms');
	}
}