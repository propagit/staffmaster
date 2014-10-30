<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_model extends CI_Model {
	
	var $user_id = null;
	var $module = 'job';
	var $object = 'roster';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('log/log_model');
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function get_roster_months($active_month)
	{
		$sql = "SELECT 
					YEAR(`job_date`) AS `year`, 
					MONTH(`job_date`) AS `month` 
				FROM `job_shifts` 
					WHERE `staff_id` = '" . $this->user_id . "'
					AND `job_date` >= '" . $active_month . "' 
					AND `status` NOT IN ('-1','-2')
					GROUP BY `year`, `month`";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$out = array();
		foreach($result as $r)
		{
			$out[] = strtotime($r['year'] . '-' . $r['month']);
		}
		return $out;
	}
	
	function get_rosters($active_month)
	{
		$sql = "SELECT js.*, j.client_id FROM `job_shifts` js
				LEFT JOIN `jobs` j ON j.job_id = js.job_id 
				WHERE js.`staff_id` = '" . $this->user_id . "'
				AND js.`status` NOT IN ('-1','-2')
				AND js.`job_date` LIKE '" . $active_month . "%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function update_roster($shift_id, $data)
	{
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $shift_id,
			'action' => 'update',
			'description' => serialize($data)
		);
		$this->log_model->insert_log($log_data);
		
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $this->user_id);
		return $this->db->update('job_shifts', $data);
	}
	
	function get_user_rosters_by_month($user_id,$active_month)
	{
		$sql = "SELECT js.*, j.client_id FROM `job_shifts` js
				LEFT JOIN `jobs` j ON j.job_id = js.job_id 
				WHERE js.`staff_id` = '" . $user_id . "'
				AND js.`status` NOT IN ('-1','-2')
				AND js.`job_date` LIKE '" . $active_month . "%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_user_rosters($user_id)
	{
		# daylight saving
		$time = time();
		$date = date('Y-m');
		if (date('I', strtotime($date)))
		{
			$time -= 3600;
		}
		$sql = "SELECT js.*, j.client_id FROM `job_shifts` js
				LEFT JOIN `jobs` j ON j.job_id = js.job_id 
				WHERE js.`staff_id` = '" . $user_id . "'
				AND js.`start_time` > " . $time . " 
				AND js.`status` NOT IN ('-1','-2')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}