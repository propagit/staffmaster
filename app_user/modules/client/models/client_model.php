<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends CI_Model {
	
	var $module = 'client';
	var $object = 'client';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('log/log_model');
	}
	
	function prepare_client_data($data)
	{
				
		return $data;
	}
	
	/**
	*	@name: insert_client
	*	@desc: create a new client
	*	@access: public
	*	@param: $data = array()
	*	@return: $client_id
	*/
	function insert_client($data, $bypass_api=false)
	{
		$data = $this->prepare_client_data($data);
		$this->db->insert('user_clients', $data);
		$client_id = $this->db->insert_id();
		if (isset($data['user_id']))
		{
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $data['user_id'],
				'action' => 'create'
			);
			$this->log_model->insert_log($log_data);
		}
		if (!$bypass_api)
		{
			$this->auto_add_client($data['user_id']);
		}
		
		
		return $client_id;
	}
	
	function auto_add_client($user_id)
	{
		if (!$this->config_model->get('auto_add_client'))
		{
			return;
		}
		$client = $this->get_client($user_id);
		if (!$client)
		{
			return;
		}
		$platform = $this->config_model->get('accounting_platform');
		if ($platform == 'shoebooks')
		{
			modules::run('api/shoebooks/append_customer', $user_id);
		}
		else if ($platform == 'myob')
		{
			modules::run('api/myob/connect', 'append_customer~' . $user_id);
		}
	}
	
	/**
	*	@name: update_client
	*	@desc: update client details information
	*	@access: public
	*	@param: $client_id, $data = array()
	*	@return: (boolean)
	*/
	function update_client($user_id, $data, $bypass_api=false)
	{
		$data = $this->prepare_client_data($data);
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $user_id,
			'action' => 'update',
			'description' => 'details'
		);
		$this->log_model->insert_log($log_data);
		$this->db->where('user_id', $user_id);
		$updated = $this->db->update('user_clients', $data);
		
		
		if (!$bypass_api)
		{
			$this->auto_update_client($user_id);
		}
		
		
		return $updated;
	}
	
	function auto_update_client($user_id)
	{
		if (!$this->config_model->get('auto_update_client'))
		{
			return;
		}
		$client = $this->get_client($user_id);
		if (!$client['external_client_id'])
		{
			return;
		}
		$platform = $this->config_model->get('accounting_platform');
		if ($platform == 'shoebooks')
		{
			modules::run('api/shoebooks/update_customer', $client['external_client_id']);
		}
		else if ($platform == 'myob')
		{
			modules::run('api/myob/connect', 'update_customer~' . $client['external_client_id']);
		}
	}
	
	function delete_client($user_id)
	{
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $user_id,
			'action' => 'delete'
		);
		$this->log_model->insert_log($log_data);
		$this->user_model->delete_user($user_id);
	}



	function search_clients($params = array(),$total=false)
	{
		$records_per_page = CLIENTS_PER_PAGE;
		$sql = "SELECT c.*, u.* 
				FROM user_clients c 
				LEFT JOIN users u ON c.user_id = u.user_id WHERE u.status > " . CLIENT_DELETED;
		if(isset($params['keyword']) && $params['keyword'] != ''){$sql .= " AND c.company_name LIKE '%" . $params['keyword'] . "%'";} 
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
				LEFT JOIN users u ON c.user_id = u.user_id WHERE u.status > " . CLIENT_DELETED;
		//$query = $this->db->get('user_clients');
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_total_clients_count() {
		$sql = 'select count(user_id) as total from users where is_client = 1 AND status = ' . CLIENT_ACTIVE;
		$total = $this->db->query($sql)->row();
		if($total){
			return $total->total;	
		}
		return 0;
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
	
	function get_client_by_external_id($external_id)
	{
		$sql = "SELECT c.*, u.*
				FROM user_clients c
					LEFT JOIN users u ON c.user_id = u.user_id
				WHERE c.external_client_id = '" . $external_id . "'
					 AND u.status >= " . CLIENT_INACTIVE;
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
	
	/**
	*	@name: insert_client_department
	*	@desc: create a new client department
	*	@access: public
	*	@param: $data = array()
	*	@return: $department_id
	*/
	function insert_client_department($data)
	{
		if (isset($data['user_id']))
		{
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $data['user_id'],
				'action' => 'update',
				'description' => 'departments'
			);
			$this->log_model->insert_log($log_data);
		}		
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
	
	function get_client_total_jobs_by_client_id_and_year($client_id,$year = NULL)
	{
		$sql = "select count(job_id) as total_jobs from jobs where client_id = ".$client_id;
		if($year){
			$sql .= " and year(createdon) = '".$year."'";	
		}
		$jobs = $this->db->query($sql)->row();
		if($jobs){
			return $jobs->total_jobs;	
		}else{
			return 0;	
		}
	}
	
	function get_venues($user_id) {
		$sql = "SELECT c.venue_id as is_restricted, v.* FROM attribute_venues v
					LEFT JOIN user_client_venue_restrict c ON (c.venue_id = v.venue_id AND c.user_id = $user_id)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function restrict_venue($data) {
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('venue_id', $data['venue_id']);
		$query = $this->db->get('user_client_venue_restrict');
		if ($query->num_rows()) { # Found, delete
			$this->db->where('user_id', $data['user_id']);
			$this->db->where('venue_id', $data['venue_id']);
			return $this->db->delete('user_client_venue_restrict');
		} else { # Not found, insert
			$this->db->insert('user_client_venue_restrict', $data);
			return $this->db->insert_id();
		}
		
	}
	
	function add_venue($data) {
		$this->db->where('user_id', $data['user_id']);
		$this->db->where('venue_id', $data['venue_id']);
		$query = $this->db->get('user_client_venue_restrict');
		if (!$query->num_rows()) { # Not found, insert
			$this->db->insert('user_client_venue_restrict', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_venues($user_id) {
		$this->db->where('user_id', $user_id);
		return $this->db->delete('user_client_venue_restrict');
	}
	
	
	
}