<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($method='', $param1='', $param2='')
	{
		switch($method)
		{
			case 'tour':
				$this->tour_view();
				break;
			default:	
				$this->homepage_view();
				break;
		}
	}
	
	function homepage_view()
	{
		$this->load->view('homepage_view', isset($data) ? $data : NULL);
	}
	
	function tour_view()
	{
		$this->load->view('tour_view', isset($data) ? $data : NULL);
	}
}