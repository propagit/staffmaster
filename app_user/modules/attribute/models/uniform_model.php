<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uniform_model extends CI_Model {
	
	function get_uniforms($params = '')
	{
		$sql = "select * from attribute_uniforms";
		if($params){
			$sort_param = json_decode($params);	
			//$this->db->order_by($sort_param->sort_by,$sort_param->sort_order);
			$sql .= " order by $sort_param->sort_by $sort_param->sort_order";
		}else{
			$sql .= " order by name asc";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_uniform($data)
	{
		$this->db->insert('attribute_uniforms', $data);
		return $this->db->insert_id();
	}
	
	function get_uniform($uniform_id)
	{
		$this->db->where('uniform_id', $uniform_id);
		$query = $this->db->get('attribute_uniforms');
		return $query->first_row('array');
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