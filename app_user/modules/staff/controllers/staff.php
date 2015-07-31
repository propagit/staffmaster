<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Staff extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('profile/profile_model');
		$this->load->model('user/user_model');
		$this->load->model('staff_model');
		$this->load->model('formbuilder/formbuilder_model');
		$this->load->model('attribute/custom_field_model');
		$this->load->model('export/export_model');
		if($this->session->userdata('user_data')){
			$this->user = $this->session->userdata('user_data');
			$this->is_client = modules::run('auth/is_client');
		}
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
			case 'sync':
					$this->sync_view();
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
			case 'import_rsa':
				$this->import_rsa();
			break;
			case 'rename_folders':
				$this->rename_folders();
			break;
			case 'resize_old_images':
				$this->resize_old_images();
			break;
			case 'copy_old_profile_pics':
				$this->copy_old_profile_pics();
			break;
			case 'remove_dirs':
				$this->remove_dirs();
			break;
			case 'import_old_roles':
				$this->import_old_roles();
			break;
			case 'copy_files':
					$this->copy_files();
				break;
			case 'custom_export_staff':
					$this->custom_export_staff();
				break;
			default:
					echo 'do nothing';
				break;
		}
	}

	function add_staff()
	{
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
	function search_staffs()
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
		$data['is_client'] = $this->is_client;
		$this->load->view('search_form', isset($data) ? $data : NULL);
	}

	function check_staff_time_collision($staff_id, $shift)
	{
		return $this->staff_model->check_staff_time_collision($staff_id, $shift);
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

	function update_staff($user_id, $data)
	{
		$user_fields = array(
			'title',
			'first_name',
			'last_name',
			'address',
			'suburb',
			'postcode',
			'state',
			'country',
			'phone',
			'mobile'
		);
		$staff_fields = array(
			'gender',
			'dob',
			'emergency_contact',
			'emergency_phone',
			'f_acc_name',
			'f_acc_number',
			'f_bsb',
			'f_tfn',
			'f_abn',
			'f_require_gst',
			'f_aus_resident',
			'f_tax_free_threshold',
			'f_tax_offset',
			'f_senior_status',
			'f_help_debt',
			'f_help_variation',
			's_external_id',
			's_fund_name',
			's_employee_id',
			's_choice'
		);
		$user_data = array();
		$staff_data = array();
		foreach($data as $key => $value) {
			if (in_array($key, $staff_fields)) {
				if ($key == 'dob') {
					$staff_data[$key] = date('Y-m-d',strtotime($value['year'].'-'.$value['month']. '-'.$value['day']));
				} else {
					$staff_data[$key] = $value;
				}
			}
			if (in_array($key, $user_fields)) {
				$user_data[$key] = $value;
			}
		}
		if (count($user_data) > 0) {
			$this->user_model->update_user($user_id, $user_data);
		}
		if (count($staff_data) > 0) {
			$this->staff_model->update_staff($user_id, $staff_data, true);
		}
	}

	function get_age($user_id)
	{
		$staff = $this->get_staff($user_id);
		if (!$staff['dob']) { return 0; }
		$from = new DateTime($staff['dob']);
		$to   = new DateTime('today');
		return $from->diff($to)->y;
	}

	function get_staff_by_external_id($external_id)
	{
		return $this->staff_model->get_staff_by_external_id($external_id);
	}

	function get_staff_working_hours($user_id)
	{

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

		return modules::run('common/field_select', $array, $field_name, $field_value, $size, false);
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
				$data['staff_custom_attribute_id'] = $staff_attribute->staff_custom_attribute_id;
				$data['has_multi'] = true;
			}else{
				$data['attributes'] = $staff_attribute->attributes;
				$data['staff_custom_attribute_id'] = $staff_attribute->staff_custom_attribute_id;
			}
		}else{
			$data['attributes'] = '';
			$data['staff_custom_attribute_id'] = '';
		}
		return $data;
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
		$file_path = UPLOADS_PATH.'/staff/custom_attributes';
		//create main folder
		modules::run('upload/create_upload_folders',UPLOADS_PATH.'/staff/custom_attributes/');
		//create folder
		$folder_name = $this->_create_folders(UPLOADS_PATH.'/staff/custom_attributes',$salt);
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
	function delete_custom_document($staff_custom_attribute_id)
	{
		$file_details = $this->staff_model->get_staff_custom_attribute_by_id($staff_custom_attribute_id);
		$file_name = $file_details->attributes;
		$staff_user_id = $file_details->user_id;
		$folder =  md5('custom_files'.$staff_user_id);
		$this->_delete_document($folder,$file_name);
		$this->staff_model->delete_staff_custom_attributes_by_id($staff_custom_attribute_id);
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
			$main_path = UPLOADS_PATH."/staff/custom_attributes/".$folder;
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

	function custom_attributes_form($user_id)
	{
		$fields = $this->staff_model->get_custom_fields($user_id);
		if (count($fields) > 0) {
			foreach($fields as $field) {
				$data['field'] = $field;
				$data['user_id'] = $user_id;
				$this->load->view('custom_field/' . $field['type'], isset($data) ? $data : NULL);
			}
		}
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
		#$data['existing_elements'] = $this->formbuilder_model->get_form_elements();
		#$this->load->view('custom_attributes_search_form',isset($data) ? $data : NULL);
	}

	/**
	*	@desc Shows the existing form for custom attributes.
	*
	*   @name custom_fields
	*	@access public
	*	@param null
	*	@return Loads existing form elements for custom fields.
	*/
	function custom_fields()
	{
		$fields = $this->custom_field_model->get_fields();
		if (count($fields) == 0) {
			//$this->load->view('search_custom_fields/no_field');
		} else {
			foreach($fields as $field) {
				$data['field'] = $field;
				$this->load->view('search_custom_fields/' . $field['type'], isset($data) ? $data : NULL);
			}
		}
	}
	/**
	*	@desc This function gets all the posted value from the search staff page then filters and returns only the custom attributes search parameters to the calling method.
	*
	*   @name get_search_custom_attrs
	*	@access public
	*	@param (via POST) gets posted data from the search staff page
	*	@return Returns the custom attributes only values from all the posted data
	*/
	function get_search_custom_attrs($search_params)
	{
		$custom_attrs = array();
		$normal_prefix = 'custom_search_';
		$file_prefix = 'search_file_';
		$fileDate_file_prefix = 'search_dateFile_file_';
		$fileDate_date_to_prefix = 'search_dateFile_date_to_';
		$fileDate_date_from_prefix = 'search_dateFile_date_from_';
		
		if($search_params){
			foreach($search_params as $key => $val){
				if($val){
					if(substr($key,0,strlen($normal_prefix)) == $normal_prefix){
						$new_key = trim($key, $normal_prefix);
						$custom_attrs['normal_elements'][$new_key] = $val;
					}
					if(substr($key,0,strlen($file_prefix)) == $file_prefix){
						$new_key = trim($key, $file_prefix);
						$custom_attrs['file_uploads'][$new_key] = $val;
					}
					if(substr($key,0,strlen($fileDate_file_prefix)) == $fileDate_file_prefix){
						$new_key = trim($key, $fileDate_file_prefix);
						$custom_attrs['fileDate_file'][$new_key] = $val;
					}
					if(substr($key,0,strlen($fileDate_date_from_prefix)) == $fileDate_date_from_prefix){
						$new_key = trim($key, $fileDate_date_from_prefix);
						$custom_attrs['fileDate_date_from'][$new_key] = $val;
					}
					if(substr($key,0,strlen($fileDate_date_to_prefix)) == $fileDate_date_to_prefix){
						$new_key = trim($key, $fileDate_date_to_prefix);
						$custom_attrs['fileDate_date_to'][$new_key] = $val;
					}
				}
			}
		}
		return $custom_attrs;
	}



	/**
	*	@desc This function gets all the posted value from the search staff page then filters and returns only the custom attributes search parameters to the calling method.
	*
	*   @name get_custom_attrs
	*	@access public
	*	@param (via POST) gets posted data from the search staff page
	*	@return Returns the custom attributes only values from all the posted data
	*/
	function _old_func_get_custom_attrs($search_params)
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

	function field_select($field_name, $field_value=null)
	{
		$staffs = $this->staff_model->search_staff_by_name();
		$array = array();
		foreach($staffs as $staff)
		{
			$array[] = array(
				'value' => $staff['user_id'],
				'label' => $staff['first_name'] . ' ' . $staff['last_name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
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

	function profile_hero_image($user_id)
	{
		$data['hero'] = $this->staff_model->get_hero($user_id);
		$this->load->view('profile_hero_image', isset($data) ? $data : NULL);
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
		return $this->staff_model->get_staff_groups($user_id);
	}

	function import_view()
	{
		$this->load->view('import_view', isset($data) ? $data : NULL);
	}

	function field_select_export_templates($field_name, $field_value = null)
	{
		$data['templates'] = $this->export_model->get_templates('staff');
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('field_select_export_templates', isset($data) ? $data : NULL);
	}

	function field_select_fields($field_name, $field_value = null)
	{
		$export_fields = array(
			array('value' => 'title','label' => 'Title'),
			array('value' => 'rating','label' => 'Rating'),
			array('value' => 'first_name','label' => 'First Name'),
			array('value' => 'gender','label' => 'Gender'),
			array('value' => 'dob','label' => 'Date of birth'),
			array('value' => 'address','label' => 'Address'),
			array('value' => 'suburb','label' => 'Suburb'),
			array('value' => 'city','label' => 'City'),
			array('value' => 'postcode','label' => 'Postcode'),
			array('value' => 'state','label' => 'State'),
			array('value' => 'country','label' => 'Country'),
			array('value' => 'email','label' => 'Email'),
			array('value' => 'phone','label' => 'Phone'),
			array('value' => 'external_id','label' => 'External Staff ID'),
			array('value' => 'emergency_contact','label' => 'Emergency Contact Person'),
			array('value' => 'emergency_phone','label' => 'Emergency Phone'),
			array('value' => 'account_name','label' => 'Bank Account Name'),
			array('value' => 'bsb','label' => 'BSB'),
			array('value' => 'account_number','label' => 'Bank Account Number'),
			array('value' => 'employed_as','label' => 'Employed As'),
			array('value' => 'tfn_number','label' => 'TFN Number'),
			array('value' => 'abn_number','label' => 'ABN Number'),
			array('value' => 'super_choice','label' => 'Choice of superannuation'),
			array('value' => 'super_employee_id','label' => 'Super Employee ID Number'),
			array('value' => 'super_fund_name','label' => 'Super Fund Name'),
			array('value' => 'super_membership_number','label' => 'Super Membership Number'),
			array('value' => 'last_name','label' => 'Last Name'),
			array('value' => 'mobile','label' => 'Mobile'),
			array('value' => 'internal_id','label' => 'Internal Staff ID'),
			array('value' => 'joined_date','label' => 'Joined Date'),
			array('value' => 'status','label' => 'Status')
		);
		return modules::run('common/field_select', $export_fields, $field_name, $field_value);
	}

	function get_staff_user_ids_by_group_id($group_id)
	{
		return $this->staff_model->get_staff_user_ids_by_group_id($group_id);
	}

	function get_active_staff_user_ids()
	{
		return $this->staff_model->get_active_staff_user_ids();
	}



	function _resize_old_images()
	{
		$staff_arr = $this->db->where('status',1)->get('users')->result_array();
		#md5('staff' . $id);
		foreach($staff_arr as $staff){
			$user_id = $staff['user_id'];
			$folder = md5($user_id);
			$path = UPLOADS_PATH.'/staff/profile/'.$folder;
			if($user_id == 824){
				$hero = $this->staff_model->get_hero($user_id);
				$file_name = '';
				if($hero){
					$file_name = $hero['name'];
				}
				echo $file_name;
				echo '<br />'.$user_id;
				if($file_name != ''){
					if(file_exists($path.'/'.$file_name)){
						#resize thumbnail2
						$new_width=216;
						$new_height=216;
						copy($path.'/'.$file_name, $path."/thumbnail2/".$file_name);
						$target = $path."/thumbnail2/".$file_name;
						modules::run('staff/ajax/scale_image',$target,$target,$new_width,$new_height);

						//create thumbnail
						$thumb2_width = 72;
						$thumb2_height = 72;
						copy($path.'/'.$file_name, $path."/thumbnail/".$file_name);
						$target_thumb2 = $path."/thumbnail/".$file_name;
						modules::run('staff/ajax/scale_image',$target_thumb2,$target_thumb2,$thumb2_width,$thumb2_height);
					}
				}
			}
		}
	}

	function copy_files() {
		$staffs = $this->staff_model->search_staffs();
		$this->load->helper('directory');
		foreach($staffs as $staff) {
			$user_id = $staff['user_id'];
			$dir = UPLOADS_PATH . '/staff/' . $user_id;
			if(!is_dir($dir))
			{
				mkdir($dir);
				chmod($dir,0777);
				$fp = fopen($dir.'/index.html', 'w');
				fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
				fclose($fp);
			}

			$dir_thumb = $dir . '/thumb';
			if(!is_dir($dir_thumb))
			{
				mkdir($dir_thumb);
				chmod($dir_thumb,0777);
				$fp = fopen($dir_thumb.'/index.html', 'w');
				fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
				fclose($fp);
			}

			# Copy profile images
			$dir_profile = UPLOADS_PATH . '/staff/profile/' . md5($user_id);

			if (is_dir($dir_profile)) {
				$map = directory_map($dir_profile, 1);
				foreach($map as $file) {
					# Copy file
					if (!is_dir($dir_profile . '/' . $file)) {
						copy($dir_profile . '/' . $file, $dir . '/' . $file);
					}
				}
				$thumb_map = directory_map($dir_profile . '/thumbnail', 1);
				foreach($thumb_map as $thumb) {
					if (!is_dir($dir_profile . '/thumbnail/' . $thumb)) {
						copy($dir_profile . '/thumbnail/' . $thumb, $dir_thumb . '/' . $thumb);
					}
				}
			}
		}
	}

	function sync_view()
	{
		$this->load->view('sync_view', isset($data) ? $data : NULL);
	}

	function btn_api($user_id='', $external_id='')
	{
		$platform = $this->config_model->get('accounting_platform');

		if (!$platform)
		{
			return;
		}
		if ($platform == 'shoebooks')
		{
			if ($external_id)
			{
				$external_id = modules::run('api/shoebooks/read_employee', $external_id);
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
				$external_id = modules::run('api/myob/connect', 'read_employee~' . $external_id);
			}

			$platform = 'MYOB';
		}
		if ($platform == 'xero')
		{
			if ($external_id)
			{
				$external_id = modules::run('api/xero/get_employee', $external_id);
			}
			$platform = 'Xero';
		}
		$data['user_id'] = $user_id;
		$data['external_id'] = $external_id;
		$data['platform'] = $platform;
		$this->load->view('btn_api', isset($data) ? $data : NULL);
	}
	
	function get_default_payrate_id($user_id)
	{
		return $this->staff_model->get_default_payrate_id($user_id);
	}
	
	function get_staff_with_age_group($user_id)
	{
		return $this->staff_model->get_staff_with_age_group($user_id);
	}
	
	function add_locations($user_id,$parent_id) {
		
		$data = array();
		$location = array();
		$all = modules::run('attribute/location/get_locations', $parent_id);
		foreach($all as $a) {
			$location[] = $a['location_id'];
		}
		$data[$parent_id] = $location;


		# Now merging with current locations data
		$staff = $this->staff_model->get_staff($user_id);
		$locations = array();
		$locations = json_decode($staff['locations']);

		if (count($locations) > 0) foreach($locations as $o_parent_id => $o_childrens)
		{
			if ($o_parent_id != $parent_id) # Adding old parent locations
			{
				$data[$o_parent_id] = $o_childrens;
			}
			else
			{
				if (!$location_id)
				{
					$data[$parent_id] = $location;
				}
				else if (!in_array($location_id, $o_childrens))
				{
					$data[$parent_id] = array_merge($o_childrens, $location);
				}
				else
				{
					$data[$parent_id] = $o_childrens;
				}
			}
		}

		$this->staff_model->update_staff($staff['user_id'], array('locations' => json_encode($data)));
	}
	
	function create_staff_dir($user_id)
	{
		$targetDir = UPLOADS_PATH . '/staff/' . $user_id;
		if (!file_exists($targetDir)) {
            @mkdir($targetDir);
			chmod($targetDir,0777);
			$fp = fopen($targetDir.'/index.html', 'w');
			fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			fclose($fp);
        }
		$dir_thumb = $targetDir . '/thumb';
        if(!is_dir($dir_thumb))
        {
          mkdir($dir_thumb);
          chmod($dir_thumb,0777);
          $fp = fopen($dir_thumb.'/index.html', 'w');
          fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
          fclose($fp);
        }	
	}


	function custom_export_staff()
	{
		#$staff = $this->staff_model->search_staffs(array('keyword' => 'Klarisse Fleming'));
		$staff = $this->staff_model->search_staffs();
		
		/*$custom = $this->staff_model->get_custom_fields(2370);
		print_r($custom);die();*/
		#echo count($staff);
		#print_r($staff);
		/*foreach($staff as $s){
			if($s['locations']){
				$locations = json_decode($s['locations']);
				$s_location = array();
				foreach($locations as $key => $val){
					# get the name denoted by key
					$temp_loc = '';
					if($key){
						$loc = modules::run('attribute/location/get_location',$key);
						if($loc){
							$temp_loc = '[ ' . $loc['name'];
						}
					}
					# loop throught val if this is an array 
					if(is_array($val) && $val){
						$temp_loc .= ' -> ';
						$temp_loc_array = array();
						foreach($val as $v){
							$loc = modules::run('attribute/location/get_location',$v);
							if($loc){
								$temp_loc_array[] = str_replace(',', ' ', $loc['name']);
							}	
						}
					}
					
					$s_location[] = $temp_loc . implode(' : ', $temp_loc_array) . ' ]';
				}
			}
			echo implode(': ', $s_location);
			die();
		}
		die();*/

		
		$headings = array(
					'Staff ID',
					'Staff External ID',
					'Title',
					'First Name',
					'Last Name',
					'Gender',
					'DOB',
					'Email',
					'Address',
					'Suburb',
					'City',
					'State',
					'Postcode',
					'Country',
					'Emergency Contact Person',
					'Emergency Contact Number',
					'Australian Resident',
					'Tax Free Threshold',
					'Tax Offset',
					'Senior Status',
					'Help Debt',
					'Help Variation',
					'Bank Acc Name',
					'Bank Acc No',
					'Bank BSB',
					'TFN or ABN',
					'TFN',
					'ABN',
					'Require GST',
					'Superfund Choice',
					'Superfund Name',
					'Supefund External ID',
					'Superfund Employee ID',
					#'Superfund TFN',
					#'Superfund Name',
					#'Superfund Website',
					#'Superfund Product ID',
					#'Superfund Phone',
					#'Superfund Membership',
					#'Superfund Address',
					#'Superfund Suburb',
					#'Superfund Postcode',
					#'Superfund State',
					#'Avaliability',
					'Payrates',
					'Roles',
					'Locations'
				
				);
				
		$custom_fields = $this->db->order_by('field_order', 'asc')
								  ->get('custom_fields')
								  ->result_array();
		#print_r($custom_fields);die();
		foreach($custom_fields as $cf){
			array_push($headings, str_replace(',', '-', $cf['label']));
		}
	
		$csvdir = getcwd();		
		$csvname = 'Sassy-Staff';
		$csvname = $csvname.'.csv';
		header('Content-type: application/csv; charset=utf-8;');
        header("Content-Disposition: attachment; filename=$csvname");
		$fp = fopen("php://output", 'w');
		
		# set heading
		fputcsv($fp,$headings);
		
		$s_csv = array();
		
		foreach($staff as $s){
			# payrates
			$payrates = $this->staff_model->get_payrates($s['user_id']);
			$s_rate = array();
			foreach($payrates as $p){
				if($p['is_restricted'] == NULL && $p['status'] > -1){
					$s_rate[] = $p['name'];
				}
			}	
			
			# custom attributes
			$custom = $this->staff_model->get_custom_fields($s['user_id']);
			
			# roles
			$roles = $this->staff_model->get_staff_roles($s['user_id']);	
			$s_roles = array();
			foreach($roles as $r){
				$s_roles[] = $r['name'];
			}
			
			# locations
			if($s['locations']){
				$locations = json_decode($s['locations']);
				$s_location = array();
				foreach($locations as $key => $val){
					# get the name denoted by key
					$temp_loc = '';
					if($key){
						$loc = modules::run('attribute/location/get_location',$key);
						if($loc){
							$temp_loc = '[ ' . $loc['name'];
						}
					}
					# loop throught val if this is an array 
					if(is_array($val) && $val){
						$temp_loc .= ' -> ';
						$temp_loc_array = array();
						foreach($val as $v){
							$loc = modules::run('attribute/location/get_location',$v);
							if($loc){
								$temp_loc_array[] = str_replace(',', ' ', $loc['name']);
							}	
						}
					}
					
					$s_location[] = $temp_loc . implode(' : ', $temp_loc_array) . ' ]';
				}
			}
	
						
			$s_csv = array(
						$s['user_id'],
						$s['external_staff_id'],
						$s['title'],
						$s['first_name'],
						$s['last_name'],
						$s['gender'],
						$s['dob'],
						$s['email_address'],
						$s['address'],
						$s['suburb'],
						$s['city'],
						$s['state'],
						$s['postcode'],
						$s['country'],
						$s['emergency_contact'],
						$s['emergency_phone'],
						$s['f_aus_resident'] ? 'Yes' : 'No',
						$s['f_tax_free_threshold'] ? 'Yes' : 'No',
						$s['f_tax_offset'] ? 'Yes' : 'No',
						$s['f_senior_status'],
						$s['f_help_debt'] ? 'Yes' : 'No',
						$s['f_help_variation'],
						$s['f_acc_name'],
						$s['f_acc_number'],
						$s['f_bsb'],
						$s['f_employed'] == 1 ? 'TFN' : 'ABN',
						$s['f_tfn'],
						$s['f_abn'],
						$s['f_require_gst'] ? 'Yes' : 'No',
						$s['s_choice'],
						$s['s_name'],
						$s['s_external_id'],
						$s['s_employee_id'],
						#$s['s_tfn'],
						#$s['s_fund_name'],
						#$s['s_fund_website'],
						#$s['s_product_id'],
						#$s['s_fund_phone'],
						#$s['s_membership'],
						#$s['s_fund_address'],
						#$s['s_fund_suburb'],
						#$s['s_fund_postcode'],
						#$s['s_fund_state'],
						#'avalilibility',
						implode(': ', $s_rate),
						implode(': ', $s_roles),
						implode(': ', $s_location)
					);
			# push custom attrs
			foreach($custom as $c){
				$cur_attr = '';
				if($c['type'] == 'fileDate'){
					 $cur_attr = $c['field_date'];	
				}else{
					$cur_attr = str_replace(',' , '-', $c['staff_value']);	
				}
				array_push($s_csv, $cur_attr);
			}
 		
					
			fputcsv($fp,$s_csv);
			
			#die();
		}
		die();
	}
}
