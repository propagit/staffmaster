<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('account_model');
	}
	
	
	function validate()
	{
		$input = $this->input->post();
		$this->validate_account($input);
		echo json_encode(array('valid' => true));
	}
	
	function signup()
	{		
		$input = $this->input->post();
		# Validate input data
		$data = $this->validate_account($input);
		
		# Create account
		$account_id = $this->account_model->create_account($data);
		$this->send_activation_code($data);
		echo json_encode(array(
			'valid' => true,
			'msg' => 'Please check your email address for activation instruction'));
		
	}
	
	function validate_account($input=array())
	{
		$subdomain = strtolower(trim($input['company_name']));
		if ($subdomain == '')
		{
			echo json_encode(array('valid' => false, 'error_id' => 'company_name', 'msg' => 'Please enter your company name'));
			exit();
		}
		$subdomain = preg_replace('/\s+/', '', $subdomain);
		
		# Validate username length
		if (strlen($subdomain) < 3 || strlen($subdomain) > 40)
		{
			# echo json_encode(array('valid' => false, 'msg' => 'Invalid sub domain name'));
			# exit();
		}
		
		# Check if username already exists
		if ($this->account_model->get_account(array('subdomain' => $subdomain)))
		{
			# echo json_encode(array('valid' => false, 'msg' => 'Subdomain already existed'));
			# exit();
			$subdomain = $subdomain . '1';
		}
		
		$email_address = strtolower(trim($input['email_address']));
		# Check valid email address
		if (!valid_email($email_address))
		{
			echo json_encode(array('valid' => false, 'error_id' => 'email_address', 'msg' => 'Invalid email address'));
			exit();
		}
		
		# Check if email already exists
		if ($this->account_model->get_account(array('email_address' => $email_address)))
		{
			echo json_encode(array('valid' => false, 'error_id' => 'email_address', 'msg' => 'Email address already existed'));
			exit();
		}
		
		$password = $input['password'];
		# Validate password length
		if (strlen($password) < 6 || strlen($password) > 40)
		{
			echo json_encode(array('valid' => false, 'error_id' => 'password', 'msg' => 'Must be at least 6 characters'));
			exit();
		}
		
		$activation_code = md5($password);
		return array(
			'company_name' => $input['company_name'],
			'subdomain' => $subdomain,
			'email_address' => $email_address,
			'password' => $activation_code,
			'activation_code' => $activation_code
		);
	}
	
	function send_activation_code($data)
	{
		$data['activation_url'] = base_url() . 'account/setup/' . $data['subdomain'] . '/' . $data['activation_code'];
		
		$message = $this->load->view('email/verify', $data, true);
		modules::run('email/send_email', array(
			'to' => $data['email_address'], #'nam@propagate.com.au',
			'from' => 'team@staffbooks.com',
			'from_text' => 'StaffBooks',
			'subject' => 'Verify your email address',
			'message' => $message
		));
	}
}