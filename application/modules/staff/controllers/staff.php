<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('staff_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_staff();
				break;
			case 'search':
					$this->search_staffs();
				break;
			case 'edit':
					$this->edit_staff($param);
				break;
			default:
					echo 'do nothing';
				break;
		}
	}
	
	function add_staff()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'title', 'label' => 'Title', 'rules' => ''),
			array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required'),
			array('field' => 'gender', 'label' => 'Gender', 'rules' => 'required'),
			array('field' => 'dob_day', 'label' => 'DOB Day', 'rules' => ''),
			array('field' => 'dob_month', 'label' => 'DOB Month', 'rules' => ''),
			array('field' => 'dob_year', 'label' => 'DOB Year', 'rules' => ''),
			array('field' => 'address', 'label' => 'Address', 'rules' => ''),
			array('field' => 'suburb', 'label' => 'Suburb', 'rules' => ''),
			array('field' => 'city', 'label' => 'Suburb', 'rules' => ''),
			array('field' => 'state', 'label' => 'State', 'rules' => ''),
			array('field' => 'country', 'label' => 'Country', 'rules' => ''),
			array('field' => 'postcode', 'label' => 'Postcode', 'rules' => ''),
			array('field' => 'phone', 'label' => 'Phone', 'rules' => ''),
			array('field' => 'email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
			array('field' => 'department_id', 'label' => 'Department', 'rules' => ''),
			array('field' => 'role', 'label' => 'Role', 'rules' => ''),
			array('field' => 'external_staff_id', 'label' => 'External Staff ID', 'rules' => ''),
			array('field' => 'emergency_contact', 'label' => 'Emergency Contact', 'rules' => ''),
			array('field' => 'emergency_phone', 'label' => 'Emergency Phone', 'rules' => '')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			if ($this->user_model->check_username($this->input->post('email_address')))
			{
				$data['username_exist'] = true;
			}
			else
			{
				$data = $this->input->post();
				$user_data = array(
					'status' => 1,
					'is_admin' => 0,
					'is_staff' => 1,
					'is_client' => 0,
					'email_address' => $data['email_address'],
					'username' => $data['email_address'],
					'password' => $data['password'],
					'title' => $data['title'],
					'first_name' => $data['first_name'],
					'last_name' => $data['last_name'],
					'address' => $data['address'],
					'suburb' => $data['suburb'],
					'city' => $data['city'],
					'state' => $data['state'],
					'postcode' => $data['postcode'],
					'country' => $data['country'],
					'phone' => $data['phone']					
				);
				$user_id = $this->user_model->insert_user($user_data);
				$staff_data = array(
					'user_id' => $user_id,
					'external_staff_id' => $data['external_staff_id'],
					'gender' => $data['gender'],
					'dob' => $data['dob_day'] . '-' . $data['dob_month'] . '-' . $data['dob_year'],
					'department_id' => $data['department_id'],
					'role' => $data['role'],
					'emergency_contact' => $data['emergency_contact'],
					'emergency_phone' => $data['emergency_phone']
				);
				$staff_id = $this->staff_model->insert_staff($staff_data);
				redirect('staff/edit/' . $user_id);
			}
		}
		
		$data['states'] = $this->user_model->get_states();
		$data['countries'] = $this->user_model->get_countries();
		$this->load->view('add', isset($data) ? $data : NULL);
	}
	
	function search_staffs()
	{
		if ($this->input->post())
		{
			$data['staffs'] = $this->staff_model->search_staffs($this->input->post());
		}
		
		$this->load->view('search', isset($data) ? $data : NULL);
	}
	
	function edit_staff($user_id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'title', 'label' => 'Title', 'rules' => ''),
			array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required'),
			array('field' => 'gender', 'label' => 'Gender', 'rules' => 'required'),
			array('field' => 'dob_day', 'label' => 'DOB Day', 'rules' => ''),
			array('field' => 'dob_month', 'label' => 'DOB Month', 'rules' => ''),
			array('field' => 'dob_year', 'label' => 'DOB Year', 'rules' => ''),
			array('field' => 'address', 'label' => 'Address', 'rules' => ''),
			array('field' => 'suburb', 'label' => 'Suburb', 'rules' => ''),
			array('field' => 'city', 'label' => 'Suburb', 'rules' => ''),
			array('field' => 'state', 'label' => 'State', 'rules' => ''),
			array('field' => 'country', 'label' => 'Country', 'rules' => ''),
			array('field' => 'postcode', 'label' => 'Postcode', 'rules' => ''),
			array('field' => 'phone', 'label' => 'Phone', 'rules' => ''),
			array('field' => 'password', 'label' => 'Password', 'rules' => ''),
			array('field' => 'department_id', 'label' => 'Department', 'rules' => ''),
			array('field' => 'role', 'label' => 'Role', 'rules' => ''),
			array('field' => 'external_staff_id', 'label' => 'External Staff ID', 'rules' => ''),
			array('field' => 'emergency_contact', 'label' => 'Emergency Contact', 'rules' => ''),
			array('field' => 'emergency_phone', 'label' => 'Emergency Phone', 'rules' => '')
		));
		if ($this->form_validation->run($this) == FALSE)
		{	
		}
		else
		{
			$data = $this->input->post();
			$user_data = array(
				'password' => $data['password'],
				'title' => $data['title'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
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
			$staff_data = array(
				'external_staff_id' => $data['external_staff_id'],
				'gender' => $data['gender'],
				'dob' => $data['dob_day'] . '-' . $data['dob_month'] . '-' . $data['dob_year'],
				'department_id' => $data['department_id'],
				'role' => $data['role'],
				'emergency_contact' => $data['emergency_contact'],
				'emergency_phone' => $data['emergency_phone'],
				'f_aus_resident' => isset($data['f_aus_resident']) ? $data['f_aus_resident'] : 0,
				'f_tax_free_threshold' => isset($data['f_tax_free_threshold']) ? $data['f_tax_free_threshold'] : 0,
				'f_tax_offset' => isset($data['f_tax_offset']) ? $data['f_tax_offset'] : 0,
				'f_senior_status' => isset($data['f_senior_status']) ? $data['f_senior_status'] : '',
				'f_help_debt' => isset($data['f_help_debt']) ? $data['f_help_debt'] : 0,
				'f_help_variation' => isset($data['f_help_variation']) ? $data['f_help_variation'] : '',
				'f_acc_name' => $data['f_acc_name'],
				'f_bsb' => $data['f_bsb'],
				'f_acc_number' => $data['f_acc_number'],
				'f_tfn_1' => $data['f_tfn_1'],
				'f_tfn_2' => $data['f_tfn_2'],
				'f_tfn_3' => $data['f_tfn_3'],
				's_choice' => isset($data['s_choice']) ? $data['s_choice'] : '',
				's_name' => $data['s_name'],
				's_employee_id' => $data['s_employee_id'],
				's_tfn_1' => $data['s_tfn_1'],
				's_tfn_2' => $data['s_tfn_2'],
				's_tfn_3' => $data['s_tfn_3'],
				's_fund_name' => $data['s_fund_name'],
				's_fund_website' => $data['s_fund_website'],
				's_product_id' => $data['s_product_id'],
				's_fund_phone' => $data['s_fund_phone'],
				's_membership' => $data['s_membership'],
				's_fund_address' => $data['s_fund_address'],
				's_fund_suburb' => $data['s_fund_suburb'],
				's_fund_state' => $data['s_fund_state'],
				's_agree' => isset($data['s_agree']) ? $data['s_agree'] : 0,
				'availability' => isset($data['availability']) ? json_encode($data['availability']) : '',
				'payrates' => isset($data['payrates']) ? json_encode($data['payrates']) : '',
				'roles' => isset($data['roles']) ? json_encode($data['roles']) : '',
				'locations' => isset($data['locations']) ? json_encode($data['locations']) : ''
			);
			$this->staff_model->update_staff($user_id, $staff_data);
		}
		$staff = $this->staff_model->get_staff($user_id);
		$data['staff'] = $staff;
		$this->load->view('edit', isset($data) ? $data : NULL);
	}

	function delete_client($user_id)
	{
		$this->client_model->delete_client($user_id);
		$this->user_model->delete_user($user_id);
		redirect('client/search');
	}
}