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
	
	public function index()
	{
		$this->user_dispatcher('dashboard');
	}
	
	function user_dispatcher($controller='', $method='', $param1='',$param2='',$param3='',$param4='')
	{
		$is_user_logged_in = modules::run('auth/is_user_logged_in');
		if (!$is_user_logged_in)
		{
			redirect('login');
		}
		
		if ($method == 'ajax')
		{
			echo modules::run($controller . '/ajax/' . $param1, $param2, $param3, $param4); exit();
		}
		switch($controller)
		{
			case 'dashboard':
			default:
					$title = 'Dashboard';
				break;
		}
		if ($controller != 'page')
		{
			$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
		}
		
		
		$this->template->set_template('user');
		
		#$this->template->add_css('user/css');
		
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'user/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	function staff_dispatcher($controller='', $method='', $param1='', $param2='', $param3='', $param4='')
	{
		
	}
	
	function admin_dispatcher($controller='dashboard', $method='', $param='')
	{
		
	}
}

/* End of file dispatcher.php */
/* Location: ./application/controllers/dispatcher.php */