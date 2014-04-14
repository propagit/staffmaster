<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function select_distributor()
	{
		$this->session->set_userdata('order_distributor', $_POST['name']);
	}
	
	function select_order_type()
	{
		$this->session->set_userdata('order_type', $_POST['type']);
	}
		
}