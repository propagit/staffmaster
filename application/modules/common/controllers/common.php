<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*    @class_desc: controller to handle common module such as field_select and can be used in any views/modules
*    
*/

class Common extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('staff/staff_model');
	}
	
	/**
	*	@name: field_select
	*	@desc: custom select input field
	*	@access: public
	*	@param: - $array: an array of field value/label pairs
	*			- $field_name: string of field name
	*			- $field_value (optional): selected value of field
	*			- $size (optional): size 
	*	@return: custom view of select input field
	*/
	function field_select($array, $field_name, $field_value=null, $size=null) {
		$data = array(
			'data' => $array,
			'field_name' => $field_name,
			'field_value' => $field_value,
			'size' => $size
		);
		$this->load->view('field_select', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: field_select_states
	*	@desc: custom select states field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected state code
	*			- $size (optional): size 
	*	@return: custom view of select states field
	*/
	function field_select_states($field_name, $field_value=null, $size=null) {
		$states = $this->common_model->get_states();
		$array = array();
		foreach($states as $state)
		{
			$array[] = array(
				'value' => $state['code'],
				'label' => $state['name']
			);
		}
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: field_select_countries
	*	@desc: custom select countries field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected country code
	*			- $size (optional): size 
	*	@return: custom view of select states field
	*/
	function field_select_countries($field_name, $field_value=null, $size=null) {
		$countries = $this->common_model->get_countries();
		if ($field_value == null || $field_value=='')
		{
			$field_value = 'AU';
		}
		$array = array();
		foreach($countries as $country)
		{
			$array[] = array(
				'value' => $country['code'],
				'label' => $country['name']
			);
		}
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: field_select_genders
	*	@desc: custom select genders field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected gender value
	*			- $size (optional): size
	*	@return: custom select gender field
	*/
	function field_select_genders($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => GENDER_MALE, 'label' => 'Male'),
			array('value' => GENDER_FEMALE, 'label' => 'Female')
		);
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	
	function field_select_dob($field_name, $field_value=null, $size=null) {
		$day_array = array();
		$month_array = array();
		$year_array = array();
		for($i=1; $i<=30; $i++) {
			$x = sprintf('%02d',$i);
			$day_array[] = array('value' => $x, 'label' => $x);
		}
		for($i=1; $i<=12; $i++) {
			$x = sprintf('%02d',$i);
			$month_array[] = array('value' => $x, 'label' => $x);
		}
		for($i=2012; $i>=1990;$i--) {
			$year_array[] = array('value' => $i, 'label' => $i);
		}
		$field_day = null;
		$field_month = null;
		$field_year = null;
		if ($field_value) {
			$fields = explode('-', $field_value);
			if (isset($fields[0])) { $field_day = $fields[0]; }
			if (isset($fields[1])) { $field_month = $fields[1]; }
			if (isset($fields[2])) { $field_year = $fields[2]; }
		}
		$output = $this->field_select($day_array, $field_name . '-day', $field_day);
		return $output;
		$output .= $this->field_select($month_array, $field_name . '-mth', $field_month);
		$output .= $this->field_select($year_array, $field_name . '-year', $field_year);
		return $output;
	}
	
	/**
	*	@name: field_select_title
	*	@desc: custom select title field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected gender value
	*			- $size (optional): size
	*	@return: custom select title field
	*/
	function field_select_title($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => 'Mr', 'label' => 'Mr'),
			array('value' => 'Miss', 'label' => 'Miss'),
			array('value' => 'Mrs', 'label' => 'Mrs')
		);
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*    @name: field_rating
	*    @desc: custom input field for rating
	*    @access public
	*    @param: - $field_name
	*			- $field_value (optional) 
	*    @return: custom input field for rating 
	*/
	function field_rating($field_name,$field_value=null,$selector='basic',$ajax_reload_container = 'wp-rating',$user_id = 0,$ajax_update = false,$disabled=false) {
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['disabled'] = $disabled;
		$data['selector'] = $selector;
		$data['ajax_reload_container'] = $ajax_reload_container;
		$data['ajax_update'] = $ajax_update;
		$data['user_id'] = $user_id;
		$this->load->view('field_rating', isset($data) ? $data : NULL);
	}
	
	
	function menu_dropdown($array, $id, $label) {
		$data = array(
			'data' => $array,
			'id' => $id,
			'label' => $label
		);
		$this->load->view('menu_dropdown', isset($data) ? $data : NULL);
	}
	
	function menu_dropdown_states($id, $label) {
		$states = $this->common_model->get_states();
		$array = array();
		$array[] = array('value' => '', 'label' => 'Any');
		foreach($states as $state)
		{
			$array[] = array(
				'value' => $state['code'],
				'label' => $state['name']
			);
		}
		return $this->menu_dropdown($array, $id, $label);
	}
	
	
	function dropdown_actions($target, $actions)
	{
		$data['target'] = $target;
		$data['actions'] = $actions;
		$this->load->view('dropdown_actions', isset($data) ? $data : NULL);
	}
	
	function dropdown_status($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_status', isset($data) ? $data : NULL);
	}
	
	
	
	function dropdown_supers($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['supers'] = $this->common_model->get_supers(true);
		$this->load->view('dropdown_super', isset($data) ? $data : NULL);
	}
	
		
	function list_supers()
	{
		$supers = $this->common_model->get_supers();
		foreach($supers as $super) { echo '"' . $super['name'] . '",'; } 
	}
	
	function check_super()
	{
		
		$name = $this->input->post('super_value');
		$supers = $this->common_model->get_supers();
		$found = 1;
		foreach($supers as $super)
		{
			if ($super['name'] == $name)
			{
				$found = 0;
			}
		}
		echo $found;
		//return $found;
		
	}
	
		
	function dropdown_dob($day=null, $month=null, $year=null)
	{
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('dropdown_dob', isset($data) ? $data : NULL);
	}
	
	function break_time($string)
	{
		$a = json_decode($string);
		
		if (count($a) > 0) 
		{
			$total = 0;
			foreach($a as $break)
			{
				$total += $break->length;
			}
			echo $total/60 . ' mins';
		}
		else
		{
			echo 0;
		}
	}
	
	
	
	
	/**
	*    @desc Show the location that only can be used in staff profile as we have multiselect element
	*    @name dropdown_location
	*    @access public
	*    @param $field_name, $field_value=null; $field_name: name of that element such as location_id or id_location; $field_value: value if the location that need to show
	*    @return loads the location select element	
	* 
	*/

	function dropdown_location($field_name, $field_value=null)
	{

		$data['locations'] = $this->common_model->get_locations();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_location', isset($data) ? $data : NULL);
	}
	
	function dropdown_get_area()
	{
		
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$scs = array();
		if(isset($staff_locations)){
			foreach($staff_locations as $sc)
			{
				if($sc!=''){
				$scs[] = $sc;}
			}
		}
		if(!isset($_POST['loc'])){$loc='';}else {$loc= $this->input->post('loc');}
		if($loc!=''){
			$new_loc = explode('#',$_POST['loc']);
			foreach($new_loc as $nl)
			{
				if($nl!=''){
				$scs[] = $nl;}
			}
		}
		$locats = $this->common_model->get_locations();
		//$areas = $this->common_model->get_locations_child($loc);
		//$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		
		$print='<select data-placeholder="Select Your Area" class="selectMultiple" multiple="multiple" tabindex="6" >
			<option value=""></option>';
			
			foreach($locats as $lct)
			{
				//$detail = $this->common_model->get_locations_detail($lct['location_id']);
				$print.='<optgroup label="'.$lct['name'].'">';
				$areas = $this->common_model->get_locations_child($lct['location_id']);
				foreach($areas as $area)
				{
					if(in_array($area['location_id'],$scs)){$select=" selected=selected ";}else{$select='';}
					$print.='<option value="'.$area['location_id'].'"'.$select.'><b>'.$area['name'].'</b></option>';
					$areas2 = $this->common_model->get_locations_child($area['location_id']);
					foreach($areas2 as $ar)
					{	
						if(in_array($ar['location_id'],$scs)){$select=" selected=selected ";}else{$select='';}
						$print.='<option value="'.$ar['location_id'].'"'.$select.'>&nbsp;&nbsp;&nbsp;&nbsp;'.$ar['name'].'</option>';
					}
				}
				$print.='</optgroup>';
			}
		$print.='</select> <script>	$(".select").select2();	$(".selectMultiple").select2();</script>';
		
		
		echo $print;
	}
	
	
	/**
	*    @desc Show the location that can used in any forms that required location input. such as search staff form or add staff or add venue
	*    @name dropdown_location_form
	*    @access public
	*    @param $field_name, $field_value=null; $field_name: name of that element such as location_id or id_location; $field_value: value if the location that need to show
	*    @return loads the location select element	
	* 
	*/
	
	function dropdown_location_form($field_name, $field_value=null)
	{
		$data['locations'] = $this->common_model->get_locations();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_location_form', isset($data) ? $data : NULL);
	}
	
	function dropdown_get_area_state()
	{				
		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select name="area_location_state" id="area_location_state" class="form-control auto-width">
			<option value="">Select Area</option>';
			if($loc > 0){

			
				foreach($areas as $area)
				{
					//if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</select>';
		
		
		echo $print;
	}
	
	function dropdown_form_get_area_state()
	{				
		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select name="'.$field_name.'" id="area_location_state" class="form-control auto-width">
			<option value="">Select Area</option>';
			if($loc > 0){

			
				foreach($areas as $area)
				{
					//if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</select>';
		
		
		echo $print;
	}
	function dropdown_get_area_init()
	{

		$loc= $this->input->post('loc');
		$field_name = $this->input->post('field_name');
		$field_value = $this->input->post('field_value');
		$staff_locations = json_decode($field_value);
		$areas = $this->common_model->get_locations_child($loc);
		$detail = $this->common_model->get_locations_detail($loc);
		$print='';
		$select='';
		$print='<select data-placeholder="Select Your Area" class="selectMultiple" multiple="multiple" tabindex="6" >
			<option value=""></option>';
			if($loc > 0){
			$print.='<optgroup label="'.$detail['name'].'">';
			
				foreach($areas as $area)
				{
					if(in_array($area['location_id'],$staff_locations)){$select=" selected=selected ";}
					$print.='<option value="'.$area['location_id'].'"'.$select.'>'.$area['name'].'</option>';
					
				}
			}
		$print.='</optgroup></select> <script>	$(".select").select2();	$(".selectMultiple").select2();</script>';
		
		
		echo $print;
	}
	function define_area()
	{
		$loc='';
		$suburb = $this->input->post('suburb');
		$suburb = str_replace('&amp;','&',$suburb);

		$detail = $this->common_model->get_locations_byname($loc,$suburb);
		
		echo $detail['location_id'].'#';
		
	}
	function upload_picture_file($field_name,$field_value=NULL)
	{
		$user_id = $this->input->post('user_id');
		//$user_id = $this->common_model->get_user_data($staff_id);
		
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
				'hero' =>0										
			);
			$this->common_model->add_picture($photo);
			$new_width=220;		
			$new_height=220;		
			copy($dir.'/'.$file_name, $dirs."/".$file_name);
			$target = $dirs."/".$file_name;
			//echo $target.'<br>';
			$this->scale_image($target,$target,$new_width,$new_height);	
		}
		redirect('staff/edit/'.$user_id);
	}
	
	
	function upload_picture($field_name,$field_value=NULL)
	{
		
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('upload_picture', isset($data) ? $data : NULL);
		
		
		
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
	function setherophoto()
	{
		$staff_id = $_POST['staff_id'];
		$photo_id = $_POST['photo_id'];
		$this->common_model->update_hero($staff_id,$photo_id);
	}
	function deletephoto()
	{
		$staff_id = $_POST['staff_id'];
		$photo_id = $_POST['photo_id'];
		$this->common_model->delete_photo($staff_id,$photo_id);
	}
	
	function set_availability($field_name,$field_value=NULL)
	{
	
		if($field_value==''){
			$data['monday'] = '';
			$data['tuesday'] = '';
			$data['wednesday'] = '';
			$data['thursday'] = '';
			$data['friday'] = '';
			$data['saturday'] = '';
			$data['sunday'] = '';
		}else{
			$data['monday'] = json_decode($field_value['monday']);
			$data['tuesday'] = json_decode($field_value['tuesday']);
			$data['wednesday'] = json_decode($field_value['wednesday']);
			$data['thursday'] = json_decode($field_value['thursday']);
			$data['friday'] = json_decode($field_value['friday']);
			$data['saturday'] = json_decode($field_value['saturday']);
			$data['sunday'] = json_decode($field_value['sunday']);
		}
		$data['num'] = 0;
		$this->load->view('set_availability', isset($data) ? $data : NULL);
	}
	
	function add_availability()
	{
		$from_day = $this->input->post('from_day');
		$to_day = $this->input->post('to_day');
		$start_time = $this->input->post('start_time');
		$finish_time = $this->input->post('finish_time');
		$num = $this->input->post('num');
		$data['from_day'] = $from_day;
		$data['to_day'] = $to_day;
		$data['start_time'] = $start_time;
		$data['finish_time'] = $finish_time;
		$data['num'] = $num;
		$this->load->view('dropdown_availability', isset($data) ? $data : NULL);
	}
	/**
	*    @desc To display profile picture based on user_id
	*   
	*    @param $field_name, $field_value=null; $field_name: name of that element such as location_id or id_location; $field_value: value if the location that need to show
	*    @return loads the profile picture
	* 
	*/
	function profile_picture($field_name, $field_value=NULL)
	{		
		
		$staff = $this->staff_model->get_staff($field_value);
		$photo = $this->staff_model->get_hero($field_value);
		$data['staff'] = $staff;
		$data['photo'] = $photo;

		$this->load->view('admin_profile_picture', isset($data) ? $data : NULL);
	}
}