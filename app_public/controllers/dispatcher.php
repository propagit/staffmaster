<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Dispatcher
 * Description: control main flow of the app
 * @author: namnd86@gmail.com
 */

class Dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->website_dispatcher();
	}
	
	function website_dispatcher($method='', $param1='',$param2='',$param3='',$param4='')
	{
		header("Location: http://staffbooks.com", TRUE, 301);
		
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run('website/' . $method . '/' . $param1, $param2, $param3, $param4); exit();	
		}
		
		$content = modules::run('website', $method, $param1, $param2, $param3, $param4);
		$this->template->set_template('website');
		$this->template->write('content', $content);
		$this->template->render();
		//$this->account_dispatcher('signup');
	}
	
	
	
	
	function blog_dispatcher($method='', $param1='',$param2='',$param3='',$param4='')
	{	
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run('blog/' . $method . '/' . $param1, $param2, $param3, $param4); exit();	
		}
		$content = modules::run('blog', $method, $param1, $param2, $param3, $param4);
		$this->template->set_template('blog_admin');
		$this->template->write_view('menu', 'blog_admin/menu');
		$this->template->write('content', $content);
		$this->template->render();	
	}
	
	function account_dispatcher($method='', $param1='',$param2='',$param3='',$param4='')
	{		
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run('account/' . $method . '/' . $param1, $param2, $param3, $param4); exit();	
		}
		if ($method != 'setup' && $method != 'update')
		{
			header("Location: http://staffbooks.com", TRUE, 301);
		}
		$content = modules::run('account', $method, $param1, $param2, $param3, $param4);
		
		switch($method)
		{
			case 'setup':
					$title = 'Set up';
				break;
			default:
					$title = 'Sign up';
				break;
		}
		$this->template->set_template('signup');
		$this->template->write('title', 'Account - ' . $title);
		$this->template->write('content', $content);
		$this->template->render();
	}	
}

/* End of file dispatcher.php */
/* Location: ./application/controllers/dispatcher.php */