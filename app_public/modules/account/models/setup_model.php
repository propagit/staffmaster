<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_model extends CI_Model {
	
	function init($username)
	{
		$db['hostname'] = DB_HOSTNAME;
		$db['username'] = DB_USERNAME;
		$db['password'] = DB_PASSWORD;
		$db['database'] = USER_PREFIX_DB . $username;
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
		
	function create_tables($username)
	{
		# Load schema.sql file as string
		if( $sql = @file_get_contents('./../db/setup_schema.sql') )
		{
			return $this->import_sql($username, $sql);
		} 
	}
	
	function create_account($account)
	{
		$this->init($account['username']);
		$this->db->where('username', $account['username']);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)
		{
			return true;
		}
		
		$user_data = array(
			'status' => 1,
			'is_admin' => 1,
			'is_staff' => 1,
			'is_client' => 0,
			'email_address' => $account['email_address'],
			'username' => $account['username'],
			'password' => $account['password']
		);
		$this->db->insert('users', $user_data);
		$user_id = $this->db->insert_id();
		
		return $this->db->insert('user_staffs', array('user_id' => $user_id));
	}
	
	function import_sql($username, $sql)
	{
		$this->init($username);
		# Get the db connection platform
		$platform = $this->db->platform();
		
		# If mysqli or mysql
		if( $platform == 'mysqli' || $platform == 'mysql' )
		{
			# Break the sql file into separate queries
			$queries = explode( ';', $sql );
			
			# Do each query
			foreach( $queries as $query )
			{
				$this->db->simple_query( trim( $query ) );
			}
			
			return true;
		}
		
		# If not mysqli or mysql
		else
		{
			return false; # Database Platform Not Supported!
		}
	}
}