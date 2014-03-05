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
		$this->load->model('formbuilder/formbuilder_model');
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
			case 'upload_custom_document':
					$this->upload_custom_document();
				break;	
			case 'delete_custom_document':
					$this->delete_custom_document($param);
				break;	
			case 'send_email':
					$this->send_email();
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
					'dob' => date('Y-m-d',strtotime($data['dob_year'].'-'.$data['dob_month']. '-'.$data['dob_day'])),
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
		
		
		$this->load->view('add_form', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_staffs
	*	@desc: function to load search staffs form
	*	@access: private
	*	@param: (POST) array of search parameters
	*	@return: (void) load search staffs form
	*/
	private function search_staffs()
	{
		$data['weekdays'] = array(
							array('value' => 1, 'label' => 'Monday'),
							array('value' => 2, 'label' => 'Tuesday'),
							array('value' => 3, 'label' => 'Wednesday'),
							array('value' => 4, 'label' => 'Thursday'),
							array('value' => 5, 'label' => 'Friday'),
							array('value' => 6, 'label' => 'Saturday'),
							array('value' => 7, 'label' => 'Sunday')
							);
		$data['age_groups'] = array(
							array('value' => '0-17', 'label' => 'Under 18 Years Old'),
							array('value' => '18-25', 'label' => '18 - 25 Years Old'),
							array('value' => '26-35', 'label' => '26 - 35 Years Old'),
							array('value' => '36-100', 'label' => '35+ Years Old')
							);
		$this->load->view('search_form', isset($data) ? $data : NULL);
	}
	
	function edit_staff($user_id)
	{
		$data['staff'] = $this->staff_model->get_staff($user_id);
		$this->load->view('edit_form', isset($data) ? $data :NULL);
	}
	
	function edit_staff_backup($user_id) {
		//error_reporting(E_ALL);
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
			
			$staff = $this->staff_model->get_staff($user_id);
			$data = $this->input->post();
			
			$mon = $this->input->post('monday_time');
			$mons = explode('#',$mon);
			$monday = array();
			foreach($mons as $mn)
			{
				if($mn!="" && $mn!=" ")
				{
					$monday[] = $mn;
				}
			}
			
			$tue = $this->input->post('tuesday_time');
			$tues = explode('#',$tue);
			$tuesday = array();
			foreach($tues as $tu)
			{
				if($tu!="" && $tu!=" ")
				{
					$tuesday[] = $tu;
				}
			}
			
			$wed = $this->input->post('wednesday_time');
			$weds = explode('#',$wed);
			$wednesday = array();
			foreach($weds as $we)
			{
				if($we!="" && $we!=" ")
				{
					$wednesday[] = $we;
				}
			}
			
			$thu = $this->input->post('thursday_time');
			$thurs = explode('#',$thu);
			$thursday = array();
			foreach($thurs as $th)
			{
				if($th!="" && $th!=" ")
				{
					$thursday[] = $th;
				}
			}
			
			$fri = $this->input->post('friday_time');
			$frid = explode('#',$fri);
			$friday = array();
			foreach($frid as $fr)
			{
				if($fr!="" && $fr!=" ")
				{
					$friday[] = $fr;
				}
			}
			
			$sat = $this->input->post('saturday_time');
			$satu = explode('#',$sat);
			$saturday = array();
			foreach($satu as $st)
			{
				if($st!="" && $st!=" ")
				{
					$saturday[] = $st;
				}
			}
			
			$sun = $this->input->post('sunday_time');
			$sund = explode('#',$sun);
			$sunday = array();
			foreach($sund as $su)
			{
				if($su!="" && $su!=" ")
				{
					$sunday[] = $su;
				}
			}
			
			$availability_data = array(
				'monday' => json_encode($monday),
				'tuesday' => json_encode($tuesday),
				'wednesday' => json_encode($wednesday),
				'thursday' => json_encode($thursday),
				'friday' => json_encode($friday),
				'saturday' => json_encode($saturday),
				'sunday' => json_encode($sunday),
				'staff_id' => $staff['staff_id'],
			);
			$this->staff_model->update_user_availability($staff['staff_id'],$availability_data);
			
			
			
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
				//'availability' => isset($avail) ? json_encode($avail) : '',
				'payrates' => isset($data['payrates']) ? json_encode($data['payrates']) : '',
				'roles' => isset($data['roles']) ? json_encode($data['roles']) : '',
				//'locations' => isset($data['locations']) ? json_encode($data['locations']) : ''
				'locations' => isset($lc) ? json_encode($lc) : ''
			);
			$this->staff_model->update_staff($user_id, $staff_data);
		}
		$staff = $this->staff_model->get_staff($user_id);
		$staff_availability = $this->staff_model->get_staff_availability($staff['staff_id']);
		if(count($staff_availability)==0){$staff_availability='';}
		$photos = $this->staff_model->get_all_photos($staff['staff_id']);
		$hero_photo = $this->staff_model->get_hero($staff['staff_id']);
		$data['hero_photo'] = $hero_photo;
		$data['photos'] =$photos;
		$data['staff'] = $staff;
		$data['staff_availability'] = $staff_availability;
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
	
	/**
	*	@name: field_select_status
	*	@desc: custom select staff status field
	*	@access: public
	*	@param: - $field_name
	*			- $field_value (optional)
	*			- $size (optional)
	*	@return: custom select staff status field
	*/
	function field_select_status($field_name, $field_value=null, $size=null)
	{
		$array = array(
			array('value' => STAFF_ACTIVE, 'label' => 'Active'),
			array('value' => STAFF_PENDING, 'label' => 'Pending'),
			array('value' => STAFF_INACTIVE, 'label' => 'Inactive')
		);
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function menu_dropdown_tfn($id, $label) {
		$array = array(
			array('value' => '', 'label' => 'Any'),
			array('value' => STAFF_TFN, 'label' => 'TFN'),
			array('value' => STAFF_ABN, 'label' => 'ABN')
		);
		return modules::run('common/menu_dropdown', $array, $id, $label);
	}
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name check_staff_has_role
	*	@access public
	*	@param null
	*	@return Returns is based on the return_bool value. If it is true or empty it return true or false, if it is false it 
	*	
	*/
	function check_staff_has_role($staff_user_id,$role_id)
	{
		$has = $this->staff_model->staff_has_role($staff_user_id,$role_id);
		if($has){
			return true;
		}else{
			return false;
		}
	}	
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name check_staff_has_role
	*	@access public
	*	@param null
	*	@return Returns is based on the return_bool value. If it is true or empty it return true or false, if it is false it 
	*	
	*/
	function check_staff_has_group($staff_user_id,$group_id)
	{
		$has = $this->staff_model->staff_has_group($staff_user_id,$group_id);
		if($has){
			return true;
		}else{
			return false;
		}
	}	
	/**
	*	@name: get_availability_data
	*	@desc: function to return value of availability of user based on day and time
	*	@access: public
	*	@param: (via parameter) (int) user_id, day, hour
	*	@return: (int) value of staff availability
	*/
	function get_availability_data($user_id, $day, $hour)
	{
		return $this->staff_model->get_availability_data($user_id, $day, $hour);
	}
	/**
	*	@name: get_total_staffs
	*	@desc: Returns total staff based on status. If status is not passed it returns the total staffs
	*	@access: public
	*	@param: string, int status
	*	@return: (int) total staff
	*/
	function get_total_staffs($status='')
	{
		return $this->staff_model->get_total_staffs_count($status);
	}
	
	/**
	*	@name: get_staff_custom_attribute
	*	@desc: Get custom attribute of a staff member if it has been set
	*	@access: public
	*	@param: (int) user id of staff, (string) the name of the custom attribute
	*	@return: (int) total staff
	*/
	function get_staff_custom_attribute($staff_user_id,$attribute_name)
	{
		//first get attribute type
		$has_multiple_value = modules::run('formbuilder/has_multiple_value',$attribute_name);
		$staff_attribute = $this->staff_model->get_staff_custom_attribute($staff_user_id,$attribute_name);
		$data['has_multi'] = false;
		if($staff_attribute){
			if($has_multiple_value){
				$data['attributes'] = json_decode($staff_attribute->attributes);
				$data['staffs_custom_attributes_id'] = $staff_attribute->staffs_custom_attributes_id;
				$data['has_multi'] = true;
			}else{
				$data['attributes'] = $staff_attribute->attributes;	
				$data['staffs_custom_attributes_id'] = $staff_attribute->staffs_custom_attributes_id;
			}
		}else{
			$data['attributes'] = '';
			$data['staffs_custom_attributes_id'] = '';	
		}
		return $data;
	}
	
	function form_upload_photo($user_id)
	{
		$data['user_id'] = $user_id;
		$this->load->view('upload_photo_form', isset($data) ? $data : NULL);	
	}
	
	
	
	/**
	*	@name: upload_custom_document
	*	@desc: Uploads document that has been created using the custom attributes.
	*	@access: public
	*	@param: (file) data is posted 
	*	@return: redirect to staff profile 
	*/
	function upload_custom_document()
	{
		$user_staff_id = $this->input->post('user_staff_id',true);
		$salt = 'custom_files'.$user_staff_id;
		$file_path = './uploads/staff/custom_attributes';
		//create folder
		$folder_name = $this->_create_folders('./uploads/staff/custom_attributes',$salt);
		$this->load->library('upload');
		foreach($_FILES as $key => $val){
			if ($_FILES[$key]['name']){
			//image upload
			$config['upload_path'] = $file_path."/".$folder_name;	
			$config['allowed_types'] = 'gif|jpg|png|jpeg|doc|docx|pdf';
			$config['max_size']	= '4096'; // 4 MB
			$config['max_width']  = '4000';
			$config['max_height']  = '4000';
			$config['overwrite'] = FALSE;
			$config['remove_space'] = TRUE;
			
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($key)) {
					//image upload filed abort file upload
					$data['upload_error'] = $this->upload->display_errors();
					$valid_upload = false;
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$file_name = $data['upload_data']['file_name'];
	
					//update database
					$custom_file = array(
										'user_id' => $user_staff_id,
										'attribute_name' => $key,
										'attributes' => $file_name,
										'file_upload' => 'yes'
									);										
					$this->staff_model->insert_staff_custom_attributes($custom_file);
				}
			}
		}
		$this->session->set_flashdata('load_document_tab',true);
		redirect('staff/edit/'.$user_staff_id);
	}
	
	/**
	*	@name: delete_custom_document
	*	@desc: Delete custom documents
	*	@access: public
	*	@param: int(staff custom attribute id)
	*	@return: redirect to staff profile 
	*/
	function delete_custom_document($staffs_custom_attributes_id)
	{
		$file_details = $this->staff_model->get_staff_custom_attribute_by_id($staffs_custom_attributes_id);
		$file_name = $file_details->attributes;	
		$staff_user_id = $file_details->user_id;
		$folder =  md5('custom_files'.$staff_user_id);
		$this->_delete_document($folder,$file_name);
		$this->staff_model->delete_staff_custom_attributes_by_id($staffs_custom_attributes_id);
		$this->session->set_flashdata('load_document_tab',true);
		redirect('staff/edit/'.$staff_user_id);
	}
	/**
	*	@name: _create_folders
	*	@desc: Creates folder for documents
	*	@access: private
	*	@param: (string) path of the folder, (string) salt, (array) array of subfolders if applicable
	*	@return: returns the folder name to the control that called this function
	*/
	function _create_folders($path,$salt,$subfolders = null)
	{	
		//create staff specific folders
		if($path && $salt){
			$newfolder = md5($salt);
			$dir = $path."/".$newfolder;
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			
			$sub_dir = '';
			if($subfolders){
				foreach($subfolders as $folder){
					$sub_dir = $dir.'/'.$folder;	
					if(!is_dir($sub_dir))
					{
					  mkdir($sub_dir);
					  chmod($sub_dir,0777);
					  $fp = fopen($sub_dir.'/index.html', 'w');
					  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
					  fclose($fp);
					}		
				}
			}
			return $newfolder;
		}
		
	}
	/**
	*	@name: _delete_document
	*	@desc: Deletes custom documents
	*	@access: private
	*	@param: (string) folder name, (string) file name
	*	@return: null
	*/
	function _delete_document($folder,$document_name)
	{
		if($document_name && $folder){
			$main_path = "./uploads/staff/custom_attributes/".$folder;
			//delete doc
			if(file_exists($main_path.'/'.$document_name)){
				unlink($main_path.'/'.$document_name);
			}
		}
	}
	
	/**
	*	@name:get_staff_gender
	*	@desc: Returns the gender of the staff
	*	@access: public
	*	@param: (int) user id
	*	@returns (string) m or f
	*		
	*/
	function get_staff_gender($user_id)
	{
		$staff = $this->staff_model->get_staff($user_id);	
		if($staff){
			return $staff['gender'];	
		}
	}
	/**
	*	@name: delete_files
	*	@desc: Deletes file from server
	*	@access: private
	*	@param: (string) path to the main folder, (string) name of the file, (array) sub folder names
	*	@return: null
	*/
	function delete_files($path,$file_name,$sub_folders = array())
	{
		if(file_exists($path.'/'.$file_name)){
			unlink($path.'/'.$file_name);
		}
		if($sub_folders){
			foreach($sub_folders as $folder){
				if(file_exists($path.'/'.$folder.'/'.$file_name)){
					unlink($path.'/'.$folder.'/'.$file_name);
				}	
			}
		}
	}
	
	/**
	*	@desc Shows the existing form for custom attributes in staff profile.
	*
	*   @name custom_attributes_for_staff_profile
	*	@access public
	*	@param (int) user id of staff
	*	@return Loads existing form elements for custom attributes in staff profile.
	*/
	function custom_attributes_for_staff_profile($staff_user_id)
	{
		$data['existing_elements'] = $this->formbuilder_model->get_form_elements(true);
		$data['user_id'] = $staff_user_id;
		$this->load->view('custom_attributes_for_staff_profile',isset($data) ? $data : NULL);	
	}
	
	/**
	*	@desc Shows the existing form for custom attributes in staff profile.
	*
	*   @name custom_file_uploads_for_staff_profile
	*	@access public
	*	@param (int) user id of staff
	*	@return Loads existing file upload form elements for custom attributes in staff profile.
	*/
	function custom_file_uploads_for_staff_profile($staff_user_id)
	{
		$data['existing_elements'] = $this->formbuilder_model->get_form_elements(false);
		$data['user_id'] = $staff_user_id;
		$this->load->view('custom_upload_fields_for_staff_profile',isset($data) ? $data : NULL);	
	}
	
	/**
	*	@desc Shows the existing form for custom attributes.
	*
	*   @name custom_attributes
	*	@access public
	*	@param null
	*	@return Loads existing form elements for custom attributes.
	*/
	function custom_attributes()
	{
		$data['existing_elements'] = $this->formbuilder_model->get_form_elements();
		$this->load->view('custom_attributes_search_form',isset($data) ? $data : NULL);	
	}
	/**
	*	@desc This function gets all the posted value from the search staff page then filters and returns only the custom attributes search parameters to the calling method.
	*
	*   @name get_custom_attrs
	*	@access public
	*	@param (via POST) gets posted data from the search staff page
	*	@return Returns the custom attributes only values from all the posted data 
	*/
	function get_custom_attrs($search_params)
	{
		$custom_attrs = array();
		$normal_prefix = 'custom_attrs_';
		$file_prefix = 'custom_file_';
		if($search_params){
			foreach($search_params as $key => $val){
				if($val){
					if(substr($key,0,strlen($normal_prefix)) == $normal_prefix){
						$new_key = substr($key, strlen($normal_prefix));
						$custom_attrs['normal_elements'][$new_key] = $val;	
					}
					if(substr($key,0,strlen($file_prefix)) == $file_prefix){
						$new_key = substr($key, strlen($file_prefix));
						$custom_attrs['file_uploads'][$new_key] = $val;	
					}
				}
			}	
		}
		return $custom_attrs;
	
	}
	
	function get_staff_by_name($name) {
		return $this->staff_model->get_staff_by_name($name);
	}
	
	function field_input($field_name, $field_value=null) {
		$data['field_name'] = $field_name;
		$data['staffs'] = $this->staff_model->search_staff_by_name();
		$this->load->view('field_input', isset($data) ? $data : NULL);
	}
	
	
	
}