<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Lookbook
 *	@controller: Lookbook
 */

class Lookbook extends MX_Controller {
	

	function __construct() {
		parent::__construct();
		$this->load->model('staff/staff_model');
		$this->load->model('user/user_model');
		$this->load->model('lookbook_model');
		$this->load->model('attribute/custom_field_model');
		$this->load->model('client/client_favourite_staff_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'preview':
					$this->preview();
				break;
			case 'test':
					$this->test($param);
				break;
			
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view()
	{
		#$this->load->view('main_view', isset($data) ? $data : NULL);	
	}
	
	function get_lookbook_by_key($key)
	{
		return $this->lookbook_model->get_lookbook_by_key($key);	
	}
	
	function get_staff_card_config_view($staff_user_id)
	{
		$config_personal = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
		$config_custom = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
		$this->get_staff_card($staff_user_id,$config_personal,$config_custom);	
	}
	
	function get_staff_card($staff_user_id,$config_personal,$config_custom)
	{
		$data['config_personal'] = $config_personal;
		$data['config_custom'] = $config_custom;
		$data['staff'] = $this->staff_model->get_staff_with_age_group($staff_user_id);
		$data['staff_custom'] = $this->staff_model->get_custom_fields($staff_user_id);
		$data['photo'] = $this->staff_model->get_hero($staff_user_id);
		
		echo $this->load->view('staff/card_view', isset($data) ? $data : NULL, true);
	}
	
	function get_staff_card_public_view($staff_user_id,$config_personal,$config_custom,$client_user_id = '')
	{
		$data['config_personal'] = $config_personal;
		$data['config_custom'] = $config_custom;
		$data['staff'] = $this->staff_model->get_staff_with_age_group($staff_user_id);
		$data['staff_custom'] = $this->staff_model->get_custom_fields($staff_user_id);
		$data['photo'] = $this->staff_model->get_hero($staff_user_id);
		$data['client_user_id'] = $client_user_id;
		
		return $this->load->view('staff/card_view', isset($data) ? $data : NULL, true);
	}
	
	function email_modal()
	{
		$data['config_personal'] = $this->lookbook_model->get_lookbook_config(LB_PERSONAL);
		$data['config_custom'] = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
		$data['config_message'] = $this->lookbook_model->get_lookbook_config(LB_MESSAGE);
		$this->load->view('email/modal_view', isset($data) ? $data : NULL);	
	}
	
	
	function _test($lookbook_id)
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		$lookbook = $this->lookbook_model->get_lookbook_by_id($lookbook_id);
		
		# get company profile
		$company = $this->setting_model->get_profile();	
	
		
		$data['email_body'] = $this->lookbook_model->get_lookbook_config(LB_MESSAGE);
		$company_email = $company['email'] ? $company['email'] : $company['email_c_email'];
		$data['styles'] = array(
							'primary_colour' => COLOUR_PRIM,
							'rollover_colour' => COLOUR_ROLL,
							'secondary_colour' => COLOUR_SECO,
							'text_colour' => TEXT_COLOUR
							);
		$current_styles = $this->setting_model->get_system_styles(1);
		if($current_styles){
			$data['styles'] = $current_styles;	
		}
		$data['url'] = base_url() .'plb/' . $lookbook['key'];
		$lookbook_email = $this->load->view('email/email_template', isset($data) ? $data : NULL, true);


		$email_signature = modules::run('setting/get_email_footer');
		$message = $lookbook_email . $email_signature;
	
		
		$email_data = array(
								'to' => $lookbook['receiver_email'],
								'from' => $company_email ? $company_email : 'noreply@staffbook.com',
								'from_text' => 'StaffBook',
								'subject' => $company['company_name'] . ' - StaffBooks',
								'message' => $message,
								'overwrite' => true
							);
		print_r($email_data);
		
		#modules::run('email/send_email_localhost',$email_data);		
	}
	
	function is_liked_by_client($client_user_id,$staff_user_id)
	{
		return $this->client_favourite_staff_model->is_liked($client_user_id,$staff_user_id);	
	}
	
	function update_lookbook_liked_status($client_user_id,$staff_user_id)
	{
		$result = $this->client_favourite_staff_model->get($client_user_id,$staff_user_id);
		if($result){
			# update
			$update_data = array(
										'status' => $result['status'] == STAFF_LIKED ? 0 : STAFF_LIKED,
										'updated' => date('Y-m-d H:i:s')
									);
			$this->client_favourite_staff_model->update($client_user_id,$staff_user_id,$update_data);
			return json_encode(array('liked' => $result['status'] == STAFF_LIKED ? 'no' : 'yes'));	
		}else{
			# since the database starts with emplty record
			# if there no data it implies the a staff has been liked
			$data = array(
							'client_user_id' => $client_user_id,
							'staff_user_id' => $staff_user_id,
							'status' => STAFF_LIKED
						);
			$this->client_favourite_staff_model->insert($data);
			return json_encode(array('liked' => 'yes'));
		}
	}
	
	
	
}