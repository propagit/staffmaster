<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {
		
	function prepare_client_data($data)
	{
				
		return $data;
	}
	
	function insert_client($data)
	{
		$data = $this->prepare_client_data($data);
		$this->db->insert('user_clients', $data);
		return $this->db->insert_id();
	}
	
	function search_clients($keyword="")
	{
		$sql = "SELECT c.*, u.*
				FROM user_clients c
				LEFT JOIN users u ON c.user_id = u.user_id";
		if ($keyword != "")
		{
			$sql .= " WHERE c.company_name LIKE '%" . $keyword . "%'";
		}
		$sql .= " ORDER BY c.company_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_client($user_id)
	{
		$sql = "SELECT c.*, u.*
				FROM user_clients c
				LEFT JOIN users u ON c.user_id = u.user_id WHERE c.user_id = '" . $user_id . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function get_client_by_client_id($client_id)
	{
		$sql = "SELECT c.*, u.*
				FROM user_clients c
				LEFT JOIN users u ON c.user_id = u.user_id WHERE c.client_id = '" . $client_id . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function update_client($user_id, $data)
	{
		$data = $this->prepare_client_data($data);
		$this->db->where('user_id', $user_id);
		return $this->db->update('user_clients', $data);
	}
	
	function delete_client($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->delete('user_clients');
	}
	
	/**
	*	@desc Inserts client departments into user_client_departments table
	*
	*   @name insert_client_departments
	*	@access public
	*	@param array(department name, user_client_id)
	*	@return insert id
	*	@author kaushtuv
	*/
	function insert_client_departments($data){
		$data = $this->prepare_client_data($data);
		$this->db->insert('user_clients_departments', $data);
		return $this->db->insert_id();
	}
	
	/**
	*	@desc Returns client departments based on client id
	*
	*   @name get_client_departments_by_user_id
	*	@access public
	*	@param int(user id)
	*	@return Client departments if they exist
	*	@author kaushtuv
	*/
	function get_client_departments($client_id){
		$client_departments = $this->db->select('user_clients_departments_id,department_name')->where('client_id',$client_id)->get('user_clients_departments')->result_array();
		if($client_departments){
			return $client_departments;	
		}
		return false;
	}
}