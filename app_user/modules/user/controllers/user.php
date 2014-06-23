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
	
	function get_user_by_email($email) {
		return $this->user_model->get_user_by_email($email);
	}
	
	function get_user_client($user_id)
	{
		return $this->user_model->get_user_client($user_id);
	}
	
	function get_user_full_name($user_id){
		$user = $this->user_model->get_user($user_id);
		return $user['first_name'].' '.$user['last_name'];	
	}
	
	function reset_password($user_id)
	{
		$temp_password = modules::run('common/generate_password');
		$password = trim($temp_password);
		$data = array('password' => $password);
		$this->user_model->update_user($user_id,$data);
		return $password;
	}
	
	function get_users($format=null)
	{
		$users = $this->user_model->get_users();
		if (!$format) {
			return $users;
		}
		if ($format == 'data_source')
		{
			$data_source = array();
			foreach($users as $user)
			{
				if ($user['is_client'])
				{
					$name = $user['company_name'];
				}
				else
				{
					$name = $user['first_name'] . ' ' . $user['last_name'];
				}
				$name = str_replace("'","", $name);
				$data_source[] = '{value:' . $user['user_id'] . ', text: \'' . $name . '\'}';
			}
			$data_source = implode(",", $data_source);
			return $data_source;
		}	
	}
	
	function field_select($field_name, $field_value=null, $size=null)
	{
		$users = $this->user_model->get_users();
		$array = array();
		foreach($users as $user)
		{
			$e['value'] = $user['user_id'];
			if ($user['is_client'])
			{
				$e['label'] = $user['company_name'];
			}
			else
			{
				$e['label'] = $user['first_name'] . ' ' . $user['last_name'];
			}
			$array[] = $e;
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	function get_users_from_user_ids($user_ids)
	{
		return $this->user_model->get_users_from_ids(implode(',',$user_ids));	
	}
		
}