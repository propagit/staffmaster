<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lookbook_model extends CI_Model {
	
	function get_lookbook_by_key($key)
	{
		$lookbook = $this->db->where('key',$key)
							->get('lookbook')
							->first_row('array');
		return $lookbook;
	}
	
	function get_lookbook_config($type)
	{				  				  
		# if type is custom fields - check if this custom field exist if not remove this from the config
		if($type == LB_CUSTOM){
			$config = $this->db->where('type',$type)
						  ->get('lookbook_config')
						  ->row_array();
			if($config){
				$custom = array();
				$fields = json_decode($config['fields']);
				if($fields){
					foreach($fields as $f){
						if(modules::run('attribute/custom/get_custom_field',$f)){
							$custom[] = $f;	
						}
					}
					$this->update_lookbook_config(LB_CUSTOM,json_encode($custom));
				}
			}
		}
		$config = $this->db->where('type',$type)
						  ->get('lookbook_config')
						  ->row_array();
						  
		return $config['fields'];	
	}
	
	function update_lookbook_config($type,$data)
	{
		$this->db->where('type',$type)
				 ->update('lookbook_config',array('fields' => $data));
	}
	
	function insert_lookbook($data)
	{
		$this->db->insert('lookbook',$data);
		return $this->db->insert_id();	
	}
	
	function get_lookbook_by_id($lookbook_id)
	{
		$lookbook = $this->db->where('lookbook_id',$lookbook_id)
							->get('lookbook')
							->row_array();
		return $lookbook;
	}
	
	function get_fields() {
		$this->db->where('admin_only',0);
		$this->db->order_by('field_order', 'asc');
		$query = $this->db->get('custom_fields');
		return $query->result_array();
	}
	
	
}