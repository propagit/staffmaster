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

		$this->user_dispatcher();
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
			  if (!$controller)
			  {
				  $controller = 'dashboard';
			  }
			  $this->admin_dispatcher($controller, $method, $param1, $param2, $param3, $param4);
		  }
		  else if ($user_data['is_staff'])
		  {
			  if (!$controller)
			  {
				  $controller = 'dashboard';
			  }
			  $this->staff_dispatcher($controller, $method, $param1, $param2, $param3, $param4);
		  }
		  else if ($user_data['is_client'])
		  {
			  if (!$controller)
			  {
				  $controller = 'job';
				  $method = 'calendar';
			  }
			  $this->client_dispatcher($controller, $method, $param1, $param2, $param3, $param4);
		  }
	}

	function staff_dispatcher($controller, $method, $param1, $param2, $param3, $param4)
	{
		$induction_required = modules::run('induction/check_staff_induction');

		if ($induction_required && $controller != 'induction')
		{
			print_r($induction_required); die();
			redirect('induction/publish/' . $induction_required);
		}

		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run($controller . '/' . $method . '/' . $param1, $param2, $param3, $param4); exit();
		}


		if($controller == 'brief' && (($method == 'view_brief' || $method == 'view_information_sheet')))
		{
			$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
			$title = ucwords($controller);
			$this->template->set_template('brief');
		}
		elseif($controller == 'induction' && ($method == 'preview' || $method == 'publish')) {
			$title = ucwords($controller);
			$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
			$this->template->set_template('induction');
		}
		else
		{
			$content = modules::run($controller . '/' . $controller . '_staff/index', $method, $param1, $param2, $param3, $param4);
			$title = ucwords($controller);
			$this->template->set_template('staff');
		}
		$this->template->add_css('custom_styles');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'staff/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}

	function admin_dispatcher($controller, $method, $param1, $param2, $param3, $param4)
	{
		if (modules::run('account/get_credits') < 0 && $controller != 'account')
		{
			redirect('account/buy_credits');
		}
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run($controller . '/' . $method . '/' . $param1, $param2, $param3, $param4); exit();
		}

		$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
		$title = ucwords($controller);

		if ($controller == 'invoice' && (($method == 'edit') || ($method == 'view')))
		{
			$this->template->set_template('invoice');
		}
		elseif($controller == 'brief' && (($method == 'view_brief' || $method == 'view_information_sheet')))
		{
			$this->template->set_template('brief');
		}
		elseif($controller == 'induction' && $method == 'preview') {
			$this->template->set_template('induction');
		}
		else
		{
			$this->template->set_template('admin');
		}
		$this->template->add_css('custom_styles');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'admin/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}

	/**
	*	@name: client_dispatcher
	*	@desc: call this dispatcher if the user is logged in as a client
	*	@access: public
	*	@param:
	*	@return: (void)
	*/
	function client_dispatcher($controller, $method, $param1, $param2, $param3, $param4)
	{
		if ( strpos($method, 'ajax') !== false)
		{
			echo modules::run($controller . '/' . $method . '/' . $param1, $param2, $param3, $param4); exit();
		}

		if ($controller == 'invoice' && $method == 'view')
		{
			$content = modules::run($controller, $method, $param1, $param2, $param3, $param4);
			$title = ucwords($controller);
			$this->template->set_template('invoice');
		}
		else
		{
			$content = modules::run($controller . '/' . $controller . '_client/index', $method, $param1, $param2, $param3, $param4);
			$title = ucwords($controller);
			$this->template->set_template('client');
		}


		$this->template->add_css('custom_styles');
		$this->template->write('title', $title);
		$this->template->write_view('menu', 'client/menu');
		$this->template->write('content', $content);
		$this->template->render();
	}

	function documentor_dispacher($controller='documentor', $method='', $param1='',$param2='',$param3='',$param4='')
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

/* End of file dispatcher.php */
/* Location: ./application/controllers/dispatcher.php */
