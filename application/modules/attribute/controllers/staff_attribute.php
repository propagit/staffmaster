<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: kaushtuv
 */

class Staff_attribute extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_attribute_model');
	}
	
	function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_staff_attribute();
				break;

			default:
					$this->add_staff_attribute();
				break;
		}
	}
	
	function add_staff_attribute()
	{
		$this->load->view('add_staff_attribute', isset($data) ? $data : NULL);	
	}
	
	
	
}