<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Dispacher for documentor module. 
*	@class_comments 
*
*/

class Document_dispacher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index($controller='documentor', $method='', $param1='',$param2='',$param3='',$param4='')
	{
		$this->template->set_template('documents');
		$title = "Staff Master Documentation";
		$menu = modules::run($controller . '/index', 'get_documentation_nav');
		$content = modules::run($controller . '/index', $method, $param1,$param2,$param3,$param4);
		$this->template->write('title', $title);
		$this->template->write('menu', $menu);
		$this->template->write('content', $content);
		$this->template->render();
	}
}

/* End of file document_dispacher.php */
/* Location: ./application/controllers/document_dispacher.php */