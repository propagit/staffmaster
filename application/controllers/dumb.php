<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@name: Dumb
 *	@desc: dumb data for testing
 *	@author: namnd86@gmail.com
 */

class Dumb extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');
		$this->load->helper('string');
	}
	
	function index()
	{
		die('dasd');
	}
		
	function staff($qty=1)
	{
		$timestamp_batch = time();
		for($i=0; $i < $qty; $i++)
		{
			$user_data = array(
				'status' => 1,
				'is_admin' => 0,
				'is_staff' => 1,
				'is_client' => 0,
				'access_level' => 0,
				'email_address' => 'staff' . ($i + 1) . '_' . $timestamp_batch. '@gmail.com',
				'username' => 'staff' . ($i + 1) . '_' . $timestamp_batch,
				'password' => md5('123456'),
				'title' => 'Mr',
				'first_name' => ucwords(random_string('alpha', 4)),
				'last_name' => ucwords(random_string('alpha', 7)),
				'address' => rand(1,3) . ' ' . ucwords(random_string('alpha', 10)) . ' Street',
				'suburb' => 'Melbourne CBD',
				'city' => 'Melbourne',
				'state' => 'VIC',
				'postcode' => '3000',
				'phone' => '04' . random_string('numeric', 8),
				'country' => 'AU'				
			);
			$user_id = $this->user_model->insert_user($user_data);
			$staff_data = array(
				'user_id' => $user_id,
				'gender' => 'm'
			);
			$this->staff_model->insert_staff($staff_data);
		}
	}

}