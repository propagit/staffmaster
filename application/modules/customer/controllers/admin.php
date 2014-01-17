<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index($method='')
	{
		switch($method)
		{
			default:
					$this->products_list();
				break;
		}
	}
	
	function products_list()
	{
		$this->load->view('distributor/distributors_list');
	}
		
}