<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	
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
	
	function get_account($params)
	{
		foreach($params as $key => $value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get('accounts');
		return $query->first_row('array');
	}
	
	function create_account($data)
	{
		$this->db->insert('accounts', $data);
		return $this->db->insert_id();
	}
	
	function activate_account($account_id)
	{
		$this->db->where('account_id', $account_id);
		return $this->db->update('accounts', array(
			'status' => ACCOUNT_ACTIVE,
			'activation_code' => null,
			'activated_on' => date('Y-m-d H:i:s')
		));
	}
	
}