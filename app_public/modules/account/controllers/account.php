<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($method='', $param1='', $param2='')
	{
		switch($method)
		{
			case 'setup':
				$this->setup($param1, $param2);
				break;
			default:	
				$this->signup_form();
				break;
		}
	}
	
	
	function signup_form()
	{		
		$this->load->view('signup_form', isset($data) ? $data : NULL);
	}
	
	function setup($subdomain, $code)
	{
		if (!$subdomain || !$code)
		{
			redirect('');
		}
		$this->load->model('account_model');
		$account = $this->account_model->get_account(array('subdomain' => $subdomain, 'activation_code' => $code));
		if (!$account)
		{
			redirect('');
		}
		$this->account_model->activate_account($account['account_id']);
		$data['subdomain'] = $subdomain;
		$this->load->view('setup_view', isset($data) ? $data : NULL);
	}
	
}