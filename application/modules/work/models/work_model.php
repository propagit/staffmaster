<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_model extends CI_Model {
	
	var $user_id = null;
	function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function insert_shift_staff_apply($shift_id)
	{
		$data = array(
			'shift_id' => $shift_id,
			'staff_id' => $this->user_id
		);
		$this->db->insert('job_shift_staff_apply', $data);
		return $this->db->insert_id();
	}
	
	function delete_shift_staff($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $this->user_id);
		return $this->db->delete('job_shift_staff_apply');
	}
	
	function is_shift_staff_applied($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $this->user_id);
		$query = $this->db->get('job_shift_staff_apply');
		return $query->num_rows();
	}
	
	/**
	*	@name: get_work_months
	*	@desc: get list of month with available job (shift)
	*	@access: public
	*	@param: $active_month (YYYY-MM)
	*	@return: array of timestamp
	*/
	function get_work_months($active_month) {
		$sql = "SELECT `job_date`,
					YEAR(`job_date`) AS `year`, 
					MONTH(`job_date`) AS `month` 
				FROM `job_shifts` 
					WHERE `job_date` >= '" . $active_month . "' 
					AND `status` IN (" . SHIFT_REJECTED . "," . SHIFT_UNASSIGNED . "," . SHIFT_UNCONFIRMED . ")
					GROUP BY `year`, `month`";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$out = array();
		foreach($result as $r) {
			$out[] = strtotime($r['year'] . '-' . $r['month']);
		}
		return $out;
	}
	
	/**
	*	@name: get_work_days
	*	@desc: get list of available shifts group by date in a month
	*	@access: public
	*	@param: $active_month (YYYY-MM)
	*	@return: list of date with total count of available shifts
	*/
	function get_work_days($active_month) {
		$sql = "SELECT `job_date`, count(*) as `shifts_count` FROM `job_shifts`
				WHERE `job_date` LIKE '" . $active_month . "%'
				AND `status` IN (" . SHIFT_REJECTED . "," . SHIFT_UNASSIGNED . "," . SHIFT_UNCONFIRMED . ")
				AND `job_date` > '" . date('Y-m-d') . "'
				GROUP BY `job_date`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_day_shifts($date)
	{
		$sql = "SELECT js.*, j.client_id FROM `job_shifts` js
				LEFT JOIN `jobs` j ON j.job_id = js.job_id
				WHERE js.`job_date` = '" . $date . "'
				AND js.`status` IN (" . SHIFT_REJECTED . "," . SHIFT_UNASSIGNED . "," . SHIFT_UNCONFIRMED . ")";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: count_day_shifts
	*	@desc: count total available shifts in a day
	*	@access: public
	*	@param: $date (YYY-MM-DD)
	*	@return: (int) total available shifts in a day
	*/
	function count_day_shifts($date) {
		$sql = "SELECT count(*) as `total`
				FROM `job_shift_staff_apply` a
				LEFT JOIN `job_shifts` j ON a.`shift_id` = j.`shift_id`
				WHERE a.`staff_id` = '" . $this->user_id . "'
				AND j.`job_date` = '" . $date . "'";
		$query =$this->db->query($sql);
		$r = $query->first_row('array');
		return $r['total'];
	}
}