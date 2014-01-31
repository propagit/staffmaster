<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_model extends CI_Model {
	
	var $user_id = null;
	function __construct()
	{
		parent::__construct();
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
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $this->user_id);
		return $this->db->update('job_shifts', $data);
	}
}