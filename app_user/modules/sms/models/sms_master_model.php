<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_master_model extends CI_Model {
	
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
	
	function get_largest_code()
	{
		$this->init();
		
		$this->db->where('processed', 0);
		$this->db->order_by('code', 'desc');
		$query = $this->db->get('sms_requests');
		$result = $query->first_row('array');
		if ($result) {
			$result = $result['code'];
		} else {
			$result = 0;
		}	
			
		$this->close();
		
		return $result + 1;
	}
	
	function insert_request($data)
	{
		$this->init();
		
		$this->db->insert('sms_requests', $data);
		$request_id = $this->db->insert_id();
		
		$this->close();
		
		return $request_id;
	}
}