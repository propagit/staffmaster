<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Account
 * @author: namnd86@gmail.com
 */

class Account extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function staff() {
		$this->session->set_userdata('force_staff', true);
		redirect('');
	}
	
	function admin() {
		$this->session->unset_userdata('force_staff');
		redirect('');
	}
	
}