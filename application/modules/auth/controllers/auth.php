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
					/*
if ($user['parent_id'] > 0) 
					{
						$parent = $this->user_model->get_user($user['parent_id']);
						$item_to_merge_array = array(
							'address', 'suburb', 'state', 'postcode', 'company_name', 'company_abn', 'discount', 'margin', 'logo_url', 'colour_primary', 'colour_secondary', 'colour_highlight', 'colour_midtone', 'colour_dark'
						);
						foreach($item_to_merge_array as $item)
						{
							$user[$item] = $parent[$item];
						}
					}
*/
					
					$this->session->set_userdata('is_user_logged_in', true);
					$this->session->set_userdata('user_data', $user);
					redirect('');
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
	
	function is_admin_logged_in()
	{
		return $this->session->userdata('is_admin_logged_in');
	}	
	
	function login_admin()
	{
		$this->template->write('title', 'Admin Portal');
		if ($this->input->post())
		{
			if (isset($_POST['username']) && isset($_POST['password']))
			{
				$admin = $this->auth_model->get_admin($_POST['username'], $_POST['password']);
				if ($admin)
				{
					$this->session->set_userdata('is_admin_logged_in', true);
					$this->session->set_userdata('admin_data', $admin);
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