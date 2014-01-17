<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'create':
					$this->create_user();
				break;
			case 'create_sub_user':
					$this->create_sub_user();
				break;
			case 'edit_sub_user':
					$this->edit_sub_user($param);
				break;
			case 'edit':
					$this->edit_user($param);
				break;
			case 'delete':
					$this->delete_user($param);
				break;
			default:
					$this->users_list();
				break;
		}
	}
	
	function create_user()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'company_name', 'label' => 'Company Name', 'rules' => ''),
			array('field' => 'company_abn', 'label' => 'Company ABN', 'rules' => ''),
			array('field' => 'company_email', 'label' => 'Company Email', 'rules' => 'required|valid_email'),
			array('field' => 'company_phone', 'label' => 'Company Phone', 'rules' => ''),
			array('field' => 'address', 'label' => 'Address', 'rules' => ''),
			array('field' => 'suburb', 'label' => 'Suburb', 'rules' => ''),
			array('field' => 'state', 'label' => 'State', 'rules' => ''),
			array('field' => 'postcode', 'label' => 'Postcode', 'rules' => ''),
			array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'last_name', 'label' => 'Family Name', 'rules' => 'required'),
			array('field' => 'service', 'label' => 'Service', 'rules' => ''),
			array('field' => 'username', 'label' => 'Username', 'rules' => 'required'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			if ($this->user_model->check_username($this->input->post('username')))
			{
				$data['username_exist'] = true;
			}
			else
			{
				$data = $this->input->post();
				$this->user_model->insert_user($data);
				redirect('admin/user');
			}			
		}
		
		$data['states'] = $this->user_model->get_states();
		$this->load->view('admin_create_user_form', $data);
	}
	
	function create_sub_user()
	{
		$data = array(
			'parent_id' => $this->input->post('parent_id'),
			'username' => $this->input->post('sub_username'),
			'company_email' => $this->input->post('sub_email'),
			'password' => $this->input->post('sub_password'),
			'first_name' => $this->input->post('sub_first_name'),
			'last_name' => $this->input->post('sub_last_name')
		);
		if ($this->user_model->insert_user($data))
		{
			redirect('admin/user/edit/' . $this->input->post('parent_id'));
		}
		else
		{
			echo '<div class="alert alert-error">There was an error creating a sub user</div>';
		}
	}
	
	function edit_sub_user($parent_user_id)
	{
		$user_id = $this->input->post('sub_user_id');
		$data = array(
			'company_email' => $this->input->post('sub_email'),
			'password' => $this->input->post('sub_password'),
			'first_name' => $this->input->post('sub_first_name'),
			'last_name' => $this->input->post('sub_last_name')
		);
		if ($this->user_model->update_user($user_id, $data))
		{
			redirect('admin/user/edit/' . $parent_user_id);
		}
	}
	
	function edit_user($user_id='')
	{
		$user = $this->user_model->get_user($user_id);
		if (!$user)
		{
			redirect('admin/user');
		}
		if ($this->input->post())
		{
			$data = $this->input->post();
			if ($this->user_model->update_user($user_id, $data))
			{
				$data['updated'] = true;
				$data['user_id'] = $user_id;
				$data['username'] = $user['username'];
				$user = $data;
			}
		}
		$data['user'] = $user;
		$data['states'] = $this->user_model->get_states();
		$data['sub_users'] = $this->user_model->get_sub_users($user_id);
		$this->load->view('admin_edit_user', $data);
	}
	
	function delete_user($user_id='')
	{
		$user = $this->user_model->get_user($user_id);
		if (!$user)
		{
			redirect('admin/user');
		}
		if (file_exists('./uploads/logos/' . $user['logo_url']))
		{
			unlink('./uploads/logos/' . $user['logo_url']);
		}
		$this->user_model->delete_user($user_id);
		redirect('admin/user/edit/' . $user['parent_id']);
	}
	
	function users_list()
	{
		$data['users'] = $this->user_model->get_users();
		$this->load->view('admin_users_list', $data);
	}
		
}