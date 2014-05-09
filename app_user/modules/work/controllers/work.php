<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: controller handle apply for work by staff
*/

class Work extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($method='', $param='') {
		if (!modules::run('auth/is_staff'))
		{
			echo modules::run('auth/staff_protected_view', 'work');
			return;
		}
		
	}
	
}