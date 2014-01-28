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
	
	function search_jobs($data = array())
	{
		if ($data['client_id'])
		{
			$this->db->where('client_id', $data['client_id']);
		}
		$query = $this->db->get('jobs');
		return $query->result_array();
	}
}