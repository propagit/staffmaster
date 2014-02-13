<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Client
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
			case 'dropdown_client_departments':
				$this->dropdown_client_departments($param);
				break;
			default:
					echo 'do nothing';
				break;
		}
	}
	
	/**
	*
	*
	*
	*
	*
	*/
	function add_client() {
		$this->load->view('add_form', isset($data) ? $data : NULL);
	}
	
	
	function search_clients() {
		$this->load->view('search_form', isset($data) ? $data : NULL);
	}
	
	function edit_client($user_id) {
		$data['client'] = $this->client_model->get_client($user_id);
		$this->load->view('edit_form', isset($data) ? $data : NULL);
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
	
	function field_select($field_name, $field_value=null)
	{
		$clients = $this->client_model->search_clients();
		$array = array();
		foreach($clients as $client)
		{
			$array[] = array(
				'value' => $client['user_id'],
				'label' => $client['company_name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	/**
	*	@name: field_select_status
	*	@desc: custom select client status field
	*	@access: public
	*	@param: - $field_name
	*			- $field_value (optional)
	*			- $size (optional)
	*	@return: custom select client status field
	*/
	function field_select_status($field_name, $field_value=null, $size=null)
	{
		$array = array(
			array('value' => CLIENT_ACTIVE, 'label' => 'Active'),
			array('value' => CLIENT_INACTIVE, 'label' => 'Inactive')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['clients'] = $this->client_model->search_clients();
		$this->load->view('dropdown', isset($data) ? $data : NULL);
	}
	
	function dropdown_client_departments($client_id,$field_name, $field_value = NULL)
	{
		$data['departments'] = $this->client_model->get_client_departments($client_id);
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_departments', isset($data) ? $data : NULL);
	}
}