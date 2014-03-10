<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Forum
 * @author: namnd86@gmail.com
 */

class Forum extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		
	}
	
}