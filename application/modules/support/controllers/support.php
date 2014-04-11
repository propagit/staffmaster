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
		$this->load->model('support_model');
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
	
	/**
	*	@name: load_support_tickets
	*	@desc: Loads the most recent support requests
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns most recent supports
	*/
	function load_support_tickets()
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['support_tickets'] = $this->support_model->get_support($user);
		$this->load->view('support_tickets', isset($data) ? $data : NULL);
	}
	
	
}