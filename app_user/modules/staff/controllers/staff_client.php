<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: staff
*	@controller: staff_client
*/

class Staff_client extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('profile/profile_model');
		$this->load->model('user/user_model');
		$this->load->model('staff_model');
		$this->load->model('formbuilder/formbuilder_model');
		$this->load->model('export/export_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_staff();
				break;
			case 'search':
					$this->search_staffs();
				break;
			case 'import':
					$this->import_view();
				break;
			case 'edit':
					echo modules::run('staff/edit_staff', $param);
				break;	
			default:
					echo modules::run('staff/search_staffs');
				break;
		}
	}
	
}