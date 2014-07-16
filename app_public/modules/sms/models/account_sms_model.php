<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_sms_model extends CI_Model {
	
	function init($subdomain)
	{
		$db['hostname'] = DB_HOSTNAME;
		$db['username'] = DB_USERNAME;
		$db['password'] = DB_PASSWORD;
		$db['database'] = USER_PREFIX_DB . $subdomain;
		$db['dbdriver'] = 'mysql';
		$db['dbprefix'] = '';
		$db['pconnect'] = TRUE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = '';
		$db['char_set'] = 'latin1';
		$db['dbcollat'] = 'latin1_bin';
		$db['swap_pre'] = '';
		$db['autoinit'] = TRUE;
		$db['stricton'] = FALSE;
		
		//$this->db = $this->load->database($db);
		$this->load->database($db, FALSE, TRUE);
		# False: don't return db object
		# True: use as active record, so it replaces default $this->db
	}
	
	function get_job_shift($subdomain, $shift_id)
	{
		$this->init($subdomain);
		$this->db->where('shift_id', $shift_id);
		$query = $this->db->get('job_shifts');
		return $query->first_row('array');
	}
		
	function update_job_shift($subdomain, $shift_id, $staff_id, $status)
	{
		$this->init($subdomain);
		$this->db->where('shift_id', $shift_id);
		$this->db->where('staff_id', $staff_id);
		return $this->db->update('job_shifts', array(
			'status' => $status
		));
	}
	
	function get_sms_template($subdomain, $template_id)
	{
		$this->init($subdomain);
		$this->db->where('template_id', $template_id);
		$query = $this->db->get('sms_templates');
		return $query->first_row('array');
	}
	
	function get_company($subdomain)
	{
		$this->init($subdomain);
		$this->db->where('id', 1);
		$query = $this->db->get('company_profile');
		return $query->first_row('array');
	}
}