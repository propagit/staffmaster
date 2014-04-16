<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Account
 * @author: namnd86@gmail.com
 */

class Account_client extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		
		switch($method)
		{
			default:
					echo modules::run('client/edit_client', $this->user['user_id']);			
				break;
		}
	}
	
}