<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('profile/profile_model');
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
				
				$company_profile = $this->profile_model->get_profile();
				
				
				$staff_data = array(
					'user_id' => $user_id,
					'external_staff_id' => $data['external_staff_id'],
					'gender' => $data['gender'],
					'dob' => $data['dob_day'] . '-' . $data['dob_month'] . '-' . $data['dob_year'],
					'department_id' => $data['department_id'],
					'role' => $data['role'],
					'emergency_contact' => $data['emergency_contact'],
					'emergency_phone' => $data['emergency_phone'],
					's_choice' => 'employer',
					's_name' =>  $data['first_name'].' '.$data['last_name'],
					's_fund_name' => $company_profile['super_name']
					
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
		error_reporting(E_ALL);
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'title', 'label' => 'Title', 'rules' => ''),
			array('field' => 'rating', 'label' => 'Rating', 'rules' => ''),
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
			array('field' => 'email_address', 'label' => 'Email', 'rules' => 'required|valid_email'),			
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
			//print_r($data);
			//$avail = array();
			//$avail['day'] = 1;
			$avail = array();
			$avail[0]['day'] =1;
			$avail[0]['time'][0] =$data['monday_start_at'].','.$data['monday_finish_at'];

			$avail[1]['day'] =2;
			$avail[1]['time'][0] =$data['tuesday_start_at'].','.$data['tuesday_finish_at'];
			
			$avail[2]['day'] =3;
			$avail[2]['time'][0] =$data['wednesday_start_at'].','.$data['wednesday_finish_at'];
			
			$avail[3]['day'] =4;
			$avail[3]['time'][0] =$data['thursday_start_at'].','.$data['thursday_finish_at'];
			
			$avail[4]['day'] =5;
			$avail[4]['time'][0] =$data['friday_start_at'].','.$data['friday_finish_at'];
			
			$avail[5]['day'] =6;
			$avail[5]['time'][0] =$data['saturday_start_at'].','.$data['saturday_finish_at'];
			
			$avail[6]['day'] =7;
			$avail[6]['time'][0] =$data['sunday_start_at'].','.$data['sunday_finish_at'];

			
			
			
			
			//if($data['monday_start_at'] > $data['monday_finish_at']){}
			
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
			$loc = explode('#',$data['area_code']);
			$lc=array();
			foreach($loc as $l)
			{
				if(!in_array($l,$lc))
				{
					$lc[]=$l;
				}
			}
			
			
			$staff_data = array(
				'rating' => $data['rating'],
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
				'f_employed' => $data['f_employed'],
				'f_abn_1' => $data['f_abn_1'],
				'f_abn_2' => $data['f_abn_2'],
				'f_abn_3' => $data['f_abn_3'],
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
				's_fund_postcode' => $data['s_fund_postcode'],
				's_agree' => isset($data['s_agree']) ? $data['s_agree'] : 0,
				'availability' => isset($avail) ? json_encode($avail) : '',
				'payrates' => isset($data['payrates']) ? json_encode($data['payrates']) : '',
				'roles' => isset($data['roles']) ? json_encode($data['roles']) : '',
				//'locations' => isset($data['locations']) ? json_encode($data['locations']) : ''
				'locations' => isset($lc) ? json_encode($lc) : ''
			);
			$this->staff_model->update_staff($user_id, $staff_data);
		}
		$staff = $this->staff_model->get_staff($user_id);
		$photos = $this->staff_model->get_all_photos($staff['staff_id']);
		$hero_photo = $this->staff_model->get_hero($staff['staff_id']);
		$data['hero_photo'] = $hero_photo;
		$data['photos'] =$photos;
		$data['staff'] = $staff;
		$this->load->view('edit', isset($data) ? $data : NULL);
	}
	
	function get_staff($user_id)
	{
		return $this->staff_model->get_staff($user_id);
	}

	function delete_client($user_id)
	{
		$this->client_model->delete_client($user_id);
		$this->user_model->delete_user($user_id);
		redirect('client/search');
	}
}