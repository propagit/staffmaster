<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Form
 */

class Form extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('form_model');
		$this->load->model('attribute/custom_field_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'edit':
					$this->edit_view($param);
				break;
			case 'applicant':
					$this->applicant_list_view();
				break;
			default:
					$this->main_view();
				break;
		}
	}
	
	function main_view()
	{
		$data['forms'] = $this->form_model->get_forms();
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function edit_view($form_id)
	{
		$data['form'] = $this->form_model->get_form($form_id);
		$fields = $this->form_model->get_fields($form_id);
		$data['personal_fields'] = $this->personal_fields($fields);
		$data['extra_fields'] = $this->extra_fields($fields);
		#$data['financial_fields'] = $this->financial_fields();
		#$data['super_fields'] = $this->super_fields();
		$data['custom_fields'] = $this->form_model->get_custom_fields();
		$data['url'] = str_replace('http:','',base_url()) . 'public/form/' . $form_id;
		$this->load->view('edit_view', isset($data) ? $data : NULL);
	}
	
	function personal_fields($fields = array())
	{
		$personal = array(
			'title' => array('label' => 'Title'),
			'gender' => array('label' => 'Gender'),
			'first_name' => array('label' => 'First Name'),
			'last_name' => array('label' => 'Last Name'),
			'dob' => array('label' => 'Date Of Birth'),
			'address' => array('label' => 'Address'),
			'suburb' => array('label' => 'Suburb'),
			'postcode' => array('label' => 'Postcode'),
			'state' => array('label' => 'State'),
			'country' => array('label' => 'Country'),
			'phone' => array('label' => 'Telephone'),
			'mobile' => array('label' => 'Mobile Phone'),
			'email' => array('label' => 'Email'),
			'password' => array('label' => 'Password'),
			'emergency_contact' => array('label' => 'Emergency Contact'),
			'emergency_phone' => array('label' => 'Emergency Phone')
		);
		if (count($fields) > 0) {
			foreach($fields as $field) {
				if (isset($personal[$field['name']])) {
					$personal[$field['name']]['active'] = 1;
					$personal[$field['name']]['form_field_id'] = $field['form_field_id'];
					if ($field['required']) {
						$personal[$field['name']]['required'] = 1;
					}	
				}							
			}
		}
		return $personal;
	}
	
	function extra_fields($fields = array())
	{
		$extra = array(
			'picture' => array('label' => 'Pictures'),
			'role' => array('label' => 'Roles'),
			'availability' => array('label' => 'Availability'),
			'location' => array('label' => 'Locations'),
			'group' => array('label' => 'Groups') 
		);
		if (count($fields) > 0) {
			foreach($fields as $field) {
				if (isset($extra[$field['name']])) {
					$extra[$field['name']]['active'] = 1;
					$extra[$field['name']]['form_field_id'] = $field['form_field_id'];
					if ($field['required']) {
						$extra[$field['name']]['required'] = 1;
					}	
				}							
			}
		}
		return $extra;
	}
	
	function financial_fields()
	{
		return array(
			'f_acc_name' => 'Account Name',
			'f_acc_number' => 'Account Number',
			'f_bsb' => 'BSB',
			'f_employed' => 'Employed As'			
		);
	}
	
	function super_fields()
	{
		return array(
			's_choice' => 'Superannuation Choice',
			's_name' => 'Name'
		);
	}
	
	function applicant_list_view()
	{
		$data['applicants'] = $this->form_model->get_applicants();
		$this->load->view('applicant/list_view', isset($data) ? $data : NULL);
	}
}