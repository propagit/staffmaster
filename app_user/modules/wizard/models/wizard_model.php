<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wizard_model extends CI_Model {
		
	function check_company_profile()
	{
		$query = $this->db->get('company_profile');
		$result = $query->first_row('array');
		return $result['address'] != ''
			&& $result['abn_acn'] != '';
	}
	
	function check_has_staff()
	{
		$this->db->where('is_staff', 1);
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		return $query->num_rows() > 1;
	}
	
	function check_has_client()
	{
		$this->db->where('is_client', 1);
		$this->db->where('status', 1);
		$query = $this->db->get('users');
		return $query->num_rows() > 0;
	}
	
	function check_has_payrate()
	{
		$query = $this->db->get('attribute_payrates');
		return $query->num_rows() > 0;
	}
	
	function check_has_venue()
	{
		$query = $this->db->get('attribute_venues');
		return $query->num_rows() > 0;
	}
	
	function check_has_role()
	{
		$query = $this->db->get('attribute_roles');
		return $query->num_rows() > 0;
	}
	
	function check_has_uniform()
	{
		$query = $this->db->get('attribute_uniforms');
		return $query->num_rows() > 0;
	}
	
	function check_has_job()
	{
		$query = $this->db->get('job_shifts');
		return $query->num_rows() > 0;
	}
}