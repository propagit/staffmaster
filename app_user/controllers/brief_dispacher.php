<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Brief dispacher
*	@class_comments 
*
*/

class Brief_dispacher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($controller='brief', $method='', $param1='',$param2='',$param3='',$param4='')
	{
		$this->template->set_template('brief');
		$this->template->add_css('custom_styles');
		$title = "Staff Master | Brief";
		$content = modules::run($controller . '/index', $method, $param1,$param2,$param3,$param4);
		$this->template->write('title', $title);
		$this->template->write('content', $content);
		$this->template->render();
	}
}

/* End of file brief_dispacher.php */
/* Location: ./application/controllers/document_dispacher.php */