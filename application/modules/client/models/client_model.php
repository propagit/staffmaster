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