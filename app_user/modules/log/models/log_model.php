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
		if ($data['object'] == 'work' || $data['object'] == 'roster')
		{
			$data['created_on'] = date('Y-m-d H:i') . ':' . rand(0,60);
		}
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
	
	function get_notifications()
	{
		$courses = array(
			'roster' => array('update'),
			'work' => array('applied', 'unapplied'),
			'timesheet' => array('submit'),
			'staff' => array('delete'),
			'client' => array('delete')
		);
		$sql = "SELECT * FROM `logs` WHERE (";
		foreach($courses as $object => $actions)
		{
			$sql .= "(`object` = '$object' AND `action` IN ('" . implode("','", $actions) . "')) OR ";
		}
		$sql .= " 1=0)";
		if (!modules::run('auth/is_admin'))
		{
			$sql .= " AND user_id = " . $this->user_id;
		}
		$sql .= " ORDER BY `log_id` DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
}