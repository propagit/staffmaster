<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class User extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index($method='', $param='')
	{
		
	}
	
	function field_select_admin($field_name, $field_value=null) 
	{
		$users = $this->user_model->get_admin_users();
		$array = array();
		foreach($users as $user) {
			$array[] = array(
				'value' => $user['user_id'],
				'label' => $user['first_name'] . ' ' . $user['last_name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	function get_user($user_id) {
		return $this->user_model->get_user($user_id);
	}
		
}