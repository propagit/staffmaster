<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Blog_dispatcher
 * Description: Controls the flow of blog
 * @author: kaushtuvgurung@gmail.com
 */

class Blog_dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->dispatcher();
	}
	
	function dispatcher($controller = '',$method='', $param1='',$param2='',$param3='',$param4='')
	{
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run($controller . '/ajax/' . $method . '/' . $param1, $param2, $param3, $param4); exit();	
		}
		
		$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
		$title = ucwords($controller);
		$this->template->set_template('admin');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'admin/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	function public_dispatcher()
	{
		
	}
}

/* End of file dispatcher.php */
/* Location: ./application/controllers/dispatcher.php */