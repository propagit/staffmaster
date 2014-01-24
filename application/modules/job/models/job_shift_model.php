<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_shift_model extends CI_Model {
	
	function insert_job_shift($data)
	{
		$this->db->insert('job_shifts', $data);
		return $this->db->insert_id();
	}
	
	function get_job_shifts($job_id, $job_date=null)
	{
		$this->db->where('job_id', $job_id);
		if ($job_date)
		{
			$this->db->where('job_date', $job_date);
		}
		$this->db->where('status', 0);
		$query = $this->db->get('job_shifts');
		return $query->result_array();
	}
	
	function count_job_shifts($job_id, $job_date=null)
	{
		$sql = "SELECT count(*) as `count`
				FROM `job_shifts`
				WHERE `job_id` = '$job_id' AND `status` = 0";
		if ($job_date)
		{
			$sql .= " AND `job_date` = '$job_date'";
		}
		$query = $this->db->query($sql);
		return $query->row()->count;
	}
	
	function get_job_dates($job_id)
	{
		$sql = "SELECT DISTINCT(`job_date`)
				FROM `job_shifts`
				WHERE `job_id` = '$job_id' AND `status` = 0 ORDER BY `job_date` ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_job_shift($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$this->db->where('status', 0);
		$query = $this->db->get('job_shifts');
		return $query->first_row('array');
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
}