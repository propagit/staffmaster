<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
		$this->load->model('user/user_model');
	}
	
	function search_staffs()
	{
		$data['staffs'] = $this->staff_model->search_staffs($this->input->post());
		$this->load->view('search_results', isset($data) ? $data : NULL);		
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
			'address' => $data['address'],
			'suburb' => $data['suburb'],			
			'state' => $data['state'],
			'postcode' => $data['postcode'],
			'country' => $data['country'],
			'phone' => $data['phone'],
			'modified_on' => date('Y-m-d H:i:s')
		);
		$this->user_model->update_user($data['user_id'], $user_data);
		$staff_data = array(
			'external_staff_id' => $data['external_staff_id'],
			'rating' => $data['profile_rating'],
			'gender' => $data['gender'],
			#'dob' => $data['dob_day'] . '-' . $data['dob_month'] . '-' . $data['dob_year'],
			'emergency_contact' => $data['emergency_contact'],
			'emergency_phone' => $data['emergency_phone'],
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
		//echo modules::run('common/field_rating', 'rating', $data['rating']);
		echo modules::run('common/field_rating', 'profile_rating', $data['profile_rating'],false,'basic','wp-rating',true,$data['user_id']);
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
			'f_abn' => $data['f_abn']
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
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
		for($day=1; $day <=7; $day++) {
			for($hour=0; $hour <=23; $hour++) {
				$data = array(
					'user_id' => $user_id,
					'day' => $day,
					'hour' => $hour,
					'value' => 1
				);
				$this->staff_model->insert_availability_data($user_id, $data);
			}
		}				
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
		
		$path = "./uploads/staff";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$path = "./uploads/staff/profile";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		
		$path = "./uploads/staff/profile";
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
			$this->load->model('common/common_model');
			$this->common_model->add_picture($photo);
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
		//error_reporting(E_ALL);
		
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
		echo modules::run('common/profile_picture','',$staff_user_id);
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
		$path = './uploads/staff/profile/'.md5($photo->user_id);
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
		return $this->user_model->update_user($user_id,array('status' => 2));	
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
		return $this->user_model->delete_multi_users(implode(',',$user_ids));
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
}