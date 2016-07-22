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

	function get_subdomains($receiver) {
		$sql = "SELECT DISTINCT subdomain FROM sms_requests WHERE receiver = '$receiver'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_request($receiver, $code) {
		$this->db->where('receiver', $receiver);
		$this->db->where('code', $code);
		$this->db->where('processed', 0);
		$query = $this->db->get('sms_requests');
		return $query->first_row('array');
	}

	function get_unprocess_request() {
		$sql = "SELECT r1.request_id, r1.subdomain, r1.shift_id, r1.user_id,
						r2.response_id, r2.sender, r2.msg, r2.answer
					FROM sms_requests r1, sms_responses r2
					WHERE r1.code = r2.code AND r1.processed = 0 AND r2.processed = 0 AND r1.receiver = r2.sender";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function update_request($request_id, $data) {
		$this->db->where('request_id', $request_id);
		return $this->db->update('sms_requests', $data);
	}

	function update_response($response_id, $data) {
		$this->db->where('response_id', $response_id);
		return $this->db->update('sms_responses', $data);
	}

}
