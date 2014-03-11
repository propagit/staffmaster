<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Forum
 * @author: namnd86@gmail.com
 */

class Forum extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('forum_model');
		$this->load->model('attribute/group_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			
			case 'load_converation':
				$this->load_converation();
			break;
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		
	}
	
	function load_converation()
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['conversations'] = $this->forum_model->get_conversations($user);
		$this->load->view('conversations', isset($data) ? $data : NULL);
	}
	
	
}