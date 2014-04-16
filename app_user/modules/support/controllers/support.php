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
			case 'admin_support':
				$this->admin_support();
			break;
			
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
	/**
	*	@name: admin_support
	*	@desc: Provides UI to lodge support ticket by the admin. This support will be sent to StaffMaster support staff and is completely different from the support ticket lodged from Client or Staff portal.
	*	@access: public
	*	@param: (null)
	*	@return: Loads Support ticket UI for admin
	*/
	function admin_support()
	{
		$this->load->view('admin_support', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: email_templates_dropdown
	*	@desc: 
	*	@access: public
	*	@param: 
	*/
	function support_type_dropdown($field_name, $field_value=null, $size=null)
	{
		$support_types = array('System Help','Function Request','Bug Notification','General Support');
		$count = 0;
		if($support_types){
			foreach($support_types as $key=>$val){
				  $array[$count] = array('value' => $val, 'label' => $val);
				  $count++;
			}
		}
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function load_admin_support_email_body($data)
	{
		$this->load->view('email/email_message', isset($data) ? $data : NULL);	
	}
	
	
}