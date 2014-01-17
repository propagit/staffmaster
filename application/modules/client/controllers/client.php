<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Client extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('client_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_client();
				break;
			case 'search':
					$this->search_clients();
				break;
			case 'edit':
					$this->edit_client($param);
				break;
			case 'delete':
					$this->delete_client($param);
				break;
			default:
					echo 'do nothing';
				break;
		}
	}
	
	function add_client()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'company_name', 'label' => 'Company Name', 'rules' => 'required'),
			array('field' => 'address', 'label' => 'Address', 'rules' => 'required'),
			array('field' => 'suburb', 'label' => 'Suburb', 'rules' => 'required'),
			array('field' => 'city', 'label' => 'Suburb', 'rules' => 'required'),
			array('field' => 'state', 'label' => 'State', 'rules' => ''),
			array('field' => 'country', 'label' => 'Country', 'rules' => ''),
			array('field' => 'postcode', 'label' => 'Postcode', 'rules' => 'required'),
			array('field' => 'abn', 'label' => 'ABN', 'rules' => 'required'),
			array('field' => 'full_name', 'label' => 'Contact Name', 'rules' => ''),
			array('field' => 'phone', 'label' => 'Phone', 'rules' => 'required'),
			array('field' => 'email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email'),
			array('field' => 'username', 'label' => 'Username', 'rules' => 'required'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
			array('field' => 'external_client_id', 'label' => 'External Client ID', 'rules' => ''),
			array('field' => 'invoice_auto_send', 'label' => 'Auto Send Invoices', 'rules' => ''),
			array('field' => 'status', 'label' => 'Status', 'rules' => '')
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
				$user_data = array(
					'status' => $data['status'],
					'is_admin' => 0,
					'is_staff' => 0,
					'is_client' => 1,
					'email_address' => $data['email_address'],
					'username' => $data['username'],
					'password' => $data['password'],
					'full_name' => $data['full_name'],
					'address' => $data['address'],
					'suburb' => $data['suburb'],
					'city' => $data['city'],
					'state' => $data['state'],
					'postcode' => $data['postcode'],
					'country' => $data['country'],
					'phone' => $data['phone']					
				);
				$user_id = $this->user_model->insert_user($user_data);
				$client_data = array(
					'user_id' => $user_id,
					'external_client_id' => $data['external_client_id'],
					'company_name' => $data['company_name'],
					'invoice_auto_send' => $data['invoice_auto_send'],
					'abn' => $data['abn']
				);
				$client_id = $this->client_model->insert_client($client_data);
				redirect('client/search');
			}			
		}

		$this->load->view('add', isset($data) ? $data : NULL);
	}
	
	function search_clients()
	{
		if ($this->input->post())
		{
			$data['clients'] = $this->client_model->search_clients($this->input->post('keyword'));	
		}
		
		$this->load->view('search', isset($data) ? $data : NULL);
	}
	
	function edit_client($user_id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'company_name', 'label' => 'Company Name', 'rules' => 'required'),
			array('field' => 'address', 'label' => 'Address', 'rules' => 'required'),
			array('field' => 'suburb', 'label' => 'Suburb', 'rules' => 'required'),
			array('field' => 'city', 'label' => 'Suburb', 'rules' => 'required'),
			array('field' => 'state', 'label' => 'State', 'rules' => ''),
			array('field' => 'country', 'label' => 'Country', 'rules' => ''),
			array('field' => 'postcode', 'label' => 'Postcode', 'rules' => 'required'),
			array('field' => 'abn', 'label' => 'ABN', 'rules' => 'required'),
			array('field' => 'full_name', 'label' => 'Contact Name', 'rules' => ''),
			array('field' => 'phone', 'label' => 'Phone', 'rules' => 'required'),
			array('field' => 'email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email'),
			array('field' => 'external_client_id', 'label' => 'External Client ID', 'rules' => ''),
			array('field' => 'invoice_auto_send', 'label' => 'Auto Send Invoices', 'rules' => ''),
			array('field' => 'status', 'label' => 'Status', 'rules' => '')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			$data = $this->input->post();
			$user_data = array(
				'status' => $data['status'],
				'email_address' => $data['email_address'],
				'password' => $data['password'],
				'full_name' => $data['full_name'],
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'city' => $data['city'],
				'state' => $data['state'],
				'postcode' => $data['postcode'],
				'country' => $data['country'],
				'phone' => $data['phone'],
				'modified_on' => date('Y-m-d H:i:s')			
			);
			$this->user_model->update_user($user_id,$user_data);
			$client_data = array(
				'user_id' => $user_id,
				'external_client_id' => $data['external_client_id'],
				'company_name' => $data['company_name'],
				'invoice_auto_send' => $data['invoice_auto_send'],
				'abn' => $data['abn']
			);
			$this->client_model->update_client($user_id, $client_data);
		}
		$client = $this->client_model->get_client($user_id);
		$data['client'] = $client;
		$this->load->view('edit', isset($data) ? $data : NULL);
	}
	
	function get_client($client_id)
	{
		return $this->client_model->get_client_by_client_id($client_id);
	}

	function delete_client($user_id)
	{
		$this->client_model->delete_client($user_id);
		$this->user_model->delete_user($user_id);
		redirect('client/search');
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['clients'] = $this->client_model->search_clients();
		$this->load->view('dropdown', isset($data) ? $data : NULL);
	}
}