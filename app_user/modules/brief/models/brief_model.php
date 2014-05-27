<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brief_model extends CI_Model {
	
	function get_brief_shifts($job_id, $venue_id, $job_date)
	{
		$sql = "SELECT u.first_name, u.last_name,
						r.name as role_name,
						j.start_time, j.break_time, j.finish_time
					FROM job_shifts j
						LEFT JOIN users u ON u.user_id = j.staff_id
						LEFT JOIN attribute_roles r ON r.role_id = j.role_id
					WHERE j.job_id = $job_id
					AND j.venue_id = $venue_id 
					AND j.job_date = '$job_date'
					AND j.status > " . SHIFT_DELETED . "
					AND j.status < " . SHIFT_FINISHED . "
					ORDER BY j.start_time ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
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
	*	@name: get_brief_by_encoded_url
	*	@desc: Performs Database operation - to get brief by encoded url
	*	@access: public
	*	@param: ([string] encoded_url)
	*	@return: brief info or false if no brief elements exists
	*/
	function get_brief_by_encoded_url($encoded_url)
	{
		$brief = $this->db->where('encoded_url',$encoded_url)
						  ->get('brief')
						  ->row();
		return $brief;
	}
	/**
	*	@name: get_all_brief
	*	@desc: Performs Database operation - to get all briefs
	*	@access: public
	*	@param: ([bool] status )
	*	@return: brief info or false if no brief elements exists
	*/
	function get_all_brief($active = false)
	{
		if($active){
			$this->db->where('status',1);	
		}
		$query = $this->db->get('brief');
		return $query->result();
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
	*	@name: get_brief_elements_by_brief_element_id
	*	@desc: Performs Database operation - to get brief elements by brief element id
	*	@access: public
	*	@param: ([int] brief_element_id)
	*	@return: list of brief elements or false if no brief elements exists
	*/
	function get_brief_elements_by_brief_element_id($brief_element_id)
	{
		$brief_element = $this->db->where('brief_element_id',$brief_element_id)
								   ->get('brief_elements')
								   ->row();
		if($brief_element){
			return $brief_element;	
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
				$offset = ($params['current_page']-1) * $records_per_page;
				$this->db->limit($records_per_page,$offset);
			}
		}
		
		$query = $this->db->get('brief');
		return $query->result();
	}
	
	/**
	*	@name: delete_brief
	*	@desc: Permanently removes a brief from the system
	*	@access: public
	*	@param: ([int] brief_id)
	*	@return: rows affected 
	*/
	function delete_brief($brief_id)
	{
		$this->db->where('brief_id', $brief_id);
		return $this->db->delete('brief');
	}
	
	/**
	*	@name: delete_brief_elements_by_brief_id
	*	@desc: Permanently removes all brief elements of a brief
	*	@access: public
	*	@param: ([int] brief_id)
	*	@return: rows affected 
	*/
	function delete_brief_elements_by_brief_id($brief_id)
	{
		$this->db->where('brief_id', $brief_id);
		return $this->db->delete('brief_elements');
	}
	
	/**
	*	@name: delete_brief_elements_by_brief_element_id
	*	@desc: Permanently removes a single brief element 
	*	@access: public
	*	@param: ([int] brief_element_id)
	*	@return: rows affected 
	*/
	function delete_brief_elements_by_brief_element_id($brief_element_id)
	{
		$this->db->where('brief_element_id', $brief_element_id);
		return $this->db->delete('brief_elements');
	}
	/**
	*	@name: delete_shift_brief_by_brief_id
	*	@desc: Permanently removes attached brief from shift brief
	*	@access: public
	*	@param: ([int] brief_id)
	*	@return: rows affected 
	*/
	function delete_shift_brief_by_brief_id($brief_id)
	{
		$this->db->where('brief_id', $brief_id);
		return $this->db->delete('shift_brief');
	}
	/**
	*	@name: check_brief_status
	*	@desc: Performs db operation to see if a brief has been attached to a shift or not.
	*	@access: public
	*	@param: ([int] brief_id)
	*	@return: rows affected 
	*/
	function check_brief_status($brief_id)
	{
		$today = date('Y-m-d');
		$sql = "SELECT sb.* FROM shift_brief sb 
				INNER JOIN job_shifts js 
				WHERE sb.shift_id = js.shift_id
				AND js.job_date >= '".$today."' 
				AND sb.brief_id = ".$brief_id;
		$status = $this->db->query($sql)->result();
		if($status){
			return true;	
		}
		return false;
	}
}