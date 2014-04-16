<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Account
 * @author: namnd86@gmail.com
 */

class Account extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('user_data');
	}
	
	
	function menu($user=array())
	{
		$data['user'] = $this->user;
		$this->load->view('account_menu', isset($data) ? $data : NULL);
	}
	
	
	
	function box_credits()
	{
		$this->load->view('box_credits', isset($data) ? $data : NULL);
	}
	
}