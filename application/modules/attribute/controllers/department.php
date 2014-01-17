<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Department extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('department_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_department();
				break;
			case 'edit':
					$this->edit_department();
				break;
			case 'delete':
					$this->delete_department($param);
				break;
			case 'sort':
					$this->sort_departments();
				break;
			default:
					$this->list_departments();
				break;
		}
	}
	
	
	function list_departments()
	{
		$sort_department = (bool) $this->session->userdata('sort_department');
		$data['departments'] = $this->department_model->get_departments($sort_department);
		$this->load->view('list_departments', isset($data) ? $data : NULL);
	}
	
	function sort_departments()
	{
		if (!$this->session->userdata('sort_department'))
		{
			$this->session->set_userdata('sort_department', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_department');
		}
		redirect('attribute/department');
	}
	
	function add_department()
	{
		$data = $this->input->post();
		$this->department_model->insert_department($data);
		redirect('attribute/department');
	}
	
	function edit_department()
	{
		$data = $this->input->post();
		$this->department_model->update_department($data['department_id'], $data);
		redirect('attribute/department');
	}
	
	function delete_department($department_id)
	{
		$this->department_model->delete_department($department_id);
		redirect('attribute/department');
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['departments'] = $this->department_model->get_departments();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_departments', isset($data) ? $data : NULL);
	}
	
}