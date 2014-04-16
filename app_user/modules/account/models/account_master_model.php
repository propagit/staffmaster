<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_master_model extends CI_Model {
	
	function init()
	{
		$db['hostname'] = DB_HOSTNAME;
		$db['username'] = DB_USERNAME;
		$db['password'] = DB_PASSWORD;
		$db['database'] = MASTER_DB;
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
		
		#$this->load->database($db, FALSE, TRUE);
		$this->load->database($db, FALSE, TRUE);
		# False: don't return db object
		# True: use as active record, so it replaces default $this->db
	}
	
	function close()
	{
		$sub_domain = array_shift(explode(".",$_SERVER['HTTP_HOST']));
		$db['hostname'] = DB_HOSTNAME;
		$db['username'] = DB_USERNAME;
		$db['password'] = DB_PASSWORD;
		$db['database'] = USER_PREFIX_DB . $sub_domain; #'staff_master';
		$db['dbdriver'] = 'mysql';
		$db['dbprefix'] = '';
		$db['pconnect'] = TRUE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = '';
		$db['char_set'] = 'utf8';
		$db['dbcollat'] = 'utf8_general_ci';
		$db['swap_pre'] = '';
		$db['autoinit'] = TRUE;
		$db['stricton'] = FALSE;
		$this->load->database($db, FALSE, TRUE);
	}
	
	function get_prices()
	{
		$this->init();
		$query = $this->db->get('prices');
		$results = $query->result_array();
		$this->close();
		return $results;
	}
	
	function get_price($credits)
	{
		$this->init();
		$this->db->where('min <=', $credits);
		$this->db->where('max >=', $credits);
		$query = $this->db->get('prices');
		$result = $query->first_row('array');
		$this->close();
		return $result;
	}
			
	function get_account($subdomain)
	{
		$this->db->where('subdomain', $subdomain);
		$query = $this->db->get('accounts');
		return $query->first_row('array');
	}
	
	function update_account($account_id, $data)
	{
		
	}
}