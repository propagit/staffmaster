<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Brief extends MX_Controller {

	/**
	*	@class_desc Brief controller. 
	*	
	*
	*/
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('brief_model');
	}
	
	function index($method='', $param='')
	{
		
		switch($method)
		{
			default:
				$this->main_view($param);
			break;
		}
		
	}
	
	function main_view($brief_id = '')
	{
		$data['brief_id'] = 1;
		$this->load->view('brief_main_view', isset($data) ? $data : NULL);
	}
	
	function load_brief_preview($brief_id = NULL)
	{
		if($brief_id){
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief_id);	
		}
		$this->load->view('brief_preview', isset($data) ? $data : NULL);
	}


}