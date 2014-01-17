<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Profile
 * @author: namnd86@gmail.com
 */

class Profile extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'edit_sub_user':
					$this->edit_sub_user();
				break;
			case 'delete_sub_user':
					$this->delete_sub_user($param);
				break;
			default:
					$this->update_profile();
				break;
		}
	}
	
	function update_profile()
	{
		$user = $this->session->userdata('user_data');
		
		if ($this->input->post())
		{
			if ($this->user_model->update_user($user['user_id'], $this->input->post()))
			{
				$user = array_merge($user, $this->input->post());
				$this->session->set_userdata('user_data', $user);
				$data['updated'] = true;
			}
		}
		$data['states'] = $this->user_model->get_states();
		$data['user'] = $user;
		$data['sub_users'] = $this->user_model->get_sub_users($user['user_id']);
		$this->load->view('profile', isset($data) ? $data : NULL);
	}
	
	
	
	function edit_sub_user()
	{
		$user_id = $this->input->post('sub_user_id');
		$data = array(
			'company_email' => $this->input->post('sub_email'),
			'password' => $this->input->post('sub_password'),
			'first_name' => $this->input->post('sub_first_name'),
			'last_name' => $this->input->post('sub_last_name')
		);
		if ($this->user_model->update_user($user_id, $data))
		{
			redirect('profile');
		}
	
	}
	
	function delete_sub_user($user_id)
	{
		$user = $this->user_model->get_user($user_id);
		if (!$user)
		{
			redirect('profile');
		}
		if (file_exists('./uploads/logos/' . $user['logo_url']))
		{
			unlink('./uploads/logos/' . $user['logo_url']);
		}
		$this->user_model->delete_user($user_id);
		redirect('profile');
	}
}