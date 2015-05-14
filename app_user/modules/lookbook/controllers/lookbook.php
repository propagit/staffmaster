<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Lookbook
 *	@controller: Lookbook
 */

class Lookbook extends MX_Controller {
	var $user = null;

	function __construct() {
		parent::__construct();
	
		$this->user = $this->session->userdata('user_data');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view()
	{
		$this->load->view('main_view', isset($data) ? $data : NULL);	
	}
}