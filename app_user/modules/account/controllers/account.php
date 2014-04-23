<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Account
 * @author: namnd86@gmail.com
 */

class Account extends MX_Controller {

	var $user = null;
	function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user_data');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			#case 'buy_credits':
			default:					
					$this->buy_credits_view();
				break;
		}
		
	}
	
	function buy_credits_view()
	{
		$this->load->model('account_master_model');
		$data['credits'] = $this->get_credits();
		$data['prices'] = $this->account_master_model->get_prices();
		$this->load->view('buy_credits_view', isset($data) ? $data : NULL);
	}
	
	function menu($user=array())
	{
		$data['user'] = $this->user;
		$this->load->view('account_menu', isset($data) ? $data : NULL);
	}
	
	

	function box_credits()
	{
		$this->load->view('box_credits', isset($data) ? $data : NULL);
	}

	function get_credits()
	{
		$this->load->model('account_model');
		return $this->account_model->get_credits();
	}
	
}