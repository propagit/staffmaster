<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model {
	
	function __construct()
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
		
		$this->load->database($db, FALSE, TRUE);
		# False: don't return db object
		# True: use as active record, so it replaces default $this->db
	}
	
	function insert_response($data) {
		$this->db->insert('sms_responses', $data);
		return $this->db->insert_id();
	}
	
	function get_request($receiver, $code) {
		$this->db->where('receiver', $receiver);
		$this->db->where('code', $code);
		$this->db->where('processed', 0);
		$query = $this->db->get('sms_requests');
		return $query->first_row('array');
	}
	
	function update_request($request_id, $data) {
		$this->db->where('request_id', $request_id);
		return $this->db->update('sms_requests', $data);
	}
	
}