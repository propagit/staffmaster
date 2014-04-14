<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends MX_Controller {
	/**
	*	@class_desc Support Module Ajax Controller 
	*	
	*
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->model('support_model');
	}
	
	
	/**
	*	@name: reload_supports
	*	@desc: This function reloads support tickets. Mostly after a new support ticket has been lodged etc.
	*	@access: public
	*	@param: (null)
	*	@return: returns most recent support tickets
	*/
	function reload_supports()
	{
		echo modules::run('support/load_support_tickets');	
	}
	
	
}