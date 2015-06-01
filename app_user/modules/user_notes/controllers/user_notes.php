<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: kaushtuvgurung@gmail.com
 */

class User_notes extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_notes_model');
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
		$data['user'] = $this->session->userdata('user_data');	
		
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function get_user_notes($user_id)
	{
		$data['user_notes'] = $this->user_notes_model->get_user_notes($user_id);
		echo $this->load->view('list_view',isset($data) ? $data : NULL,true);	
	}
	
	function get_user_notes_by_admin_id_and_date($user_id,$admin_id,$date){
		return $this->user_notes_model->get_user_notes_by_admin_id_and_date($user_id,$admin_id,$date);	
	}

	
}