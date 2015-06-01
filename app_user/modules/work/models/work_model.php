<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Work_model extends CI_Model {
	
	var $user_id = null;
	var $module = 'job';
	var $object = 'work';
	function __construct()
	{
		parent::__construct();
		$this->load->model('log/log_model');
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	function insert_shift_staff_apply($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $this->user_id);
		$query = $this->db->get('job_shift_staff_apply');
		if ($query->num_rows() == 0) {
			$data = array(
				'shift_id' => $shift_id,
				'staff_id' => $this->user_id
			);
			$this->db->insert('job_shift_staff_apply', $data);
			$work_id = $this->db->insert_id();
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $shift_id,
				'action' => 'applied'
			);
			$this->log_model->insert_log($log_data);
			return $work_id;
		}
		
	}
	
	function delete_shift_staff($shift_id)
	{
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $shift_id,
			'action' => 'unapplied'
		);
		$this->log_model->insert_log($log_data);
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
					AND (role_id = 0 OR (role_id != 0 AND role_id IN (
						SELECT attribute_role_id FROM staff_roles WHERE user_id = " . $this->user_id . "
						)))
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
		
		# First get availability
		$sql = "SELECT day, count(*) as `hours`
                FROM `user_staff_availability`
                WHERE user_id = " . $this->user_id. " AND value = 1
                GROUP BY day
                HAVING hours > 0";
        $query = $this->db->query($sql);
        $days = array();
		#echo $sql;exit;
        foreach($query->result_array() as $r)
        {
           # $days[] = ($r['day'] + 1) % 7; # Convert to mysql week day
		   $days[] = $r['day'];
        }
        $days_sql = '';
        if (count($days) > 0) {
            $days = implode(',', $days);
            $days_sql = "AND DAYOFWEEK(`job_date`) IN ($days)";
        }
		#echo $days_sql;exit;
		
		$sql = "SELECT `job_date`, count(*) as `shifts_count` FROM `job_shifts`
				WHERE `job_date` LIKE '" . $active_month . "%'
				AND (role_id = 0 OR (role_id != 0 AND role_id IN (
						SELECT attribute_role_id FROM staff_roles WHERE user_id = " . $this->user_id . "
						)))
				AND `status` IN (" . SHIFT_REJECTED . "," . SHIFT_UNASSIGNED . "," . SHIFT_UNCONFIRMED . ") 
				AND `job_date` >= '" . date('Y-m-d') . "'
				$days_sql 
				GROUP BY `job_date`";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_day_shifts($date) {
		$sql = "SELECT js.*, j.client_id FROM `job_shifts` js
				LEFT JOIN `jobs` j ON j.job_id = js.job_id
				WHERE js.`job_date` = '" . $date . "'
				AND (js.role_id = 0 OR (js.role_id != 0 AND js.role_id IN (
						SELECT attribute_role_id FROM staff_roles WHERE user_id = " . $this->user_id . "
						)))
				AND js.`status` IN (" . SHIFT_REJECTED . "," . SHIFT_UNASSIGNED . "," . SHIFT_UNCONFIRMED . ")";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function count_applied_shifts($date) {
		$sql = "SELECT count(*) as `total`
				FROM `job_shift_staff_apply` a
				LEFT JOIN `job_shifts` j ON a.`shift_id` = j.`shift_id`
				WHERE a.`staff_id` = '" . $this->user_id . "'
				AND j.status <= " . SHIFT_CONFIRMED . "
				AND j.`job_date` = '" . $date . "'";
		$query =$this->db->query($sql);
		$r = $query->first_row('array');
		return $r['total'];
	}
}