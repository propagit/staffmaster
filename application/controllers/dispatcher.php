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
	
	/**
	*	@name: user_dispatcher
	*	@desc: general user dispacher, drive to different portal based on user level
	*	@access: public
	*	@param: (uri)
	*	@return: (void)
	*/
	function user_dispatcher($controller='', $method='', $param1='',$param2='',$param3='',$param4='')
	{
		$is_user_logged_in = modules::run('auth/is_user_logged_in');
		if (!$is_user_logged_in)
		{
			redirect('login');
		}
		
		$user_data = $this->session->userdata('user_data');
		
		# If user is admin, login to admin portal
		if ($user_data['is_admin'] && !$this->session->userdata('force_staff'))
		{
			$this->admin_dispatcher($controller, $method, $param1, $param2, $param3, $param4);
		}
		else if ($user_data['is_staff'])
		{
			$this->staff_dispatcher($controller, $method, $param1, $param2, $param3, $param4);
		}
		
		
	}
	
	function staff_dispatcher($controller, $method, $param1, $param2, $param3, $param4)
	{		
		if ($method == 'ajax')
		{
			echo modules::run($controller . '/ajax/' . $param1, $param2, $param3, $param4); exit();	
		}
		
		$content = modules::run($controller . '/' . $controller . '_staff/index', $param1, $param2, $param3, $param4);
		$title = ucwords($controller);
		
		$this->template->set_template('staff');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'staff/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	function admin_dispatcher($controller, $method, $param1, $param2, $param3, $param4)
	{
		if ($method == 'ajax')
		{
			echo modules::run($controller . '/ajax/' . $param1, $param2, $param3, $param4); exit();	
		}
		
		$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
		$title = ucwords($controller);
		
		
		$this->template->set_template('admin');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'admin/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}
}

/* End of file dispatcher.php */
/* Location: ./application/controllers/dispatcher.php */