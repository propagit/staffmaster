<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function create_topic_form() {
		$this->load->view('create_topic_form', isset($data) ? $data : NULL);
	}
	
}