<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Auth
 * @author: namnd86@gmail.com
 */

class Auth extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}
	
	
	function is_user_logged_in()
	{
		return $this->session->userdata('is_user_logged_in');
	}
	
	function is_admin()
	{
		$user = $this->session->userdata('user_data');
		return $user['is_admin'];
	}
	
	function is_staff()
	{
		$user = $this->session->userdata('user_data');
		return ($this->session->userdata('force_staff') || ($user['is_staff'] && !$user['is_admin']));
	}
	
	function is_client()
	{
		$user = $this->session->userdata('user_data');
		return $user['is_client'];
	}
	
	function login_user()
	{
		$this->template->set_template('login');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'Staff Master');
		
		if ($this->input->post())
		{
			if (isset($_POST['username']) && isset($_POST['password']))
			{
				$user = $this->auth_model->get_user($_POST['username'], $_POST['password']);
				if ($user)
				{
					$this->load->model('user/user_model');
					$this->user_model->update_user($user['user_id'], array('last_signed_in_on' => date('Y-m-d H:i:s', time())));
	
					$this->session->set_userdata('is_user_logged_in', true);
					$this->session->set_userdata('user_data', $user);
					redirect('');
				}
			}
			$this->template->write('msg_error', '<div class="alert alert-danger">Wrong username/password</div>');
			
		}
		$this->template->render();
	}
	
	function staff() {
		$this->session->set_userdata('force_staff', true);
		redirect('');
	}
	
	function admin() {
		$this->session->unset_userdata('force_staff');
		redirect('');
	}
	
	function logout_user()
	{
		$this->session->sess_destroy();
		#$this->session->unset_userdata('user_data');
		#$this->session->unset_userdata('is_user_logged_in');
		#$this->session->unset_userdata('force_staff');
		redirect('');
	}	
	
	function forgot_password()
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		
		
		$this->template->set_template('forgot_password');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'Staff Master');
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
				$obj = modules::run('email/get_email_obj',$email_obj_params);
				
				$email_data = array(
							'to' => $email,
							'from' => $company['email_c_email'],
							'from_text' => $company['email_c_name'],
							'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
							'message' => modules::run('email/format_template_body',$template_info->template_content,$obj)
						);
				modules::run('email/send_email',$email_data);
				$this->template->write('msg', '<div class="alert alert-success">Your new password has been sent to this "'.$email.'" email.</div>');
				
			}else{
				$this->template->write('msg', '<div class="alert alert-danger">This email does not exist in our System.</div>');
			}
		}
		
		
		$this->template->render();
	}
	
}