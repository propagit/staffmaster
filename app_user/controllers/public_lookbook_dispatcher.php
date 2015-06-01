<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Public_lookbook_dispatcher
 * @author: kaushtuvgurung@gmail.com
 */

class Public_lookbook_dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('setting/setting_model');
		$this->load->model('lookbook/lookbook_model');
		$this->load->model('staff/staff_model');
		$this->load->model('user/user_model');
		$this->load->model('attribute/custom_field_model');
		error_reporting(E_ALL);
	}
	
	
	function list_lookbook($key)
	{		
		$lookbook = modules::run('lookbook/get_lookbook_by_key',$key);
		$content = '';
		
		if($lookbook){
			$config_custom = '';
			$config_personal = '';
			if($lookbook){
				$staff = json_decode($lookbook['included_user_ids']);
				$config_personal = $lookbook['personal_fields'];
				$config_custom = $lookbook['custom_fields'];
			}
			
			foreach($staff as $s){	
				$content .= modules::run('lookbook/get_staff_card_public_view',$s,$config_personal,$config_custom,$lookbook['receiver_user_id']); 
			}
		}
		
		
		$this->template->set_template('public_lookbook');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'StaffBooks ');
		$this->template->write_view('menu', 'public/lookbook/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	function preview($selected_staffs)
	{
		$staff = array();
		$content = '';
		if($selected_staffs){
			$staff = explode('-',$selected_staffs);	
			$config_personal = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
			$config_custom = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);	
			
			
			foreach($staff as $s){	
				$content .= modules::run('lookbook/get_staff_card_public_view',$s,$config_personal,$config_custom); 
			}
		}
		
		
		$this->template->set_template('public_lookbook');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'StaffBooks ');
		$this->template->write_view('menu', 'public/lookbook/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	function update_like_status()
	{
		$input = $this->input->post();
		echo modules::run('lookbook/update_lookbook_liked_status',$input['client_user_id'],$input['staff_user_id']);
	}
	
}