<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brief_model extends CI_Model {
	
	/**
	*	@name: add_brief
	*	@desc: Performs Database operation - insert data to the table brief
	*	@access: public
	*	@param: (array) brief info such as brief name etc
	*	@return: insert id
	*/
	function add_brief($data)
	{
		$this->db->insert('brief',$data);
		return $this->db->insert_id();
	}
	/**
	*	@name: add_brief_elements
	*	@desc: Performs Database operation - insert data to the table brief_elements
	*	@access: public
	*	@param: (array) brief id, brief elements data
	*	@return: insert id
	*/
	function add_brief_elements($data)
	{
		$this->db->insert('brief_elements',$data);
		return $this->db->insert_id();
	}
	
	function get_brief_elements_next_order($brief_id)
	{
		$brief_element_order = $this->db->select_max('element_order')->get('brief_elements')->row();
		return $brief_element_order->element_order+1;
	}
	
	function get_brief_elements($brief_id)
	{
		$brief_elements = $this->db->where('brief_id',$brief_id)->order_by('element_order','asc')->get('brief_elements')->result();
		if($brief_elements){
			return $brief_elements;	
		}
		return false;
	}
	
	function update_brief_elements($brief_element_id,$data)
	{
		return $this->db->where('brief_element_id',$brief_element_id)->update('brief_elements',$data);	
	}
}