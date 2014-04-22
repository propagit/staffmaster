<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_shift_model extends CI_Model {
	
	var $module = 'job';
	var $object = 'shift';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('log/log_model');
	}
	
	/**
	*	@name: insert_job_shift
	*	@desc: create a new shift
	*	@access: public
	*	@param: $data = array()
	*	@return: $shift_id
	*/
	function insert_job_shift($data) 
	{
		$this->db->insert('job_shifts', $data);
		$shift_id = $this->db->insert_id();
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $shift_id,
			'action' => 'create'
		);
		$this->log_model->insert_log($log_data);
		return $shift_id;
	}
	
	/**
	*	@name: update_job_shift
	*	@desc: update a job shift
	*	@access: public
	*	@param: $shift_id, $data = array()
	*	@return: (boolean)
	*/
	function update_job_shift($shift_id, $data = array())
	{
		if (count($data) > 0)
		{
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $shift_id,
				'action' => 'update',
				'description' => serialize($data)
			);
			$this->log_model->insert_log($log_data);
			$data['modified_on'] = date('Y-m-d H:i:s');
		}
		$this->db->where('shift_id', $shift_id);
		return $this->db->update('job_shifts', $data);
	}	
	
	/**
	*	@name: delete_job_shift
	*	@desc: delete a job shift
	*	@access: public
	*	@param: $shift_id
	*	@return: (boolean)
	*/
	function delete_job_shift($shift_id) 
	{
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $shift_id,
			'action' => 'delete'
		);
		$this->log_model->insert_log($log_data);
		$this->db->where('shift_id', $shift_id);
		#return $this->db->delete('job_shifts');
		$this->db->update('job_shifts', array(
			'status' => SHIFT_DELETED
		));
	}
	
	/**
	*	@name: search_shifts
	*	@desc: search shifts
	*	@access: public
	*	@param: $data = array(), $sort_key = 'date', $sort_value = 'asc'
	*	@return: array of shifts
	*/		
	function search_shifts($data, $sort_key='date', $sort_value='asc')
	{
		$sql = "SELECT 
					js.*, j.name as job_name, j.client_id, 
					v.name as venue_name, 
					r.name as role_name
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = js.role_id
					LEFT JOIN `jobs` j ON j.job_id = js.job_id
					LEFT JOIN `users` u ON u.user_id = js.staff_id";
		if(isset($data['search_shift_shift_status']) && $data['search_shift_shift_status'] != '')
		{
			$sql .= " WHERE js.status = " . $data['search_shift_shift_status'];	
		} else 
		{
			$sql .= " WHERE js.status > " . SHIFT_DELETED;
		}
		if (isset($data['staff_name']) && $data['staff_name'] != '')
		{
			$sql .= " AND (u.first_name LIKE '%" . $data['staff_name'] . "%' 
							OR u.last_name LIKE '%" . $data['staff_name'] . "%' 
							OR CONCAT(u.first_name,' ', u.last_name) LIKE '%" . $data['staff_name'] . "%')"; 
		}
		if (isset($data['staff_id']) && $data['staff_id'] != '')
		{
			$sql .= " AND js.staff_id = " . $data['staff_id'];
		}
		if (isset($data['date_from']) && $data['date_from'] != '')
		{
			$sql .= " AND js.job_date >= '" . date('Y-m-d', strtotime($data['date_from'])) . "'";
		}
		if (isset($data['date_to']) && $data['date_to'] != '')
		{
			$sql .= " AND js.job_date <= '" . date('Y-m-d', strtotime($data['date_to'])) . "'";
		}
		if (isset($data['client_id']) && $data['client_id'] != '')
		{
			$sql .= " AND j.client_id = '" . $data['client_id'] . "'";
		}
		if (isset($data['venue']) && $data['venue'] != '')
		{
			$sql .= " AND v.name LIKE '%" . $data['venue'] . "%'";
		}
		if (isset($data['role_id']) && $data['role_id'] != '')
		{
			$sql .= " AND js.role_id = '" . $data['role_id'] . "'";
		}
		
		# Sorting
		if ($sort_key == 'client')
		{
			$sql .= " ORDER BY j.client_id " . $sort_value;
		}
		if ($sort_key == 'campaign')
		{
			$sql .= " ORDER BY j.name " . $sort_value;
		}
		if ($sort_key == 'date')
		{
			$sql .= " ORDER BY js.job_date " . $sort_value;
		}
		if ($sort_key == 'venue')
		{
			$sql .= " ORDER BY v.name " . $sort_value;
		}
		if ($sort_key == 'role')
		{
			$sql .= " ORDER BY r.name " . $sort_value;
		}
		if ($sort_key == 'status')
		{
			$sql .= " ORDER BY js.status " . $sort_value;
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: get_job_shifts
	*	@desc: get shifts in a job
	*	@access: public
	*	@param: $job_id, $job_date (YYYY-MM-DD), $sort_key = 'date', $sort_value = 'asc'
	*	@return: array of shifts
	*/
	function get_job_shifts($job_id, $job_date=null, $sort_key='date', $sort_value='asc')
	{
		$sql = "SELECT 
					js.*, 
					v.name as venue_name, 
					r.name as role_name 
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = js.role_id 
				WHERE js.job_id = '" . $job_id . "'
				AND js.status > " . SHIFT_DELETED;
		$status = $this->session->userdata('shift_status_filter');
		if ($status != '') {
			$sql .= " AND js.status = " . $status;
		}
		if ($job_date && $job_date != 'all')
		{
			$sql .= " AND js.job_date = '" . $job_date . "'";
		}
		if ($sort_key == 'date')
		{
			$sql .= " ORDER BY js.job_date " . $sort_value;
		}
		if ($sort_key == 'venue')
		{
			$sql .= " ORDER BY venue_name " . $sort_value;
		}
		if ($sort_key == 'role')
		{
			$sql .= " ORDER BY role_name " . $sort_value;
		}
		if ($sort_key == 'status')
		{
			$sql .= " ORDER BY js.status " . $sort_value;
		}
			
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function count_job_shifts($job_id, $job_date=null, $status=null)
	{
		$sql = "SELECT count(*) as `count`
				FROM `job_shifts`
				WHERE `job_id` = '$job_id' AND `status` > " . SHIFT_DELETED;
		if ($job_date)
		{
			$sql .= " AND `job_date` = '$job_date'";
		}
		if ($status != null)
		{
			$sql .= " AND `status` = '" . $status . "'";
		}
		$query = $this->db->query($sql);
		return $query->row()->count;
	}
	
	function get_job_dates($job_id)
	{
		$sql = "SELECT DISTINCT(`job_date`)
				FROM `job_shifts`
				WHERE `job_id` = '$job_id' AND `status` > " . SHIFT_DELETED . " ORDER BY `job_date` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_job_shift($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$query = $this->db->get('job_shifts');
		return $query->first_row('array');
	}
	
	
	function get_applied_staffs($shift_id)
	{
		$sql = "SELECT us.*, u.* 
				FROM user_staffs us, users u, job_shift_staff_apply js
				WHERE us.user_id = u.user_id
				AND u.user_id = js.staff_id
				AND js.shift_id='" . $shift_id . "'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	
	
	
	function delete_job_shifts($job_id)
	{
		$this->db->where('job_id', $job_id);
		return $this->db->delete('job_shifts');	
	}
	
	function delete_job_day_shift($job_id, $job_date)
	{
		$this->db->where('job_id', $job_id);
		$this->db->where('job_date', $job_date);
		return $this->db->delete('job_shifts');
	}
	
	/**
	*	@desc Function to get shifts based on their status 
	*
	*   @name get_shift_by_year_and_month
	*	@access public
	*	@param int month, int year 
	*	@return Returns array of avaliable roles
	*	
	*/
	
	function get_shift_by_year_and_month($month,$year,$status,$filters = null,$only_total = false)
	{
		$where_missing = true;
		$client_user_id = 0;
		if(isset($filters['client_user_id']) && $filters['client_user_id']){
			$client_user_id = $filters['client_user_id'];
		}
		$state_code = 0;
		if(isset($filters['state_code']) && $filters['state_code']){
			$state_code = $filters['state_code'];
		}
		$sql = "SELECT s.job_date,count(s.shift_id) AS total_shifts FROM job_shifts s";
		if($client_user_id && $client_user_id != 'all'){
			$sql .= " INNER JOIN jobs j 
					  ON s.job_id = j.job_id 
					  AND j.client_id = ".$client_user_id;	
			$where_missing = false;
		} 
		
		if($state_code && $state_code != 'all'){
			$sql .= " INNER JOIN attribute_venues av
					  ON s.venue_id = av.venue_id
					  AND av.state = '".$state_code."'";
			$where_missing = false;	
		}
		
		if($where_missing){
			$sql .= " WHERE s.shift_id != ''";	
		} 
		
				
		$sql .= " AND month(s.job_date) = '".$month."' AND year(s.job_date) = '".$year."'";
		switch($status){
			case 'active':
				$sql .= " AND s.status > " . SHIFT_DELETED;	
			break;
			case 'unassigned':
				$sql .= " AND s.status = " . SHIFT_UNASSIGNED;
			break;
			case 'unconfirmed':
				$sql .= " AND s.status = " . SHIFT_UNCONFIRMED;
			break;
			case 'rejected':
				$sql .= " AND s.status = " . SHIFT_REJECTED;
			break;
			case 'confirmed':
				$sql .= " AND s.status = " . SHIFT_CONFIRMED;
			break;
			case 'completed':
				$sql .= " AND s.status = " . SHIFT_FINISHED;
			break;	
		}
		
		if($only_total){
			$shift = $this->db->query($sql)->row();
			return $shift->total_shifts;
		}else{
			$sql .= " group by s.job_date order by s.job_date asc";
			$shifts = $this->db->query($sql)->result();
			return $shifts;
		}
	}
	
	function get_job_campaing_count_by_year_and_month($month,$year,$filters = null,$only_total = false)
	{
		$where_missing = true;
		$client_user_id = 0;
		if(isset($filters['client_user_id']) && $filters['client_user_id']){
			$client_user_id = $filters['client_user_id'];
		}
		$state_code = 0;
		if(isset($filters['state_code']) && $filters['state_code']){
			$state_code = $filters['state_code'];
		}
		$sql = "SELECT s.job_date,count(DISTINCT s.job_id) AS total_jobs FROM job_shifts s";
		if($client_user_id && $client_user_id != 'all'){
			$sql .= " INNER JOIN jobs j  
					  ON s.job_id = j.job_id 
					  AND j.client_id = ".$client_user_id;	
			$where_missing = false;
		}
		
		if($state_code && $state_code != 'all'){
			$sql .= " INNER JOIN attribute_venues av
					  ON s.venue_id = av.venue_id
					  AND av.state = '".$state_code."'";
			$where_missing = false;	
		}
		
		if($where_missing){
			$sql .= " WHERE s.shift_id != ''";	
		} 
			
		$sql .= " AND s.status > " . SHIFT_DELETED . " AND month(s.job_date) = '".$month."' AND year(s.job_date) = '".$year."'";
		
		if($only_total){
			$sql .= " GROUP BY s.job_id ORDER BY s.job_date asc";
			$jobs = $this->db->query($sql)->result();
			return count($jobs);
		}else{
			$sql .= " GROUP BY s.job_date ORDER BY s.job_date asc";
			$jobs = $this->db->query($sql)->result();
			return $jobs;
		}	
	}
	
	/**
	*	@name: add_brief
	*	@desc: Performs Database operation - add brief to shift
	*	@access: public
	*	@param: (array) brief info 
	*	@return: insert id
	*/
	function add_brief($data)
	{
		$this->db->insert('shift_brief',$data);
		return $this->db->insert_id();
	}
	
	/**
	*	@name: get_shift_briefs
	*	@desc: Performs Database operation - to get brief attached to a shift
	*	@access: public
	*	@param: ([int] shift id)
	*	@return: briefs attached to a shift
	*/
	function get_shift_briefs($shift_id)
	{
		$sql = "SELECT b.*, sb.shift_brief_id,sb.shift_id  
				FROM brief b, shift_brief sb 
				WHERE b.brief_id = sb.brief_id  
				AND sb.shift_id = ".$shift_id;
				
		return $this->db->query($sql)->result();
	}
	
	/**
	*	@name: delete_shift_brief
	*	@desc: Permanently removes a brief from a shift
	*	@access: public
	*	@param: ([int] shift_brief_id)
	*	@return: rows affected 
	*/
	function delete_shift_brief($shift_brief_id)
	{
		$this->db->where('shift_brief_id', $shift_brief_id);
		return $this->db->delete('shift_brief');
	}
	
	/**
	*	@name: delete_shift_brief
	*	@desc: Permanently removes a brief from a shift
	*	@access: public
	*	@param: ([int] shift_brief_id)
	*	@return: rows affected 
	*/
	function delete_shift_brief_by_shift_and_brief_id($shift_id,$brief_id)
	{
		$this->db->where('shift_id', $shift_id)
				 ->where('brief_id',$brief_id);
		return $this->db->delete('shift_brief');
	}
	
	/**
	*	@name: get_shift_brief_by_shift_and_brief_id
	*	@desc: Performs Database operation - to get brief attached to a shift by shift id and brief id
	*	@access: public
	*	@param: ([int] shift_id, brief_id )
	*	@return: Database result
	*/
	function get_shift_brief_by_shift_and_brief_id($shift_id,$brief_id)
	{
		$shift_brief = $this->db->where('shift_id',$shift_id)
						  		->where('brief_id',$brief_id)
						  		->get('shift_brief')
						  		->row();
		return $shift_brief;
	}
	
	/**
	*	@name: get_shift_brief_by_shift_id
	*	@desc: Performs Database operation - to get brief attached to a shift by shift id
	*	@access: public
	*	@param: ([int] shift_id )
	*	@return: List of shifts
	*/
	function get_shift_brief_by_shift_id($shift_id)
	{
		$sql = "SELECT b.* 
				FROM brief b,shift_brief sb
				WHERE b.brief_id = sb.brief_id
				AND sb.shift_id = ".$shift_id; 
		$shift_briefs = $this->db->query($sql)->result();
				
				
		return $shift_briefs;
	}
	/**
	*	@name: get_shift_info
	*	@desc: Performs Database operation - to get shift information - mostly used while populating shift info for brief viewer
	*	@access: public
	*	@param: ([int] shift_id )
	*	@return: Shift information
	*/
	function get_shift_info($shift_id)
	{
		$sql = "SELECT 
					js.*, 
					v.name as venue_name, 
					j.name as campaign_name 
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id
					LEFT JOIN `jobs` j ON j.job_id = js.job_id 
				WHERE js.shift_id = '" . $shift_id . "'";
		$shift_info = $this->db->query($sql)->row();
		
		return $shift_info;
			
	}
	
	/**
	*	@name: get_shift_info_for_information_sheet
	*	@desc: Performs Database operation - to get shift information - mostly used while populating shift info for shift information
	*	@access: public
	*	@param: ([int] shift_id )
	*	@return: Shift information
	*/
	function get_shift_info_for_information_sheet($shift_id)
	{
		$sql = "SELECT 
					js.*, 
					v.name as venue_name, 
					v.address as venue_address, 
					v.suburb as venue_suburb, 
					v.postcode as venue_postcode, 
					v.state as venue_state, 
					u.name as uniform_name,
					j.name as campaign_name,
					j.client_id, 
					r.name as role_name  
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id 
					LEFT JOIN `jobs` j ON j.job_id = js.job_id 
					LEFT JOIN `attribute_uniforms` u ON u.uniform_id = js.uniform_id 
					LEFT JOIN `attribute_roles` r ON r.role_id = js.role_id 
				WHERE js.shift_id = '" . $shift_id . "'";
		$shift_info = $this->db->query($sql)->row();
		
		return $shift_info;
			
	}
	
	function add_request_staff($data)
	{
		$this->db->insert('job_shift_client_request', $data);
		return $this->db->insert_id();
	}
	
	function get_request_staffs($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$query = $this->db->get('job_shift_client_request');
		return $query->result_array();
	}
	
	function remove_request($shift_id, $staff_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $staff_id);
		return $this->db->delete('job_shift_client_request');
	}
	
	function check_request_staff_shift($shift_id, $staff_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $staff_id);
		$query = $this->db->get('job_shift_client_request');
		return $query->num_rows();
	}
	
	/**
	*	@name: get_other_working_staff
	*	@desc: Performs Database operation - to get other staff working on that venue on the same date and within that time
	*	@access: public
	*	@param: ([obj] shift)
	*	@return: Staff ids working on that venue
	*/
	function get_other_working_staff($shift)
	{
		$sql = "SELECT staff_id 
				FROM job_shifts 
				WHERE job_id = ".$shift->job_id." 
				AND job_date = '".$shift->job_date."' 
				AND venue_id = ".$shift->venue_id."
				AND staff_id != ".$shift->staff_id."
				AND (start_time >= '".$shift->start_time."' AND finish_time <= '".$shift->finish_time."')";
		return $this->db->query($sql)->result();
	}
	/**
	*	@name: add_note
	*	@desc: Add new note to a shift
	*	@access: public
	*	@param: ([array] shift id, note, creater user id)
	*	@return: Insert id
	*/
	function add_note($data) 
	{
		$this->db->insert('job_shift_notes',$data);
		return $this->db->insert_id();
	}
	/**
	*	@name: get_job_shift_notes
	*	@desc: Performs Database operation - to get shift notes
	*	@access: public
	*	@param: ([int] shift_id )
	*	@return: Shift Notes
	*/
	function get_job_shift_notes($shift_id)
	{
		$shift_notes = $this->db->where('shift_id',$shift_id)
								->order_by('created','desc')
								->get('job_shift_notes')
								->result();
		return $shift_notes;
	}
	/**
	*	@name: delete_note
	*	@desc: Performs Database operation - to delete shift note
	*	@access: public
	*	@param: ([int] job_shift_note_id )
	*	@return: Shift Notes
	*/
	function delete_note($job_shift_note_id)
	{
		return $this->db->where('job_shift_note_id',$job_shift_note_id)->delete('job_shift_notes');
	}
	
}