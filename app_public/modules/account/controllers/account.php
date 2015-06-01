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
			case 'update':
				$this->update();
				break;
			case 'usages':
				$this->usages();
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

	function update()
	{
		$this->load->model('account_model');
		$accounts = $this->account_model->get_accounts(array('status' => 1));
		$sql = @file_get_contents('./../db/update_sqls.sql');
		$count = 0;
		$this->load->model('setup_model');
		foreach($accounts as $account)
		{
			if ($this->setup_model->import_sql($account['subdomain'], $sql))
			{
				$count++;
			}
		}
		echo $count . ' accounts have been updated';
	}

	function usages()
	{
		$this->load->model('account_model');
		$accounts = $this->account_model->get_accounts(array('status' => 1));
		$this->load->model('setup_model');
		$date = date('j');

		#$this->setup_model->minimum_usage('demo', '2014-10');

		if ($date == 1)
		{
			$month = date('Y-m-d', strtotime('last month'));
			foreach($accounts as $account)
			{
				$this->setup_model->minimum_usage($account['subdomain'], $month);
			}
		}

	}

}
