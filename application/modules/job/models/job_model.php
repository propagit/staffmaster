<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_model extends CI_Model {
	
	function insert_job($data)
	{
		$this->db->insert('jobs', $data);
		return $this->db->insert_id();
	}
	
	function get_job($job_id)
	{
		$this->db->where('job_id', $job_id);
		$query = $this->db->get('jobs');
		return $query->first_row('array');
	}
	
	function all_jobs() {
		$query = $this->db->get('jobs');
		return $query->result_array();
	}
	
	function count_active_jobs()
	{
		$sql = "SELECT *
					FROM job_shifts 
					WHERE status > " . SHIFT_DELETED . "
					AND status < " . SHIFT_FINISHED . "
					GROUP BY job_id";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	function search_jobs($data = array())
	{
		# Select the job id that has shifts in selected date range
		$sql_select_job_id = "SELECT job_id FROM job_shifts
								WHERE status > " . SHIFT_DELETED;
		if ($data['date_from'])
		{
			$sql_select_job_id .= " AND (start_time >= " . strtotime($data['date_from']);
			$sql_select_job_id .= " OR finish_time >= " . strtotime($data['date_from']) . ")";
		}
		if ($data['date_to'])
		{
			$sql_select_job_id .= " AND (start_time <= " . strtotime($data['date_to']);
			$sql_select_job_id .= " OR finish_time <= " . strtotime($data['date_to']) . ")";
		}
		$sql_select_job_id .= " GROUP BY job_id";
		
		/* 
		$sql_select_job_id = "SELECT job_id FROM job_shifts WHERE status > " . SHIFT_DELETED . " GROUP BY job_id";
		if ($data['date_from'])
		{
			$sql_select_job_id .= " HAVING MIN(start_time) >= " . strtotime($data['date_from']);
		}
		if ($data['date_to'])
		{
			if ($data['date_from'])
			{
				$sql_select_job_id .= " AND MAX(finish_time) <= " . strtotime($data['date_to']);
			}
			else
			{
				$sql_select_job_id .= " HAVING MAX(finish_time) <= " . strtotime($data['date_to']);
			}			
		}
		*/
		
		$sql = "SELECT * FROM jobs WHERE job_id IN ($sql_select_job_id)";
		if ($data['client_id'])
		{
			$sql .= " AND client_id = " . $data['client_id'];
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_job_start_date($job_id)
	{
		$sql = "SELECT MIN(`start_time`) as `start_time` 
					FROM `job_shifts` 
					WHERE `job_id` = " . $job_id . " 
					AND status > " . SHIFT_DELETED;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		return $result['start_time'];
	}
	function get_job_finish_date($job_id)
	{
		$sql = "SELECT MAX(`finish_time`) as `finish_time` 
					FROM `job_shifts` 
					WHERE `job_id` = " . $job_id . " 
					AND status > " . SHIFT_DELETED;
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		return $result['finish_time'];
	}
	
	
	function delete_job($job_id)
	{
		$this->db->where('job_id', $job_id);
		return $this->db->delete('jobs');
	}
}