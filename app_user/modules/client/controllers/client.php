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
			case 'remove_duplicate':
				$this->remove_duplicate();
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
	
	function get_client_by_external_id($external_id)
	{
		return $this->client_model->get_client_by_external_id($external_id);
	}
	
	
	function get_client($client_id)
	{
		return $this->client_model->get_client($client_id);
	}
	
	function get_clients()
	{
		return $this->client_model->search_clients();
	}
	
	function get_total_client()
	{
		return $this->client_model->get_total_clients_count();
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
		$clients = $this->get_clients();
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
	
	function menu_dropdown($id, $label) {
		$clients = $this->get_clients();
		$data = array();
		$data[] = array('value' => '', 'label' => 'Any');
		foreach($clients as $client)
		{
			$data[] = array(
				'value' => $client['user_id'],
				'label' => $client['company_name']
			);
		}		
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	function menu_dropdown_departments($user_id, $id, $label) 
	{
		$departments = $this->get_departments($user_id);
		$data = array();
		$data[] = array('value' => '', 'label' => 'Any');
		foreach($departments as $department)
		{
			$data[] = array(
				'value' => $department['department_id'],
				'label' => $department['name']
			);
		}
		return modules::run('common/menu_dropdown', $data, $id, $label);
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
		return $this->client_model->get_client_total_jobs_by_client_id_and_year($client_id,$year);
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
	
	function get_departments($user_id)
	{
		return $this->client_model->get_client_departments($user_id);
	}
	
	function field_select_departments($user_id, $field_name, $field_value=null)
	{
		$departments = $this->get_departments($user_id);
		$data = array();
		foreach($departments as $department)
		{
			$data[] = array('value' => $department['department_id'], 'label' => $department['name']);
		}
		echo modules::run('common/field_select', $data, $field_name, $field_value);
	}
	
	function field_select_export_templates($field_name, $field_value = null) 
	{		
		$this->load->model('export/export_model');
		$data['templates'] = $this->export_model->get_templates('client');
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('field_select_export_templates', isset($data) ? $data : NULL);
	}
	
	function btn_api($user_id='', $external_id='')
	{
		$platform = $this->config_model->get('accounting_platform');
		
		if (!$platform)
		{
			return;
		}
		$existed = false;
		if ($platform == 'shoebooks')
		{
			if ($external_id)
			{
				$external_id = modules::run('api/shoebooks/read_customer', $external_id);
			}
		}
		if ($platform == 'myob')
		{
			if (!$this->config_model->get('myob_company_id'))
			{
				return;
			}
			if ($external_id)
			{
				$external_id = modules::run('api/myob/connect', 'read_customer~' . $external_id);
			}
			
			$platform = 'MYOB';
		}
		$data['user_id'] = $user_id;
		$data['external_id'] = $external_id;
		$data['platform'] = $platform;
		$this->load->view('btn_api', isset($data) ? $data : NULL);
	}
	
	# function to remove duplicate client
	function _remove_duplicate()
	{
		$this->load->library('excel');
		$file_name = UPLOADS_PATH.'/tmp/CUST.csv';
		$savedValueBinder = PHPExcel_Cell::getValueBinder();
        PHPExcel_Cell::setValueBinder(new TextValueBinder());
		
        
		$objReader = PHPExcel_IOFactory::createReader('CSV');
		$objPHPExcel = $objReader->load($file_name);
		
		PHPExcel_Cell::setValueBinder($savedValueBinder);
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);	
		# echo '<pre>' . print_r($sheetData,true) . '</pre>';
		$count = 0;
		foreach($sheetData as $data){
			$clients = $this->client_model->get_client_by_company($data['A']);
			if($clients){
				foreach($clients as $c){
					if($c['external_client_id'])	{
						if($c['external_client_id'] != $data['B']){
							$this->client_model->delete_client($c['user_id']);
							echo 'removed - ' . $c['user_id'] . $c['external_client_id'] . '<br>';	
							$count++;
						}
					}
				}
			}
		}
		echo 'total - ' . $count;
	}
}