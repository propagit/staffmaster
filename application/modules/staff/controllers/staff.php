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
		$this->load->model('export/export_model');
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
			case 'import':
					$this->import_view();
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
			array('field' => 'email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email|is_unique[users.email_address]'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
			//array('field' => 'department_id', 'label' => 'Department', 'rules' => ''),
			//array('field' => 'role', 'label' => 'Role', 'rules' => ''),
			array('field' => 'external_staff_id', 'label' => 'External Staff ID', 'rules' => ''),
			array('field' => 'emergency_contact', 'label' => 'Emergency Contact', 'rules' => ''),
			array('field' => 'emergency_phone', 'label' => 'Emergency Phone', 'rules' => '')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			/* if ($this->user_model->check_username($this->input->post('email_address')))
			{
				$data['username_exist'] = true;
			}
			else
			{ */
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
					//'department_id' => $data['department_id'],
					//'role' => $data['role'],
					'emergency_contact' => $data['emergency_contact'],
					'emergency_phone' => $data['emergency_phone'],
					's_choice' => 'employer',
					's_name' =>  $data['first_name'].' '.$data['last_name'],
					's_fund_name' => $company_profile['super_fund_name']
					
				);
				$staff_id = $this->staff_model->insert_staff($staff_data);
				//send welcome email
				$this->send_welcome_email($user_id,$data['email_address'],$data['password']);
				redirect('staff/edit/' . $user_id);
			//}
		}
		
		
		$this->load->view('add_form', isset($data) ? $data : NULL);
	}
	
	function send_welcome_email($user_id,$email,$password = '')
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		$template_info = $this->email_template_model->get_template(1);
		if($template_info->auto_send == 'yes'){
			//get company profile
			$company = $this->setting_model->get_profile();
			//get receiver object
			$email_obj_params = array(
									'template_id' => 1,
									'user_id' => $user_id,
									'company' => $company,
									'password' => $password
								);	
			$obj = modules::run('email/get_email_obj',$email_obj_params);
			$email_data = array(
								'to' => $email,
								'from' => $company['email_c_email'],
								'from_text' => $company['email_c_name'],
								'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
								'message' => modules::run('email/format_template_body',$template_info->template_content,$obj)
							);
			modules::run('email/send_email',$email_data);
			//update welcome_email_sent status to yes
			$this->staff_model->update_staff($user_id,array('welcome_email_sent' => 'yes'));
		}
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
	function get_total_staff($status='')
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
				$data['staff_custom_attributes_id'] = $staff_attribute->staff_custom_attributes_id;
				$data['has_multi'] = true;
			}else{
				$data['attributes'] = $staff_attribute->attributes;	
				$data['staff_custom_attributes_id'] = $staff_attribute->staff_custom_attributes_id;
			}
		}else{
			$data['attributes'] = '';
			$data['staff_custom_attributes_id'] = '';	
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
	function delete_custom_document($staff_custom_attributes_id)
	{
		$file_details = $this->staff_model->get_staff_custom_attribute_by_id($staff_custom_attributes_id);
		$file_name = $file_details->attributes;	
		$staff_user_id = $file_details->user_id;
		$folder =  md5('custom_files'.$staff_user_id);
		$this->_delete_document($folder,$file_name);
		$this->staff_model->delete_staff_custom_attributes_by_id($staff_custom_attributes_id);
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
	*	@access: public
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
		$data['field_value'] = $field_value;
		$data['staffs'] = $this->staff_model->search_staff_by_name();
		$this->load->view('field_input', isset($data) ? $data : NULL);
	}
	/**
	*	@desc this functio to get single image of staff with url on the image
	*   @name profile_image
	*	@access public
	*	@param (via GET) get the value of user_id
	*	@return Returns the image of staff profile with url (a tag)
	*/
	function get_profile_picture($user_id=NULL)
	{		
		
		$staff = $this->staff_model->get_staff($user_id);
		$photo = $this->staff_model->get_hero($user_id);
		$data['staff'] = $staff;
		$data['photo'] = $photo;

		$this->load->view('profile_picture', isset($data) ? $data : NULL);
	}
	/**
	*	@desc this functio to get single image of staff without having url on the image
	*   @name profile_image
	*	@access public
	*	@param (via GET) get the value of user_id
	*	@return Returns the image of staff profile
	*/
	function profile_image($user_id=NULL)
	{		
		
		$staff = $this->staff_model->get_staff($user_id);
		$photo = $this->staff_model->get_hero($user_id);
		$data['staff'] = $staff;
		$data['photo'] = $photo;

		$this->load->view('staff_picture', isset($data) ? $data : NULL);
	}
	
	/**
	*	@desc Returns group id that an staff has been assigned to
	*
	*   @name get_staff_groups
	*	@access public
	*	@param ([int] user id)
	*	@return Returns an array with group id if a staff member has been assigned to a group or false if the staff has not been assigned to any group
	*	
	*/
	function get_staff_groups($user_id)
	{
		return $this->staff_modal->get_staff_groups($user_id);
	}
	
	function import_view()
	{
		$this->load->view('import_view', isset($data) ? $data : NULL);
	}
	
	function field_select_export_templates($field_name, $field_value = null) 
	{
		$data['single'] = $this->export_model->get_templates('staff', 'single');
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('field_select_export_templates', isset($data) ? $data : NULL);
	}
	
	function field_select_fields($field_name, $field_value = null)
	{		
		$fields = $this->export_model->get_template_fields('staff','single');
		return modules::run('common/field_select', $fields, $field_name, $field_value);
	}
}