<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Log extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('log_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() 
	{
		$data['dates'] = $this->log_model->get_logged_dates();
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function get_logs_by_date($date) 
	{
		return $this->log_model->get_logs_by_date($date);
	}
	
	function display($log)
	{
		$data['log'] = $log;
		$this->load->view('display/' . $log['object'] . '_view', isset($data) ? $data : NULL);
	}
	
}