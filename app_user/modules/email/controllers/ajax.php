<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('email_template_model');	
		$this->load->model('user/user_model');	
	}
	
	/**
	*	@name: load_email_template
	*	@desc: ajax function to load (abstract) view of an email template
	*	@access: public
	*	@param: (string) $object
	*	@return: (html) view of email template configuration based on tab
	*/
	function load_email_template($tab='welcome_staff') {
		switch($tab){
			case 'welcome_staff':
				$data['template'] = $this->email_template_model->get_template(WELCOME_EMAIL_TEMPLATE_ID);
			break;	
			case 'roster_update':
				$data['template'] = $this->email_template_model->get_template(ROSTER_UPDATE_EMAIL_TEMPLATE_ID);
			break;
			case 'apply_shift':
				$data['template'] = $this->email_template_model->get_template(APPLY_FOR_SHIFT_EMAIL_TEMPLATE_ID);
			break;
			case 'shift_reminder':
				$data['template'] = $this->email_template_model->get_template(SHIFT_REMINDER_EMAIL_TEMPLATE_ID);
			break;
			case 'work_confirmation':
				$data['template'] = $this->email_template_model->get_template(WORK_CONFIRMATION_EMAIL_TEMPLATE_ID);
			break;
			case 'forgot_password':
				$data['template'] = $this->email_template_model->get_template(FORGOT_PASSWORD_EMAIL_TEMPLATE_ID);
			break;
			case 'client_invoice':
				$data['template'] = $this->email_template_model->get_template(CLIENT_INVOICE_EMAIL_TEMPLATE_ID);
			break;
			case 'client_quote':
				$data['template'] = $this->email_template_model->get_template(CLIENT_QUOTE_EMAIL_TEMPLATE_ID);
			break;
			case 'brief':
				$data['template'] = $this->email_template_model->get_template(BRIEF_EMAIL_TEMPLATE_ID);
			break;
		}
		$this->load->view($tab, isset($data) ? $data : NULL);
	}
	/**
	*	@name: update_template
	*	@desc: Update email template
	*	@access: public
	*	@param: (via post) 
	*/
	function update_template()
	{
		$name_prefix = $this->input->post('form_name_prefix',true);
		$template_id = $this->input->post('template_update_id',true);
		$email_from = $this->input->post($name_prefix.'email_from',true);
		$email_subject = $this->input->post($name_prefix.'email_subject',true);
		$email = $this->input->post($name_prefix.'email');
		$auto_send =  $this->input->post($name_prefix.'auto_send',true);
		$data = array(
					'template_content' => $email,
					'email_from' => $email_from,
					'email_subject' => $email_subject,
					'auto_send' => ($auto_send ? 'yes' : 'no'),
					'modified' => date('Y-m-d H:i:s')
					);
		echo $this->email_template_model->update_template($template_id,$data);
	}
	
	function load_template()
	{
		$template_id = $this->input->post('template_id',true);
		if($template_id){
			$template =  $this->email_template_model->get_template($template_id);
			echo $template->template_content;	
		}
		echo  '&nbsp;';
	}
	
	/**
	*	@name: get_send_email_modal
	*	@desc: Open modal window which contains the view to send email to multiple user
	*	@access: public
	*	@param: (via POST) modal_header
	*	
	*/
	
	function get_send_email_modal()
	{
		$data['email_modal_header'] = "Contact User";
		$selected_user_ids = '';
		//for search staff
		if($this->input->post('user_staff_selected_user_id',true)){
			$selected_user_ids = $this->input->post('user_staff_selected_user_id',true);
		}
		//for search client
		if($this->input->post('user_client_selected_user_id',true)){
			$selected_user_ids = $this->input->post('user_client_selected_user_id',true);
		}
		if($this->input->post('email_modal_header',true)){
			$data['email_modal_header'] = $this->input->post('email_modal_header',true);	
		}
		
		$template_id = null;
		if($this->input->post('email_template_id',true)){
			$template_id = $this->input->post('email_template_id',true);
		}
		$data['template_id'] = $template_id;
		
		$data['total'] = 0;
		$data['selected_user_ids'] = '';
		if($selected_user_ids){
			$unique_selected_user_ids = array_unique($selected_user_ids); # Unique id
			$unique_selected_user_ids = array_diff($unique_selected_user_ids, array(0));  # Remove 0 from array
			$data['selected_user_ids'] = json_encode($unique_selected_user_ids);
			if($unique_selected_user_ids != ''){	
				$data['total'] = count($unique_selected_user_ids);
			}
		}
		//this is the selected modules ids such as invoice ids, shift ids 
		$data['selected_module_ids'] = '';
		$selected_module_ids = $this->input->post('selected_module_ids',true);
		if($selected_module_ids){
			$data['selected_module_ids'] = json_encode($selected_module_ids);	
		}
		
		//get allowed templates 
		$allowed_template_ids = 'all';
		if($this->input->post('allowed_template_ids')){
			$allowed_template_ids_post = $this->input->post('allowed_template_ids');
			$allowed_template_ids = json_decode($allowed_template_ids_post);
		}
		
		//field select params
		$data['email_template_select_params'] = $params = array(
															 'field_name' => 'email_template_select',
															 'field_value' => $template_id,
															 'size' => '',
															 'allowed_template_ids' => $allowed_template_ids
															 );
		
		$this->load->view('send_email_modal', isset($data) ? $data : NULL);
	}
	/**
	*	@name: send_sample_email
	*	@desc: Send sample email to a particular email vai send email modal window UI
	*	@access: public
	*	@param: (via POST) user id 
	*	
	*/
	function send_sample_email()
	{
		$this->load->model('setting/setting_model');
		$company = $this->setting_model->get_profile();	
		$email_body = $this->input->post('email_body');
		$email_template_id = $this->input->post('email_template_select',true);
		if($email_template_id){
			$template_info = $this->email_template_model->get_template($email_template_id);
		}
		$email_to = $this->input->post('sample_email_to',true);
		if($email_to){
			$email_data = array(
						'to' => $email_to,
						'from' => $template_info->email_from,
						'from_text' => $company['email_c_name'],
						'subject' => $template_info->email_subject,
						'message' => modules::run('email/format_template_body',$email_body)
					);
			modules::run('email/send_email',$email_data);
		}
		echo 'success';
	}
	/**
	*	@name: send_email
	*	@desc: Send email to a particular email vai send email modal window UI. This is a sample function only. 
	*	@access: private
	*	@param: (via POST)
	*	
	*/
	function _send_email()
	{
		$this->load->model('setting/setting_model');
		$company = $this->setting_model->get_profile();	
		$email_body = $this->input->post('email_body');
		$email_subject = 'Staff Master ';
		$email_template_id = $this->input->post('email_template_select',true);
		if($email_template_id){
			$template_info = $this->email_template_model->get_template($email_template_id);
			$email_subject = $template_info->email_subject;
		}
		$selected_user_ids = $this->session->userdata('selected_user_ids');
		if($selected_user_ids){
			//create obj parameters based on user and email template eg
			// $obj = array('first_name' => John, 'company_name' => 'Staff Master')
			foreach($selected_user_ids as $id){
				$email = $this->user_model->get_user_email_from_user_id($id);
				if($email){
					$email_data = array(
								'to' => $email,
								'from' => $company['email_c_email'],
								'from_text' => $company['email_c_name'],
								'subject' => $email_subject,
								'message' => modules::run('email/format_template_body',$email_body,$obj)
							);
					modules::run('email/send_email',$email_data);

				}
			}
			
		}
		$this->session->unset_userdata('selected_user_ids');
		echo 'success';
	}
	/**
	*	@name: load_receiver_list
	*	@desc: Load the list of user who are receiving the email
	*	@access: public
	*	@param: ([via POST] user ids)
	*	
	*/
	function load_receiver_list()
	{
		$selected_user_ids = $this->input->post('selected_user_ids');
		if($selected_user_ids){
			$user_ids = json_decode($selected_user_ids);
			if(count($user_ids)){
				$data['users'] = modules::run('user/get_users_from_user_ids',$user_ids);
			}
		}
		$this->load->view('receivers/receiver_lists', isset($data) ? $data : NULL);
	}
	/**
	*	@name: send_email
	*	@desc: Send email to a particular email vai send email modal window UI. This is a sample function only. 
	*	@access: public
	*	@param: (via POST)
	*	
	*/
	function delete_receiver()
	{
		$selected_user_ids = $this->input->post('selected_user_ids');
		$delete_receiver_id = $this->input->post('delete_receiver_id');	
		
		if($selected_user_ids && $delete_receiver_id){
			$user_ids = json_decode($selected_user_ids);
			if(($key = array_search($delete_receiver_id, $user_ids)) !== false) {
				unset($user_ids[$key]);
			}
		}
		
		$data['total_selected_users'] = count($user_ids);
		$data['selected_user_ids'] = $this->_format_selected_user_ids($user_ids);
		echo json_encode($data);
	}
	
	function add_group_users_to_email_list()
	{
		$group_id = $this->input->post('group_id');
		if($group_id == 'all'){
			$users_ids_in_group = modules::run('staff/get_active_staff_user_ids');
		}else{
			$users_ids_in_group = modules::run('staff/get_staff_user_ids_by_group_id',$group_id);
		}
		$selected_user_ids = array();
		if($users_ids_in_group){
			foreach($users_ids_in_group as $user_id)
			{
				$selected_user_ids[] = $user_id->user_id;	
			}
		}
		$data['total_selected_users'] = count($users_ids_in_group);
		$data['selected_user_ids'] = json_encode($selected_user_ids);
		echo json_encode($data);
	}
	
	/**
	*	@name: _format_selected_user_ids
	*	@desc: Format user ids in json format for email module - selected user ids. This was used as default json encode had issues 
	*	@access: private
	*	@param: ([array] user ids)
	*	
	*/
	function _format_selected_user_ids($user_ids)
	{
		$temp_ids = '';
		foreach($user_ids as $id){
			$temp_ids .= '"'.$id.'",';
		}
		$temp_ids = rtrim($temp_ids, ',');
		return 	'['.$temp_ids.']';
	}
}