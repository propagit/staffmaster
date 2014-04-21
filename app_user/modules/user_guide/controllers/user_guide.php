<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_guide extends MX_Controller {

	/**
	*	@class_desc Brief controller. 
	*	
	*
	*/
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index($method='', $param='',$param2='')
	{
		
		switch($method)
		{

			default:
				$this->home($param);
			break;
		}
		
	}
	/**
	*	@name: home
	*	@desc: User Guide home page
	*	@access: public
	*	@param: (null)
	*	@return: 
	*/
	function home()
	{
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	


}