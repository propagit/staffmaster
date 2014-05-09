<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: roster controller for staff
*/

class Roster extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('roster_model');
	}
	
	function index($method='', $param='') {
		if (!modules::run('auth/is_staff'))
		{
			echo modules::run('auth/staff_protected_view', 'roster');
			return;
		}
		switch($method)
		{
			
			default:
					$this->get_roster_email($param);
				break;
		}
		
	}
	
	function get_roster_email($user_id)
	{
		$active_month = date('Y-m');
		$data['rosters'] = $this->roster_model->get_user_rosters_by_month($user_id,$active_month);
		$this->load->view('email/email_roster_table', isset($data) ? $data : NULL);	
	}
		
}