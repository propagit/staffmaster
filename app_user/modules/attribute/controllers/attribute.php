<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Attribute
 * @author: namnd86@gmail.com
 */

class Attribute extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index($method='', $param1='', $param2='')
	{
		echo modules::run('attribute/' . $method . '/index', $param1, $param2);
	}	
	
}