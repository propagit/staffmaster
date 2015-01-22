<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup_model extends CI_Model {

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

	function create_tables($subdomain)
	{
		# Load schema.sql file as string
		if( $sql = @file_get_contents('./../db/setup_schema.sql') )
		{
			return $this->import_sql($subdomain, $sql);
		}
	}

	function create_account($account)
	{
		$this->init($account['subdomain']);
		$this->db->where('email_address', $account['email_address']);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0)
		{
			return true;
		}

		// Create super admin account
		$admin = array(
			'status' => 1,
			'is_admin' => 1,
			'is_staff' => 0,
			'is_client' => 0,
			'email_address' => 'team@staffbooks.com',
			'username' => 'team@staffbooks.com',
			'password' => md5('staffb00ks')
		);
		$this->db->insert('users', $admin);

		$user_data = array(
			'status' => 1,
			'is_admin' => 1,
			'is_staff' => 1,
			'is_client' => 0,
			'email_address' => $account['email_address'],
			'username' => $account['email_address'],
			'password' => $account['password']
		);
		
		# if the new fields first name, last name and phone exist set them and pass them to welcome email
		if($account['first_name'] && $account['last_name'] && $account['phone'] && $account['package']){
			$user_data['first_name'] = $account['first_name'];
			$user_data['last_name'] = $account['last_name'];
			$user_data['phone'] = $account['phone'];
		}
		
		$this->db->insert('users', $user_data);
		$user_id = $this->db->insert_id();
		$this->db->insert('company_profile', array(
			'company_name' => $account['company_name']
		));
		return $this->db->insert('user_staffs', array(
			'user_id' => $user_id
		));

	}

	function import_sql($subdomain, $sql)
	{
		$this->init($subdomain);
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

	function get_monthly_usage($subdomain, $month)
	{
		$this->init($subdomain);
		$sql = "SELECT count(*) as `usage`
				FROM job_shifts
				WHERE status != -2
				AND job_date LIKE '$month%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		return $result['usage'];
	}

	function minimum_usage($subdomain, $month)
	{
		$this->init($subdomain);

		$sql = "SELECT count(*) as `usage`
				FROM job_shifts
				WHERE status != -2
				AND job_date LIKE '$month%'";
		$query = $this->db->query($sql);
		$result = $query->first_row('array');
		$usage = $result['usage'];
		if ($usage < 25)
		{
			$deducted = 25 - $usage;
			$sql = "UPDATE `account` SET `system_credits`= `system_credits` - $deducted";
			$this->db->query($sql);
		}
	}
}
