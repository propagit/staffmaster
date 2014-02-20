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
	
	function staff() {
		$this->session->set_userdata('force_staff', true);
		redirect('');
	}
	
	function is_staff()
	{
		return $this->session->userdata('force_staff');
	}
	
	function admin() {
		$this->session->unset_userdata('force_staff');
		redirect('');
	}
	
	
}