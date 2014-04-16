<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
		$this->load->model('account_model');
	}
	
	
	function signup()
	{		
		$input = $this->input->post();
		# Validate input data
		$data = $this->validate_account($input);
		
		# Create account
		$account_id = $this->account_model->create_account($data);
		echo json_encode(array(
			'valid' => true, 
			'username' => $data['username'],
			'code' => $data['activation_code']));
		
	}
	
	function validate_account($input=array())
	{
		$username = strtolower(trim($input['company_name']));
		$username = preg_replace('/\s+/', '', $username);
		
		# Validate username length
		if (strlen($username) < 3 || strlen($username) > 40)
		{
			echo json_encode(array('valid' => false, 'msg' => 'Invalid company name'));
			exit();
		}
		
		# Check if username already exists
		if ($this->account_model->get_account(array('username' => $username)))
		{
			echo json_encode(array('valid' => false, 'msg' => 'Username already existed'));
			exit();
		}
		
		$email_address = strtolower(trim($input['email_address']));
		# Check valid email address
		if (!valid_email($email_address))
		{
			echo json_encode(array('valid' => false, 'msg' => 'Invalid email address'));
			exit();
		}
		
		# Check if email already exists
		if ($this->account_model->get_account(array('email_address' => $email_address)))
		{
			echo json_encode(array('valid' => false, 'msg' => 'Email address already existed'));
			exit();
		}
		
		$password = $input['password'];
		# Validate password length
		if (strlen($password) < 3 || strlen($password) > 40)
		{
			echo json_encode(array('valid' => false, 'msg' => 'Invalid password'));
			exit();
		}
		
		$activation_code = md5($password);
		return array(
			'username' => $username,
			'email_address' => $email_address,
			'password' => $activation_code,
			'activation_code' => $activation_code
		);
	}
	
}