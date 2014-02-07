<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Role extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('role_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_role();
				break;
			case 'edit':
					$this->edit_role();
				break;
			case 'delete':
					$this->delete_role($param);
				break;
			case 'sort':
					$this->sort_roles();
				break;
			default:
					$this->list_roles();
				break;
		}
	}
	
	function list_roles()
	{
		$sort_role = (bool) $this->session->userdata('sort_role');
		$data['roles'] = $this->role_model->get_roles($sort_role);
		$this->load->view('list_roles', isset($data) ? $data : NULL);
	}
	
	function sort_roles()
	{
		if (!$this->session->userdata('sort_role'))
		{
			$this->session->set_userdata('sort_role', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_role');
		}
		redirect('attribute/role');
	}

	function add_role()
	{
		$data = $this->input->post();
		$this->role_model->insert_role($data);
		redirect('attribute/role');
	}
	
	function edit_role()
	{
		$data = $this->input->post();
		$this->role_model->update_role($data['role_id'], $data);
		redirect('attribute/role');
	}
	
	function delete_role($role_id)
	{
		$this->role_model->delete_role($role_id);
		redirect('attribute/role');
	}
	
	function get_roles($format=null)
	{
		$roles = $this->role_model->get_roles();
		if (!$format) {
			return $roles;
		}
		if ($format == 'data_source')
		{
			$data_source = array();
			foreach($roles as $role)
			{
				$data_source[] = '{value:' . $role['role_id'] . ', text: \'' . $role['name'] . '\'}';
			}
			$data_source = implode(",", $data_source);
			return $data_source;
		}	
	}
	
	function display_role($role_id)
	{
		$role = $this->get_role($role_id);
		echo ($role) ? $role['name'] : 'Not Specified';
	}
	function get_role($role_id)
	{
		return $this->role_model->get_role($role_id);
	}
	
	function field_select($field_name, $field_value=null)
	{
		$roles = $this->role_model->get_roles();
		$array = array();
		foreach($roles as $role)
		{
			$array[] = array(
				'value' => $role['role_id'],
				'label' => $role['name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}	
}