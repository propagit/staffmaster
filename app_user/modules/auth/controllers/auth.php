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

	function staff_protected_view($module)
	{
		$data['module'] = $module;
		$this->load->view('staff_protected_view', isset($data) ? $data : NULL);
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
		$this->template->write('title', 'StaffBooks');
		$this->template->write('check_browser', $this->check_browser());

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

	function staff($redirect_url='') {
		$this->session->set_userdata('force_staff', true);
		redirect($redirect_url);
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

	function check_browser()
	{
		preg_match('/MSIE (.*?);/', $_SERVER ['HTTP_USER_AGENT'], $matches);
		if(count($matches) > 1)
		{
			# Then we're using IE
			$version = $matches[1];
			if ($version < 9) {
				return $this->load->view('check_browser_view', null, true);
			}
		}
		return '';
	}

}
