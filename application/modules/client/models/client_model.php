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
	
	function search_clients($params = array(),$total=false)
	{
		$records_per_page = 20;
		$sql = "SELECT c.*, u.*
				FROM user_clients c
				LEFT JOIN users u ON c.user_id = u.user_id WHERE u.status != 2";
		if(isset($params['keyword']) && $params['keyword'] != ''){$sql .= " WHERE c.company_name LIKE '%" . $params['keyword'] . "%'";} 
		if(isset($params['sort_by'])){ $sql .= " ORDER BY ".$params['sort_by']." ".$params['sort_order'];}
		if(!$total){
			if(isset($params['current_page']) && $params['current_page'] != ''){
				$sql .= " LIMIT ".(($params['current_page']-1)*$records_per_page)." ,".$records_per_page;
			}
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function all_clients() {
		$sql = "SELECT c.*, u.*
				FROM user_clients c
				LEFT JOIN users u ON c.user_id = u.user_id WHERE u.status != 2";
		//$query = $this->db->get('user_clients');
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_client_total_jobs($client_id) {
		$this->db->where('client_id', $client_id);
		$query = $this->db->get('jobs');
		return $query->num_rows();
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
	
	function insert_client_department($data)
	{
		$this->db->insert('user_client_departments', $data);
		return $this->db->insert_id();
	}
	
	function get_client_departments($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_client_departments');
		return $query->result_array();
	}
	
	function get_client_department($department_id)
	{
		$this->db->where('department_id', $department_id);
		$query = $this->db->get('user_client_departments');
		return $query->first_row('array');
	}
	
	function update_department($department_id, $data)
	{
		$this->db->where('department_id', $department_id);
		return $this->db->update('user_client_departments', $data);
	}
}