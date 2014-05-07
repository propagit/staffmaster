<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Auth
 * @author: namnd86@gmail.com
 */

class Auth extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_template('login');
		$this->load->model('auth_model');
	}
	
	
	function is_user_logged_in()
	{
		return $this->session->userdata('is_user_logged_in');
	}
	
	function login_user()
	{
		$this->template->write('title', 'Administration');
		if ($this->input->post())
		{
			if (isset($_POST['username']) && isset($_POST['password']))
			{
				$data = array('username' => $_POST['username'], 'password' => $_POST['password']);
				$user = $this->auth_model->validate($data);
				if ($user)
				{					
					if($user['level']==1){										
						$this->session->set_userdata('is_user_logged_in', true);						
						redirect('http://propatest.com/wave1');
					}
					else
					
					if($user['level']==9)
					{
						$this->session->set_userdata('is_admin_logged_in', true);
						redirect('admin');
					}
				}
			}
			$this->template->write('msg_error', '<div class="alert alert-error">Wrong username/password</div>');
			
		}
		$this->template->render();
	}
	
	function logout_user()
	{
		#$this->session->sess_destroy();
		$this->session->unset_userdata('user_data');
		$this->session->unset_userdata('is_user_logged_in');
		redirect('');
	}
	#check if the user already log in or not.
	function is_admin_logged_in()
	{
		return $this->session->userdata('is_admin_logged_in');
	}	
	# Raquel: check username and password
	function login_admin()
	{
		$this->template->write('title', 'Administration');
		if ($this->input->post())
		{
			if (isset($_POST['username']) && isset($_POST['password']))
			{
				$data = array('username' => $_POST['username'], 'password' => $_POST['password']);
				$user = $this->auth_model->validate($data);
				if ($user)
				{
										
					$this->session->set_userdata('is_admin_logged_in', true);
		
					redirect('admin');
				}
			}
			$this->template->write('msg_error', '<div class="alert alert-error">Wrong username/password</div>');
			
		}
		$this->template->render();
		
		
		
	}
	
	function logout_admin()
	{
		#$this->session->sess_destroy();
		$this->session->unset_userdata('admin_date');
		$this->session->unset_userdata('is_admin_logged_in');
		redirect('admin');
	}
	
	
	
}