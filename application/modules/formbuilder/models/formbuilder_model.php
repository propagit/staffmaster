<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc This module is used for building custom form. On staffmaster this will be used for adding custom attributes for staff. These attributes will then be searchable for any given staff. 
*	@class_comments 
*	
*
*/

class Formbuilder_model extends CI_Model {
	
	
	function insert_form($data)
	{
		$this->db->insert('custom_forms',$data);
	}
	
	function get_form_elements()
	{
		$form_elements = $this->db->order_by('order','asc')->get('custom_forms')->result();
		if($form_elements){
			return $form_elements;
		}
		return false;
	}
	
	function reset_tables()
	{
		$tables = array('custom_forms');
		//empty table
		foreach($tables as $tbl){
			$sql = "TRUNCATE TABLE ".$tbl;
			$this->db->query($sql);
		}
		//reset auto increments
		foreach($tables as $tbl){
			$sql = "ALTER TABLE ".$tbl." AUTO_INCREMENT=1";
			$this->db->query($sql);
		}
		
	}
	
	
	
	
	
	
}