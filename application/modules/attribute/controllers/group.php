<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Group extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('group_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_group();
				break;
			case 'edit':
					$this->edit_group();
				break;
			case 'delete':
					$this->delete_group($param);
				break;
			case 'sort':
					$this->sort_groups();
				break;
			default:
					$this->list_groups();
				break;
		}
	}
	
	
	function list_groups()
	{
		$this->load->view('groups/list_groups', isset($data) ? $data : NULL);
	}
	
	/* function sort_groups()
	{
		if (!$this->session->userdata('sort_group'))
		{
			$this->session->set_userdata('sort_group', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_group');
		}
		redirect('attribute/group');
	}
	
	function add_group()
	{
		$data = $this->input->post();
		$this->group_model->insert_group($data);
		redirect('attribute/group');
	} */
	
	/* function edit_group()
	{
		$data = $this->input->post();
		$this->group_model->update_group($data['group_id'], $data);
		redirect('attribute/group');
	} */
	
	/* function delete_group($group_id)
	{
		$this->group_model->delete_group($group_id);
		redirect('attribute/group');
	} */
		
	function field_select($field_name, $field_value=null)
	{
		$groups = $this->group_model->get_groups();
		$array = array();
		foreach($groups as $group)
		{
			$array[] = array(
				'value' => $group['group_id'],
				'label' => $group['name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
}