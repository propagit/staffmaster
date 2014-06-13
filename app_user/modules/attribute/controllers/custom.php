<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Custom extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
	}
	
	function main_view()
	{
		$this->load->view('custom/main_view', isset($data) ? $data : NULL);
	}
	
}