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
			case 'import':
					$this->import_view();
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
			case 'update_client_jobs_count':
				$this->update_client_jobs_count($param);
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
	
	function import_view() 
	{
		$this->load->view('import_view', isset($data) ? $data : NULL);
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
		return $this->client_model->get_client($client_id);
	}
	
	function get_clients()
	{
		return $this->client_model->search_clients();
	}
	
	function total_jobs($user_id) {
		return $this->client_model->get_client_total_jobs($user_id);
	}

	function delete_client($user_id)
	{
		$this->client_model->delete_client($user_id);
		$this->user_model->delete_user($user_id);
		redirect('client/search');
	}
	
	function field_select($field_name, $field_value=null)
	{
		$clients = $this->client_model->all_clients();
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
	
	function get_client_total_jobs($client_id,$year = NULL)
	{
		$sql = "select count(job_id) as total_jobs from jobs where client_id = ".$client_id;
		if($year){
			$sql .= " and year(createdon) = '".$year."'";	
		}
		$jobs = $this->db->query($sql)->row();
		if($jobs){
			return $jobs->total_jobs;	
		}else{
			return 0;	
		}
	}
	
	function update_client_jobs_count()
	{
		$clients = $this->client_model->search_clients();
		if($clients){
			foreach($clients as $c){
				$data = array(
							'total_jobs' => $this->get_client_total_jobs($c['user_id']),
							'total_jobs_current_year' => $this->get_client_total_jobs($c['user_id'],date('Y'))
							);
				$this->client_model->update_client($c['user_id'],$data);	
			}
		}
		redirect('client/search');
	}
	
	function field_select_fields($field_name, $field_value=null)
	{
		$fields = array(
			array('value' => 'company_name', 'label' => 'Company Name'),
			array('value' => 'abn', 'label' => 'ABN'),
			array('value' => 'full_name', 'label' => 'Contact name'),
			array('value' => 'phone', 'label' => 'Phone Number'),
			array('value' => 'address', 'label' => 'Address'),
			array('value' => 'suburb', 'label' => 'Suburb'),
			array('value' => 'city', 'label' => 'City'),
			array('value' => 'postcode', 'label' => 'Postcode'),
			array('value' => 'state', 'label' => 'State'),
			array('value' => 'country', 'label' => 'Country'),
			array('value' => 'email_address', 'label' => 'Email Address'),
			array('value' => 'passowrd', 'label' => 'Password'),
			array('value' => 'status', 'label' => 'Account Status'),
			array('value' => 'external_client_id', 'label' => 'External Client ID')
		);
		echo modules::run('common/field_select', $fields, $field_name, $field_value);
	}
}