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
	
	function get_form_elements($all = true)
	{
		if(!$all){
			$this->db->where('type','filebutton');
		}
		$this->db->order_by('order','asc');
		$form_elements = $this->db->get('custom_forms')->result();
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
	/**
	*	@desc Returns attribute info when name of the attribute is supplied
	*
	*   @name get_attribute_info
	*	@access public
	*	@param (string) name of the attribute
	*	@return returns attribute details
	*/
	function get_attribute_info($attribute_name)
	{
		return $this->db->where('name',$attribute_name)->get('custom_forms')->row();
	}
	
	
	
	
	
	
}