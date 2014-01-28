<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Formbuilder extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{		
			default:
				$this->home();
			break;
			
		}
	}
	
	function home()
	{
		$this->load->view('home');	
	}
	
}