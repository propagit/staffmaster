<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_model extends CI_Model {
	
	function get_finished_shifts() {
		$sql = "SELECT * FROM `job_shifts`
				WHERE `status` >= " . SHIFT_CONFIRMED . "
				AND `finish_time` < " . time() . " 
				AND `shift_id` NOT IN
					(SELECT `shift_id` FROM `job_shift_timesheets`)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function insert_timesheet($data) {
		$this->db->insert('job_shift_timesheets', $data);
		return $this->db->insert_id();
	}
	
	/**
	*	@name: get_timesheet
	*	@desc: get timesheet by id
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (object) timesheet
	*/
	function get_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		$query = $this->db->get('job_shift_timesheets');
		return $query->first_row('array');
	}
	
	/**
	*	@name: delete_timesheet
	*	@desc: delete timesheet by id
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (boolean)
	*/
	function delete_timesheet($timesheet_id) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->delete('job_shift_timesheets');
	}
	
	/**
	*	@name: delete_shift_timesheet
	*	@desc: delete timesheet by shift_id
	*	@access: public
	*	@param: $shift_id
	*	@return: (boolean)
	*/
	function delete_shift_timesheet($shift_id) {
		$this->db->where('shift_id', $shift_id);
		return $this->db->delete('job_shift_timesheets');
	}
	
	/**
	*	@name: update_timesheet
	*	@desc: update timesheet by id
	*	@access: public
	*	@param: $timesheet_id, $data (array)
	*	@return: (boolean)
	*/
	function update_timesheet($timesheet_id, $data) {
		$this->db->where('timesheet_id', $timesheet_id);
		return $this->db->update('job_shift_timesheets', $data);
	}
	
	/**
	*	@name: search_timesheets
	*	@desc: search timesheets by parameters
	*	@access: public
	*	@param: $params (array of searching parameters)
	*	@return: (array) of timesheets
	*/
	function search_timesheets($params) {
		$sql = "SELECT t.*, 
					j.name as job_name, j.client_id, 
					v.name as venue_name, 
					r.name as role_name
				FROM `job_shift_timesheets` t
					LEFT JOIN `attribute_venues` v ON v.venue_id = t.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = t.role_id
					JOIN `jobs` j ON j.job_id = t.job_id AND j.status > " . JOB_DELETED . "
				WHERE t.status < " . TIMESHEET_BATCHED;
		if (isset($params['client_id']) && $params['client_id'] != '') {
			$sql .= " AND j.client_id = " . $params['client_id'];
		}
		if (isset($params['job_name']) && $params['job_name'] != '') {
			$sql .= " AND j.name LIKE '%" . $params['job_name'] . "%'";
		}
		if (isset($params['status']) && $params['status'] != '') {
			$sql .= " AND t.status = " . $params['status'];
		}
		if (isset($params['role_id']) && $params['role_id'] != '') {
			$sql .= " AND t.role_id = " . $params['role_id'];
		}
		if (isset($params['date_from']) && $params['date_from'] != '') {
			$sql .= " AND t.start_time >= " . strtotime($params['date_from']);
		}
		if (isset($params['date_to']) && $params['date_to'] != '') {
			$sql .= " AND t.finish_time <= " . strtotime($params['date_to'] . ' 23:59:59');
		}
		if (isset($params['payrate_id']) && $params['payrate_id'] != '') {
			$sql .= " AND t.payrate_id = " . $params['payrate_id'];
		}
		if (isset($params['sort_data'])) {
			$sort_params = json_decode($params['sort_data']);
			if (isset($sort_params->sort_by) && isset($sort_params->sort_order)) {
				$sql .= " ORDER BY $sort_params->sort_by $sort_params->sort_order";
			}
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	# Deprecated
	function get_timesheets($sort_params = '') {
		$params = '';
		if($sort_params){
			$params = json_decode($sort_params);	
		}
		$sql = "SELECT t.*, j.name as job_name, j.client_id, v.name as venue_name, r.name as role_name
				FROM `job_shift_timesheets` t
					LEFT JOIN `attribute_venues` v ON v.venue_id = t.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = t.role_id
					LEFT JOIN `jobs` j ON j.job_id = t.job_id
				WHERE t.status < 3";
		if($params){
			$sql .= " order by $params->sort_by $params->sort_order";	
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	# timesheet for email 
	function get_timesheet_for_email($key_type = ''){
		$sql = "SELECT t.* 
				FROM `job_shift_timesheets` t 
				WHERE t.status < " . TIMESHEET_APPROVED . " 
				AND t.email_sent != " . TIMESHEET_EMAIL_SENT . " 
				AND t.reject_note = ''"; 
		if($key_type){
				$group_by_key = $key_type == TIMESHEET_SUPERVISOR_KEY_TYPE ? 'supervisor_key' : 'staff_key';
				$sql .= " AND t.$group_by_key != ''
						GROUP BY $group_by_key";	
		}
		$query = $this->db->query($sql);
		return $query->result_array();			
	}
	
	function get_timesheet_by_key($key_type,$key,$group_by_staff = false)
	{
		$sql = "SELECT t.* 
				FROM `job_shift_timesheets` t  
				WHERE t.reject_note = ''";
		# supervisor - key_type - sp
		if($key_type == TIMESHEET_SUPERVISOR_KEY_TYPE){
			$sql .= " AND t.status < " . TIMESHEET_APPROVED . " 
					 AND t.supervisor_id != 0 AND t.supervisor_key = '" . $key . "'";		
		}else{
		# staff - keytype - sf
			$sql .= " AND t.status < " . TIMESHEET_SUBMITTED . " 
					 AND t.staff_key = '" . $key . "'";		
		}
		
		# to get no of staffs
		if($group_by_staff){
			$sql .= " GROUP BY t.staff_id";	
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function mark_record_as_email_sent($key_type,$key)
	{
		if($key_type == TIMESHEET_SUPERVISOR_KEY_TYPE){
			$this->db->where('supervisor_key',$key);		
		}else{
			$this->db->where('staff_key',$key);		
		}
		$this->db->update('job_shift_timesheets',array('email_sent' => 1));
	}
	
}