<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends MX_Controller {
	/**
	*	@class_desc Support Controller 
	*	
	*
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->model('forum/forum_model');
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
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	
}