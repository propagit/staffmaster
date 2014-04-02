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
	*	@name: get_brief
	*	@desc: Performs Database operation - to get brief
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: brief info or false if no brief elements exists
	*/
	function get_brief($brief_id)
	{
		$brief = $this->db->where('brief_id',$brief_id)
						  ->get('brief')
						  ->row();
		if($brief){
			return $brief;	
		}
		return false;
	}
	/**
	*	@name: update_brief
	*	@desc: Performs Database operation - updates brief
	*	@access: public
	*	@param: ([int] brief_id, update data)
	*	@return: affected row
	*/
	function update_brief($brief_id,$data)
	{
		return $this->db->where('brief_id',$brief_id)
						->update('brief',$data);	
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
	/**
	*	@name: get_brief_elements_next_order
	*	@desc: Searches for the lagest sort order for brief elements of a given brief increments that number by one and returns that increased value
	*	@access: public
	*	@param: ([int] brief_id)
	*	@return: next sort order
	*/
	function get_brief_elements_next_order($brief_id)
	{
		$brief_element_order = $this->db->select_max('element_order')
										->get('brief_elements')
										->row();
		return $brief_element_order->element_order+1;
	}
	/**
	*	@name: get_brief_elements
	*	@desc: Performs Database operation - to get brief elements of a brief
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: list of brief elements or false if no brief elements exists
	*/
	function get_brief_elements($brief_id)
	{
		$brief_elements = $this->db->where('brief_id',$brief_id)
								   ->order_by('element_order','asc')
								   ->get('brief_elements')
								   ->result();
		if($brief_elements){
			return $brief_elements;	
		}
		return false;
	}
	/**
	*	@name: update_brief_elements
	*	@desc: Performs Database operation - updates brief elements
	*	@access: public
	*	@param: ([int] brief_element_id, update data)
	*	@return: affected row
	*/
	function update_brief_elements($brief_element_id,$data)
	{
		return $this->db->where('brief_element_id',$brief_element_id)
					    ->update('brief_elements',$data);	
	}
	/**
	*	@name: search_brief
	*	@desc: Performs a keyword based search
	*	@access: public
	*	@param: ([array] keyword, sort parameters, page number and limit if applicable)
	*	@return: list of briefs
	*/
	function search_brief($params = NULL,$total = false)
	{
		$records_per_page = BRIEF_PER_PAGE;
		if (isset($params['keyword']) && $params['keyword'] != '' ) {
			$this->db->like('name', $params['keyword']);
		}
		//sort
		if(isset($params['sort_by']) && $params['sort_by'] != ''){
			$this->db->order_by($params['sort_by'],$params['sort_order']);	
		}
		if(!$total){
			if(isset($params['current_page']) && $params['current_page'] != ''){
				$offset = ($params['current_page']-1)*$records_per_page;
				$this->db->limit($records_per_page,$offset);
			}
		}
		
		$query = $this->db->get('brief');
		return $query->result();
	}
}