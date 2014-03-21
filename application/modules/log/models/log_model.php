<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {
	
	var $user_id = null;
	function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function insert_log($data) 
	{
		$data['user_id'] = $this->user_id;
		$this->db->insert('logs', $data);
		return $this->db->insert_id();
	}
	
	function watched_log($log_id) 
	{
		$this->db->where('log_id', $log_id);
		return $this->db->update('logs', array(
			'watched' => LOG_WATCHED
		));
	}
	
	function get_logged_dates() 
	{
		$sql = "SELECT DATE(`created_on`) AS `date`
				FROM `logs`
				GROUP BY DATE(`created_on`) ORDER BY `date` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_logs_by_date($date) {
		$sql = "SELECT *, count(*) as `total`
				FROM `logs`
				WHERE DATE(`created_on`) = '$date'
				GROUP BY `created_on`
				ORDER BY `log_id` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}