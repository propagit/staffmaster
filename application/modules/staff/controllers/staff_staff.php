<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Profile
 * @author: namnd86@gmail.com
 */

class Staff_staff extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();		

		$this->load->model('staff_model');
		$user = $this->session->userdata('user_data');
		$this->user_id = $user['user_id'];
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{							
			default:
					$this->edit_staff();
			break;
		}
	}
	
	
	
	function edit_staff()
	{		
		$data['staff'] = $this->staff_model->get_staff($this->user_id);
		$data['staff_account']=1;
		$this->load->view('edit_form', isset($data) ? $data :NULL);
	}
	
	
	
}