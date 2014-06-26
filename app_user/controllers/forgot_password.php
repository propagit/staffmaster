<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Forgot password
*	@class_comments 
*
*/

class Forgot_password extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		$this->load->model('auth/auth_model');
		$this->load->model('common/common_model');
	}
	
	function index()
	{
		$this->template->set_template('forgot_password');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'StaffBooks');
		if ($this->input->post())
		{
			$username_post = $this->input->post('username',true);
			$username = trim($username_post);
			$user = $this->auth_model->get_user_by_username($username);
			if($user)
			{
												
				$email = $username;
				//get company profile
				$company = $this->setting_model->get_profile();	
				$template_info = $this->email_template_model->get_template(FORGOT_PASSWORD_EMAIL_TEMPLATE_ID);
				$email_subject = $template_info->email_subject;
				//get receiver obj
				$email_obj_params = array(
								'template_id' => $template_info->email_template_id,
								'user_id' => $user->user_id,
								'company' => $company
							);
				$obj = $this->_get_email_obj($email_obj_params);
	
				$email_data = array(
							'to' => $email,
							'from' => $template_info->email_from,
							'from_text' => $company['email_c_name'],
							'subject' => $this->_format_template_body($template_info->email_subject,$obj),
							'message' => $this->_format_template_body($template_info->template_content,$obj)
						);
				$this->_send_email($email_data);
				$this->session->set_flashdata('password_reset','<div class="alert alert-success">Your new password has been sent to "'.$email.'".</div>');
				redirect('forgot_password');
				
			}else{
				$this->template->write('msg', '<div class="alert alert-danger">This email does not exist in our System.</div>');
			}
		}
		
		if($this->session->flashdata('password_reset')){
			$this->template->write('msg', $this->session->flashdata('password_reset'));
		}
		
		$this->template->render();
	}
	
	/**
	*	@name: get_email_obj
	*	@desc: Create the object needed for a particular template
	*	@access: private
	*	@param: (array) email params
	*	@return: returns object for a particular email template
	*/
	function _get_email_obj($params)
	{
		$template_id = $params['template_id'];
		$user_id = $params['user_id'];
		$company = $params['company'];
		$password = isset($params['password']) ? $params['password'] : '';
		$obj = array();
		
		if($template_id && $user_id && $company){
			$user = $this->user_model->get_user($user_id);
			switch($template_id){
				case FORGOT_PASSWORD_EMAIL_TEMPLATE_ID:
				//forgot password
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'company_name' => $company['company_name'],
							'system_url' => base_url(),
							'username' => $user['username'],
							'password' => $this->_reset_password($user_id)
							);
				break;
			}
		}
		return $obj;
	}
	
	/**
	*	@name: format_template_body
	*	@desc: 
	*	@access: private
	*	@param: 
	*/
	function _format_template_body($email,$obj = NULL)
	{
		if($obj){
				$email = str_replace('{FirstName}',$obj['first_name'],$email);
				$email = str_replace('{FamilyName}',$obj['last_name'],$email);
				$email = str_replace('{CompanyName}',$obj['company_name'],$email);
				$email = str_replace('{SystemURL}',$obj['system_url'],$email);
				$email = str_replace('{UserName}',$obj['username'],$email);
				$email = str_replace('{Password}',$obj['password'],$email);
		}
		return $email;
		
	}
	
	function _reset_password($user_id)
	{
		$temp_password = $this->_generate_password();
		$password = trim($temp_password);
		$data = array('password' => $password);
		$this->user_model->update_user($user_id,$data);
		return $password;
	}
	
	/**
	*    @name: generate_password
	*    @desc: Generates random string. Mostly used for password regeneration. The default length of the string is 6
	*    @access private
	*    @param: ([int] length of the string)
	*    @return: Returns random string.
	*/
	function _generate_password($password_length = 6)
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); 
		$alpha_length = strlen($alphabet) - 1; 
		for ($i = 0; $i < $password_length; $i++) {
			$n = rand(0, $alpha_length);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); 
	}
	
	/**
	*	@name: send_email
	*	@desc: A central function to send email
	*	@access: private
	*	@param: (array) email data
	*/
	function _send_email($data)
	{
		if(LIVE_SERVER){
			$this->_send_email_live($data);
		}else{
			$this->_send_email_localhost($data);
		}
	}

	/**
	*	@name: send_email_live
	*	@desc: A central function to send all email in live server
	*	@access: private
	*	@param: (array) email data
	*/
	function _send_email_live($data)
	{
		$to = '';
		$from = '';
		$cc = '';
		$bcc = '';
		$from_text = '';
		$subject = ''; 
		$message = ''; 
		$attachment = ''; 
		$bcc = '';
		if($data){
			foreach($data as $key=>$val){
				switch($key){
					case 'to':
						$to = $val;
					break;
					
					case 'from':
						$from = $val;
					break;
					
					case 'cc':
						$cc = $val;
					break;
										
					case 'bcc':
						$bcc = $val;
					break;
					
					case 'from_text':
						$from_text = $val;
					break;
					
					case 'subject':
						$subject = $val;
					break;
					
					case 'message':
						$message = $val;
					break;
					
					case 'attachment':
						$attachment = $val;
					break;	
				}
				
				
			}
			
			if($from == ''){
				$from = 'noreply@staffbooks.systems';
				$company = $this->setting_model->get_profile();
				if($company){
					if($company['email_c_email']){
						$from = $company['email_c_email'];	
					}
				}
			}
		
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($from,$from_text);		
			$this->email->to($to);
			$this->email->cc($cc);
			$this->email->bcc($bcc);
			if (!isset($data['overwrite']))
			{
				$company_logo = $this->_company_logo();
				$email_signature = $this->_get_email_footer();
				$message = $company_logo . '<br /><br /><br />'.$message . $email_signature;
			}
			
			$this->email->subject($subject);
			$this->email->message($message);
			if($attachment){
				$this->email->attach($attachment);
			}
			$this->email->send();
			$this->email->clear(true);	
					
		}else{
			return false;	
		}
		

	}
	
	/**
	*	@name: test_email
	*	@desc: Send test email
	*	@access: private
	*	@param: (array) email data
	*/
	/* function test_email()
	{
		$to = 'kaushtuvgurung@gmail.com';
		$from = '';
		$cc = '';
		$bcc = '';
		$from_text = 'StaffBooks Maintenance';
		$subject = 'Test Email'; 
		$message = 'This is a test message'; 
		$attachment = ''; 
		$bcc = '';

			
		
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($from,$from_text);		
		$this->email->to($to);
		$this->email->cc($cc);
		$this->email->bcc($bcc);
		 if (!isset($data['overwrite']))
		{
			$company_logo = $this->_company_logo();
			$email_signature = $this->_get_email_footer();
			$message = $company_logo . '<br /><br /><br />'.$message . $email_signature;
		} 
		
		$this->email->subject($subject);
		$this->email->message($message);
		if($attachment){
			$this->email->attach($attachment);
		} 
		if($this->email->send()){
			$this->email->clear(true);	
			return 'Email Sent';
		}else{
			show_error($this->email->print_debugger());
			exit();
		}

		

	} */
	
	/**
	*	@desc Test function to send email from localhost
	*
	*   @name send_email
	*	@access private
	*	
	*/
	function _send_email_localhost($data)
	{
		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
		  'smtp_pass' => 'morem0n3y', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		
		$to = '';
		$from = '';
		$cc = '';
		$bcc = '';
		$from_text = '';
		$subject = ''; 
		$message = ''; 
		$attachment = ''; 
		$bcc = '';
		
		if($data){
		foreach($data as $key=>$val){
				switch($key){
					case 'to':
						$to = $val;
					break;
					
					case 'from':
						$from = $val;
					break;
					
					case 'cc':
						$cc = $val;
					break;
										
					case 'bcc':
						$bcc = $val;
					break;
					
					case 'from_text':
						$from_text = $val;
					break;
					
					case 'subject':
						$subject = $val;
					break;
					
					case 'message':
						$message = $val;
					break;
					
					case 'attachment':
						$attachment = $val;
					break;	
				}
				
				
			}
		}
		

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com',$from_text); // change it to yours
		$this->email->to($to);// change it to yours
		$this->email->subject($subject);
		if (!isset($data['overwrite']))
		{
			$company_logo = $this->_company_logo();
			$email_signature = $this->_get_email_footer();
			$message = $company_logo . '<br /><br /><br />'.$message . $email_signature;
		}
		
		$this->email->subject($subject);
		$this->email->message($message);
			
			
		if($attachment){
			$this->email->attach($attachment);
		}
		if($this->email->send()){
		  	echo 'Email sent.';
		}else{
			show_error($this->email->print_debugger());
		} 
	}
	
	/**
	*	@name: company_logo
	*	@desc: ajax function to get company logo
	*	@access: private
	*	
	*	
	*/
	function _company_logo()
	{
		$data['company'] = $this->setting_model->get_profile();
		return $this->load->view('settings/company_logo', isset($data) ? $data : NULL, TRUE);
	}
	
	/**
	*	@name: get_template_footer
	*	@desc: Get Email Footer Template
	*	@access: private
	*	@param: (via POST) Background color and Font color
	*	
	*/
	function _get_email_footer()
	{
		$company = $this->setting_model->get_profile();
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
		if($company){
			if($company['email_background_colour']){
				$color = $company['email_background_colour'];
			}
			if($company['email_font_colour']){
				$font_color = $company['email_font_colour'];
			}
		}
		
		$data['color'] = $color;
		$data['font_color'] = $font_color;
		$data['company'] = $company;
		$data['country_full_name'] = '';
		if(isset($company['email_c_country']) && $company['email_c_country']!=''){
			$data['country_full_name'] = $this->_get_country_name_from_country_code($company['email_c_country']);
		}
		
		return $this->load->view('settings/email_footer_template', isset($data) ? $data : NULL, TRUE);	
	}
	
	function _get_country_name_from_country_code($country_code)
	{
		$country = $this->common_model->get_country_name_from_country_code($country_code);
		return $country->name;
	}
}

/* End of file brief_dispacher.php */
/* Location: ./application/controllers/document_dispacher.php */