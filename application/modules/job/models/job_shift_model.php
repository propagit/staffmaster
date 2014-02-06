<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_shift_model extends CI_Model {
	
	function insert_job_shift($data)
	{
		$this->db->insert('job_shifts', $data);
		return $this->db->insert_id();
	}
	
	function update_job_shift($shift_id, $data = array())
	{
		if (count($data) > 0)
		{
			$data['modified_on'] = date('Y-m-d H:i:s');
		}
		$this->db->where('shift_id', $shift_id);
		return $this->db->update('job_shifts', $data);
	}	
	
	function delete_job_shift($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		return $this->db->update('job_shifts', array('status' => -1));
	}
	
	function delete_job_day_shift($job_id, $job_date)
	{
		$this->db->where('job_id', $job_id);
		$this->db->where('job_date', $job_date);
		return $this->db->update('job_shifts', array('status' => -1));
	}
	
	function search_shifts($data, $sort_key='date', $sort_value='asc')
	{
		$sql = "SELECT js.*, j.name as job_name, j.client_id, v.name as venue_name, r.name as role_name
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = js.role_id
					LEFT JOIN `jobs` j ON j.job_id = js.job_id
				WHERE js.status > -2";
		if ($data['date_from'])
		{
			$sql .= " AND js.job_date >= '" . date('Y-m-d', strtotime($data['date_from'])) . "'";
		}
		if ($data['date_to'])
		{
			$sql .= " AND js.job_date <= '" . date('Y-m-d', strtotime($data['date_to'])) . "'";
		}
		if ($data['client_id'])
		{
			$sql .= " AND j.client_id = '" . $data['client_id'] . "'";
		}
		if ($data['venue'])
		{
			$sql .= " AND v.name LIKE '%" . $data['venue'] . "%'";
		}
		if ($data['role_id'])
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
	
	function get_job_shifts($job_id, $job_date=null, $sort_key='date', $sort_value='asc')
	{
		$sql = "SELECT js.*, v.name as venue_name, r.name as role_name 
				FROM `job_shifts` js
					LEFT JOIN `attribute_venues` v ON v.venue_id = js.venue_id
					LEFT JOIN `attribute_roles` r ON r.role_id = js.role_id 
				WHERE js.job_id = '" . $job_id . "'
				AND js.status != -1";
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
				WHERE `job_id` = '$job_id' AND `status` != -1";
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
				WHERE `job_id` = '$job_id' AND `status` != -1 ORDER BY `job_date` ASC";
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
}