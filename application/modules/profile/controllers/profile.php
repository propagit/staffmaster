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
		$this->load->model('profile_model');
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
		//$user = $this->session->userdata('user_data');
		$company = $this->profile_model->get_profile();
		if ($this->input->post())
		{
			$data = $this->input->post();
			$this->profile_model->update_profile(1, array(
				'company_name' => $data['company_name'],
				'company_address' => $data['company_address'], 
				'company_suburb' => $data['company_suburb'],
				'company_postcode' => $data['company_postcode'],
				'company_state' => $data['company_state'],
				'company_country' => $data['company_country'],
				'company_email' => $data['company_email'],
				'company_website' => $data['company_website'],
				'company_phone' => $data['company_phone'],
				'company_fax' => $data['company_fax'],
				'company_abn' => $data['company_abn'],
				'company_account_name' => $data['company_account_name'],
				'company_account_no' => $data['company_account_no'],
				'company_bsb' => $data['company_bsb'],
				'super_name' => $data['super_name'],
				'super_product_id' => $data['super_product_id'],
				'super_fund_phone' => $data['super_fund_phone'],
				'super_fund_website' => $data['super_fund_website'],
			));
		}
		$data['states'] = $this->user_model->get_states();
		$data['company'] = $company;
		//$data['sub_users'] = $this->user_model->get_sub_users($user['user_id']);
		$this->load->view('company_profile', isset($data) ? $data : NULL);
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