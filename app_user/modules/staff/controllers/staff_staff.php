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
			case 'upload_custom_document':
					modules::run('staff/upload_custom_document');
				break;	
			case 'delete_custom_document':
					modules::run('staff/delete_custom_document',$param);
				break;						
			default:
					$this->edit_staff();
			break;
		}
	}
	
	
	
	function edit_staff()
	{		
		$data['staff'] = $this->staff_model->get_staff($this->user_id);		
		$this->load->view('edit_form', isset($data) ? $data :NULL);
	}
	
	
	
}