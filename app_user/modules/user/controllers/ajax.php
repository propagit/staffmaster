<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	
	function create_sub_user()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'username', 'label' => 'Username', 'rules' => 'required'),
			array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
			array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required')
		));
		if ($this->form_validation->run($this) == FALSE)
		{
			$this->form_validation->set_error_delimiters('', '');
			echo json_encode(array(
				'result' => false,
				'username' => form_error('username'),
				'email' => form_error('email'),
				'password' => form_error('password'),
				'first_name' => form_error('first_name'),
				'last_name' => form_error('last_name')
			));			
		}
		else
		{
			if ($this->user_model->check_username($this->input->post('username')))
			{
				echo json_encode(array(
					'result' => false,
					'username' => 'This username has already been used'
				));	
			}
			else
			{
				$data = array(
					'parent_id' => $this->input->post('user_id'),
					'username' => $this->input->post('username'),
					'company_email' => $this->input->post('email'),
					'password' => $this->input->post('password'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name')
				);
				
				if ($this->user_model->insert_user($data))
				{
					echo json_encode(array(
						'result' => true
					));
				}
			}			
		}
		
	}
		
}