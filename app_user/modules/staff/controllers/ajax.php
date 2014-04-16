<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
		$this->load->model('user/user_model');
		$this->load->model('attribute/role_model');
		$this->load->model('attribute/group_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}
	
	function search_staffs()
	{
		$params = $this->input->post();
		$data['staffs'] = $this->staff_model->search_staffs($params);
		$data['total_staff'] = $this->staff_model->search_staffs($params,true);
		$data['current_page'] = $this->input->post('current_page',true);
		if ($this->is_client) 
		{
			$this->load->view('client/search_results', isset($data) ? $data : NULL);
		}
		else
		{
			$this->load->view('search_results', isset($data) ? $data : NULL);
		}				
	}
	
	function add_staff()
	{
		
	}
	
	/**
	*	@name: update_staff
	*	@desc: abstract function to update staff profile
	*	@access: public
	*	@param: (int) $user_id, (string) $tab
	*	@return: (view) of different update form depends on selected tab
	*/
	function update_staff($user_id, $tab)
	{
		$data['staff'] = $this->staff_model->get_staff($user_id);		
		$this->load->view('edit_' . $tab, isset($data) ? $data : NULL);
	}
	
	function update_personal()
	{
		$data = $this->input->post();
		$user_data = array(
			'password' => $data['password'],
			'title' => $data['title'],
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'email_address' => $data['email_address'],
			'address' => $data['address'],
			'suburb' => $data['suburb'],			
			'state' => $data['state'],
			'postcode' => $data['postcode'],
			'country' => $data['country'],
			'phone' => $data['phone'],
			'status' => $data['status'],
			'modified_on' => date('Y-m-d H:i:s')
		);
		$this->user_model->update_user($data['user_id'], $user_data);
		$staff_data = array(
			'external_staff_id' => $data['external_staff_id'],
			'rating' => $data['profile_rating'],
			'gender' => $data['gender'],
			'dob' => date('Y-m-d',strtotime($data['dob_year'].'-'.$data['dob_month']. '-'.$data['dob_day'])),
			'emergency_contact' => $data['emergency_contact'],
			'emergency_phone' => $data['emergency_phone'],
			'update_description' => 'personal details'
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);		
		echo modules::run('common/field_rating', 'profile_rating', $data['profile_rating'],'basic','wp-rating',$data['user_id'],true,false);
	}
	
	function update_financial()
	{
		$data = $this->input->post();
		$staff_data = array(
			'f_aus_resident' => isset($data['f_aus_resident']) ? $data['f_aus_resident'] : 0,
			'f_tax_free_threshold' => isset($data['f_tax_free_threshold']) ? $data['f_tax_free_threshold'] : 0,
			'f_tax_offset' => isset($data['f_tax_offset']) ? $data['f_tax_offset'] : 0,
			'f_senior_status' => isset($data['f_senior_status']) ? $data['f_senior_status'] : '',
			'f_help_debt' => isset($data['f_help_debt']) ? $data['f_help_debt'] : 0,
			'f_help_variation' => isset($data['f_help_variation']) ? $data['f_help_variation'] : '',
			'f_acc_name' => $data['f_acc_name'],
			'f_bsb' => $data['f_bsb'],
			'f_acc_number' => $data['f_acc_number'],
			'f_tfn' => $data['f_tfn'],
			'f_employed' => $data['f_employed'],
			'f_abn' => $data['f_abn'],
			'update_description' => 'financial details'
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
	}
	
	function update_super()
	{
		$data = $this->input->post();
		$staff_data = array(
			's_choice' => isset($data['s_choice']) ? $data['s_choice'] : '',
			's_name' => $data['s_name'],
			's_employee_id' => $data['s_employee_id'],
			's_tfn' => $data['s_tfn'],			
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
			'update_description' => 'super details'
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
	}
	
	/**
	*	@desc Displayes all the available roles in the system and the roles that has been asigned to the staff.
	*
	*   @name get_staff_roles
	*	@access public
	*	@param Post data - sort parameter and user id (staff id)
	*	@return Lists all roles with roles that has been assigned to staffs checked
	*	
	*/
	function get_staff_roles()
	{
		$params = $this->input->post('params',true);
		$data['roles'] = $this->role_model->get_roles($params);
		$data['params'] = $params;
		$this->load->view('ajax_list_roles_staff_profile', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_roles
	*	@desc: ajax function to add or delete roles 
	*	@access: public
	*	@param: (via POST) 
	*			- (int) user_id
	*			- (int) role_id
	*/
	function update_roles()
	{
		$user_id = $this->input->post('staff_id');
		$role_id = $this->input->post('role_id');
		if($this->staff_model->update_staff_role($user_id,$role_id)){
			echo 'success';	
		}
	}
	
	/**
	*	@name: add_location
	*	@desc: ajax function to add location of staff
	*	@access: public
	*	@param: (via POST) 
	*			- (int) location_parent_id
	*			- (int) location_id
	*			- (int) user_id
	*	@return: json encode array {ok: (true/false)}
	*/
	function add_location() {		
		$parent_id = $this->input->post('location_parent_id');
		if (!$parent_id) {
			echo json_encode(array('ok' => false));
			return;
		}
		$location_id = $this->input->post('location_id');
		
		$data = array();
		$location = array();		
		
		if (!$location_id) { # Select all locations within location_parent_id
			$all = modules::run('attribute/location/get_locations', $parent_id);
			foreach($all as $a) {
				$location[] = $a['location_id'];
			}
		}
		else
		{
			$location[] = $location_id;
		}
		$data[$parent_id] = $location;
		
		
		# Now merging with current locations data
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
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
		echo json_encode(array('ok' => true));
	}
	
	/**
	*	@name: remove_location
	*	@desc: ajax function to remove location of staff
	*	@access: public
	*	@param: (via POST)
	*			- (int) parent_id
	*			- (int) location_id
	*			- (int) user_id
	*	@return: (void)
	*/
	function remove_location() {
		var_dump($this->input->post());
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$parent_id = $this->input->post('parent_id');
		$location_id = $this->input->post('location_id');
		$locations = json_decode($staff['locations']);
		
		$data = array();
		if (!$location_id)
		{
			foreach($locations as $o_parent_id => $childrens)
			{
				if ($o_parent_id != $parent_id)
				{
					$data[$o_parent_id] = $childrens;
				}
			}
		}
		else
		{
			foreach($locations as $o_parent_id => $childrens)
			{
				$new_locations = array();
				foreach($childrens as $child)
				{
					if ($child != $location_id) {
						$new_locations[] = $child;
					}
				}
				$data[$o_parent_id] = $new_locations;
			}
			
		}
		$this->staff_model->update_staff($staff['user_id'], array('locations' => json_encode($data)));
	}
	
	/**
	*	@name: load_locations
	*	@desc: ajax function to load staff locations view
	*	@access: public
	*	@param: (via POST) (int) user_id
	*	@return: (view) staff locations
	*/
	function load_locations()
	{
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$data['staff'] = $staff;
		$data['locations'] = json_decode($staff['locations']);
		$this->load->view('staff_locations', isset($data) ? $data : NULL);
	}
	
	
	function list_staffs($query='')
	{
		$staffs = $this->staff_model->search_staffs(array('keyword' => $query));
		$out = array();
		
		foreach($staffs as $staff)
		{
			$out[] = array(
				'id' => $staff['user_id'],
				'name' => $staff['first_name'] . ' ' . $staff['last_name'],
				'username' => $staff['username']
			);
		}
		//$this->output->set_content_type('application/json');
		echo json_encode($out);
	}
	
	/**
	*	@name: load_availability
	*	@desc: ajax function to load staff availability view. If staff doesn't have availability, the funcition will create avaiability record as available all days all times
	*	@access: public
	*	@param: (via POST) (int) user_id
	*	@return: (view) staff availability
	*/
	function load_availability()
	{
		$user_id = $this->input->post('user_id');
		$availability = $this->staff_model->get_availability($user_id);
		if(count($availability)<=0){
			$this->initiate_availability($user_id);
			$availability = $this->staff_model->get_availability($user_id);
		}
		$data['user_id'] = $user_id;
		$data['availability'] = $availability;
		$this->load->view('staff/availability_table_view', isset($data) ? $data : NULL);
	}
	/**
	*	@name: initiate_availability
	*	@desc: initiate value of staff availability time, if there is no data yet. It will be initiated as available all days and all times
	*	@access: public
	*	@param: (via parameter) (int) user_id
	*	
	*/
	function initiate_availability($user_id)
	{
		$values = '';			
		for($day=1; $day <=7; $day++) {
			for($hour=0; $hour <=23; $hour++) {
				$values .= '('.$user_id.','.$day.','.$hour.',1),'; 		
			}
		}  
		$values = rtrim($values,',');
		$sql = "INSERT INTO `user_staff_availability` (`user_id`, `day`, `hour`, `value`) VALUES ".$values;
		$this->db->query($sql);
	}
	/**
	*	@name: update_availability
	*	@desc: update value of staff availability time
	*	@access: public
	*	@param: (via POST) (int) user_id,name,value
	*	
	*/
	function update_availability()
	{
		$value = $this->input->post('value_avail');
		$name = $this->input->post('name');
		$fields = explode('-', $name);		
		$day = $fields[1];
		$hour = $fields[2];
		$this->staff_model->update_available_data($this->input->post('user_id'), $day, $hour, $value);
	}
	
	function update_availabilities()
	{
		$value = $this->input->post('value_avail');
		$names = $this->input->post('names');
		foreach($names as $name)
		{
			$fields = explode('-', $name);		
			$day = $fields[1];
			$hour = $fields[2];
			$this->staff_model->update_available_data($this->input->post('user_id'), $day, $hour, $value);
		}
	}
	/**
	*	@desc Displayes all the available groups in the system and the roles that has been asigned to the staff.
	*
	*   @name get_staff_groups
	*	@access public
	*	@param Post data - sort parameter and user id (staff id)
	*	@return Lists all roles with roles that has been assigned to staffs checked
	*	
	*/
	function get_staff_groups()
	{
		$params = $this->input->post('params',true);
		$data['groups'] = $this->group_model->get_groups($params);
		$data['params'] = $params;
		$this->load->view('ajax_list_groups_staff_profile', isset($data) ? $data : NULL);
	}
	/**
	*	@name: update_groups
	*	@desc: ajax function to add or delete groups 
	*	@access: public
	*	@param: (via POST) 
	*			- (int) user_id
	*			- (int) group_id
	*/
	function update_groups()
	{
		$user_id = $this->input->post('staff_id');
		$group_id = $this->input->post('group_id');
		if($this->staff_model->update_staff_group($user_id,$group_id)){
			echo 'success';	
		}
	}
	
	
	function upload_photo()
	{
		$user_id = $this->input->post('user_id');
		
		$path = UPLOADS_PATH."/staff";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$path = UPLOADS_PATH."/staff/profile";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		
		$path = UPLOADS_PATH."/staff/profile";
		$newfolder = md5($user_id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$dirs=$dir.'/thumbnail';
		if(!is_dir($dirs))
		{
		  mkdir($dirs);
		  chmod($dirs,0777);
		  $fp = fopen($dirs.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$dirs_thumb2 = $dir.'/thumbnail2';
		if(!is_dir($dirs_thumb2))
		{
		  mkdir($dirs_thumb2);
		  chmod($dirs_thumb2,0777);
		  $fp = fopen($dirs_thumb2.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
	
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());			
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			$photo = array(
				'user_id' => $user_id,
				'name' => $file_name,
				'modified' => date('Y-m-d H:i:s'),
				'hero' => ($this->staff_model->has_hero_image($user_id) ? 0 : 1)									
			);
			
			$this->staff_model->add_picture($photo);
			$new_width=216;		
			$new_height=216;		
			copy($dir.'/'.$file_name, $dirs."/".$file_name);
			$target = $dirs."/".$file_name;
			$this->scale_image($target,$target,$new_width,$new_height);	
			
			//create thumbnail 2 
			$thumb2_width = 72;
			$thumb2_height = 72;
			copy($dir.'/'.$file_name, $dirs_thumb2."/".$file_name);
			$target_thumb2 = $dirs_thumb2."/".$file_name;
			$this->scale_image($target_thumb2,$target_thumb2,$thumb2_width,$thumb2_height);
		}
	}
	function scale_image($image,$target,$thumbnail_width,$thumbnail_height)
	{
	  if(!empty($image)) //the image to be uploaded is a JPG I already checked this
	  {		
		list($width_orig, $height_orig) = getimagesize($image);   
		$myImage = imagecreatefromjpeg($image);
		$ratio_orig = $width_orig/$height_orig;
		echo $ratio_orig;
		if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
		   $new_height = $thumbnail_width/$ratio_orig;
		   $new_width = $thumbnail_width;
		} else {
		   $new_width = $thumbnail_height*$ratio_orig;
		   $new_height = $thumbnail_height;
		}
		
		$x_mid = $new_width/2;  //horizontal middle
		$y_mid = $new_height/2; //vertical middle
		
		$process = imagecreatetruecolor(round($new_width), round($new_height)); 
		
		imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
		
		imagedestroy($process);
		imagedestroy($myImage);
		imagejpeg($thumb,$target, 100);
	
	  }
	}
	
	/**
	*	@name: load_picture
	*	@desc: show the profile picture and gallery
	*	@access: public
	*	@param: (via POST) (int) user_id
	*	
	*/
	function load_picture()
	{
		$user_id = $this->input->post('user_id',true);
		$photos = $this->staff_model->get_all_photos($user_id);
		$hero_photo = $this->staff_model->get_hero($user_id);	
		$data['hero_photo'] = $hero_photo;
		$data['photos'] = $photos;
		$data['user_id'] = $user_id;				
		$this->load->view('staff/list_photo', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_custom_attributes
	*	@desc: Update custom attribute of a staff
	*	@access: public
	*	@param: (via POST) custom attributes data
	*	
	*/
	function update_custom_attributes()
	{
		$post_data = $this->input->post();
		$user_id = $this->input->post('user_staff_id',true);
		//delete existing data
		$this->staff_model->delete_staff_custom_attributes($user_id);
		foreach($post_data as $key => $val){
			if($key != 'user_staff_id'){
				//for checkbox and multi select 
				if(modules::run('formbuilder/has_multiple_value',$key)){
					$custom_attr = array(
										'user_id' => $user_id,
										'attribute_name' => $key,
										'attributes' => json_encode($val)
									);
				}else{
					$custom_attr = array(
										'user_id' => $user_id,
										'attribute_name' => $key,
										'attributes' => $val
									);	
				}
				$this->staff_model->insert_staff_custom_attributes($custom_attr);
			}
		}
		echo 'success';
	}
	
	/**
	*	@name: set_hero
	*	@desc: Set hero image
	*	@access: public
	*	@param: (via POST) user_staff_picture_id
	*	
	*/
	function set_hero_photo()
	{
		$user_staff_picture_id = $this->input->post('user_staff_picture_id',true);
		$user_id = $this->input->post('user_id',true);
		$this->staff_model->uset_hero($user_id);
		echo $this->staff_model->update_user_staff_picture($user_staff_picture_id,array('hero'=> 1));
	}
	
	/**
	*	@name: set_hero
	*	@desc: Set hero image
	*	@access: public
	*	@param: (via POST) user id
	*	
	*/
	function unset_hero_photo()
	{
		$user_id = $this->input->post('user_id',true);
		$this->staff_model->uset_hero($user_id);
		echo $this->staff_model->update_user_staff_picture($user_staff_picture_id,array('hero'=> 1));
	}
	/**
	*	@name: reload_staff_edit_page_avatar
	*	@desc: Reloads profile avatars whenever an update to profile image is made
	*	@access: public
	*	@param: (via POST) user id
	*	@return: Reloads staff profile avatars
	*/
	function reload_staff_edit_page_avatar()
	{
		$staff_user_id = $this->input->post('user_id',true);
		echo modules::run('staff/get_profile_picture',$staff_user_id);
	}
	
	function reload_avatar()
	{
		$loggedin_user = $this->session->userdata('user_data');
		echo modules::run('staff/get_profile_picture',$loggedin_user['user_id']);	
	}
	
	
	/**
	*	@name: delete_photo
	*	@desc: Delete staff photo
	*	@access: public
	*	@param: (via POST) photo id
	*	
	*/
	function delete_photo()
	{
		$photo_id = $this->input->post('photo_id',true);
		$photo = $this->staff_model->get_user_staff_photo_by_photo_id($photo_id);
		$path = UPLOADS_PATH.'/staff/profile/'.md5($photo->user_id);
		$sub_folders = array('thumbnail','thumbnail2');
		$file_name = $photo->name;
		modules::run('staff/delete_files',$path,$file_name,$sub_folders);
		if($this->staff_model->delete_photo($photo_id)){
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	/**
	*	@name: update_ratings
	*	@desc: Update rating
	*	@access: public
	*	@param: (via POST) field name of the rating to populate back, user id, ajax reload container, new rating
	*	
	*/
	function update_ratings()
	{
		$field_name = $this->input->post('field_name',true);
		$user_id = $this->input->post('user_id',true);
		$ajax_reload_container = $this->input->post('ajax_reload_container',true);
		$selector = $this->input->post('selector',true);
		$new_rating = $this->input->post('new_rating',true);
		$data = array('rating' => $new_rating);
		$this->staff_model->update_staff($user_id,$data);
		
		echo modules::run('common/field_rating', $field_name, $new_rating,$selector,$ajax_reload_container,$user_id,true,false);
	}
	/**
	*	@name: delete_staff
	*	@desc: Delete single staff
	*	@access: public
	*	@param: (via POST) user id
	*	
	*/
	function delete_staff()
	{
		$user_id = $this->input->post('user_id',true);
		return $this->staff_model->delete_staff($user_id);
	}
	/**
	*	@name: delete_staff
	*	@desc: Delete multiple staff
	*	@access: public
	*	@param: (via POST) user id
	*	
	*/
	function delete_multi_staffs()
	{
		$user_ids = $this->input->post('user_staff_selected_user_id');
		foreach($user_ids as $user_id) 
		{
			$this->staff_model->delete_staff($user_id);
		}
	}
	/**
	*	@name: update_rating_multi_staffs
	*	@desc: Update rating for multiple staff
	*	@access: public
	*	@param: (via POST) user id and new rating
	*	
	*/
	function update_rating_multi_staffs()
	{
		$user_ids = $this->input->post('user_staff_selected_user_id',true);
		$new_rating = $this->input->post('multi_rating',true);
		return $this->staff_model->update_rating_multi_staffs(implode(',',$user_ids),$new_rating);
	}
	/**
	*	@name: update_status_multi_staffs
	*	@desc: Update status for multiple staff
	*	@access: public
	*	@param: (via POST) user id and new stats
	*	
	*/
	function update_status_multi_staffs()
	{
		$user_ids = $this->input->post('user_staff_selected_user_id',true);
		$new_status = $this->input->post('new_multi_status',true);
		return $this->user_model->update_status_multi_users(implode(',',$user_ids),$new_status);
	}
	
	/**
	*	@name: send_email
	*	@desc: Send email to a particular email vai send email modal window UI. 
	*	@access: private
	*	@param: (via POST)
	*	
	*/
	function send_email()
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		//get company profile
		$company = $this->setting_model->get_profile();	
		//get post data
		$email_body = $this->input->post('email_body');
		$selected_user_ids = $this->input->post('selected_user_ids',true);
		$email_template_id = $this->input->post('email_template_select',true);
		
		if($email_template_id){
			$template_info = $this->email_template_model->get_template($email_template_id);
			$email_subject = $template_info->email_subject;
		}
		
		if($selected_user_ids){
			//create obj parameters based on user and email template eg
			$user_ids = json_decode($selected_user_ids);
			foreach($user_ids as $user_id){
				//check if its is welcome email
				$send_email = true;
				if($template_info->email_template_id == 1){
					//check if this staff has already received a welcome email
					$staff = $this->staff_model->get_staff($user_id);
					if($staff['welcome_email_sent'] == 'yes'){
						$send_email = false;	
					}
				}
				if($send_email){
					$email = $this->user_model->get_user_email_from_user_id($user_id);
					//get receiver obj
					$email_obj_params = array(
									'template_id' => $email_template_id,
									'user_id' => $user_id,
									'company' => $company
								);
					$obj = modules::run('email/get_email_obj',$email_obj_params);
					if($email){
						$email_data = array(
									'to' => $email,
									'from' => $company['email_c_email'],
									'from_text' => $company['email_c_name'],
									'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
									'message' => modules::run('email/format_template_body',$email_body,$obj)
								);
						modules::run('email/send_email',$email_data);
						//if welcome email then mark this user has welcome email sent 
						if($template_info->email_template_id == 1){
							$this->staff_model->update_staff($user_id,array('welcome_email_sent' => 'yes'));
						}
					}
				}
			}
		}
		$this->session->unset_userdata('selected_user_ids');
		echo 'success';
	}
	
		
	function load_export_modal($user_ids)
	{
		$data['user_ids'] = $user_ids;
		$this->load->view('export_modal_view', isset($data) ? $data : NULL);
	}
	
	function exporting() {
		$user_ids = $this->input->post('user_ids');
		$user_ids = explode('~', $user_ids);
		$export_id = $this->input->post('export_id');
		if ($export_id == '') {
			return;
		}
		
		$file_name = $this->_export_staff($user_ids, $export_id);
		echo $file_name;
	}
	
	private function _export_staff($user_ids, $export_id) 
	{
		$fields = modules::run('export/get_fields', $export_id);
		
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Staff Master");
		$objPHPExcel->getProperties()->setLastModifiedBy("Staff Master");
		$objPHPExcel->getProperties()->setTitle("Staff Data");
		$objPHPExcel->getProperties()->setSubject("Staff Data");
		$objPHPExcel->getProperties()->setDescription("Staff Data Excel file, generated from Staff Master.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 0;
		$row = 1;
		foreach($fields as $field) {
			if ($i < 26)
			{
				$letter = chr(97 + $i) . $row;
			}
			else
			{
				$letter = chr(97 + ($i-26)) . chr(97 + ($i-26)) . $row;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($letter, $field['title']);
			$i++;
		}
		$i = 0;
		foreach($user_ids as $user_id) {
			$staff = $this->staff_model->get_export_staff($user_id);
			$row++;
			foreach($fields as $field) {
				$is_string = false;
				$value = $field['value']; # Convert $field, $timesheet
				if (strpos($value,'phone') !== false) 
				{
					$is_string = true;
				}
				$employed_as = 'tfn';
				if ($staff['f_tfn'] == STAFF_ABN)
				{
					$employed_as = 'abn';
				}
				$dob = '';
				if ($staff['dob'] != '0000-00-00' && $staff['dob'] != '' && $staff['dob'] != NULL)
				{
					$dob = date('d/m/Y', strtotime($staff['dob']));
				}
				
				$s_choice = "no";
				if ($staff['s_choice'] == "employer")
				{
					$s_choice = "yes";	
				}
				
				$value = str_replace('{title}', $staff['title'], $value);
				$value = str_replace('{rating}', $staff['rating'], $value);
				$value = str_replace('{first_name}', $staff['first_name'], $value);
				$value = str_replace('{last_name}', $staff['last_name'], $value);
				$value = str_replace('{gender}', $staff['gender'], $value);
				$value = str_replace('{dob}', $dob, $value);
				$value = str_replace('{address}', $staff['address'], $value);
				$value = str_replace('{suburb}', $staff['suburb'], $value);
				$value = str_replace('{city}', $staff['city'], $value);
				$value = str_replace('{postcode}', $staff['postcode'], $value);
				$value = str_replace('{state}', $staff['state'], $value);
				$value = str_replace('{country}', $staff['country'], $value);
				$value = str_replace('{email}', $staff['email_address'], $value);
				$value = str_replace('{phone}', $staff['phone'], $value);
				$value = str_replace('{external_id}', $staff['external_staff_id'], $value);
				$value = str_replace('{emergency_contact}', $staff['emergency_contact'], $value);
				$value = str_replace('{emergency_phone}', $staff['emergency_phone'], $value);
				$value = str_replace('{account_name}', $staff['f_acc_name'], $value);
				$value = str_replace('{bsb}', $staff['f_bsb'], $value);
				$value = str_replace('{account_number}', $staff['f_acc_number'], $value);
				$value = str_replace('{employed_as}', $employed_as, $value);
				$value = str_replace('{tfn_number}', $staff['f_tfn'], $value);
				$value = str_replace('{abn_number}', $staff['f_abn'], $value);
				$value = str_replace('{super_choice}', $s_choice, $value);
				$value = str_replace('{super_employee_id}', $staff['s_employee_id'], $value);
				$value = str_replace('{super_fund_name}', $staff['s_fund_name'], $value);
				$value = str_replace('{super_membership_number}', $staff['s_membership'], $value);
				
				if ($i < 26)
				{
					$letter = chr(97 + $i) . $row;
				}
				else
				{
					$letter = chr(97 + ($i-26)) . chr(97 + ($i-26)) . $row;
				}
				if ($is_string) 
				{
					$objPHPExcel->getActiveSheet()->getStyle($letter)->getNumberFormat()->setFormatCode('@');
					$objPHPExcel->getActiveSheet()->getCell($letter)->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);
				}
				else
				{
					$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);
				}
				
				$i++;
			}
			$i=0;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('staff');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = 'staff_' . time() . ".csv";
		$objWriter->save("./exports/staff/" . $file_name);
		return $file_name;
	}
}