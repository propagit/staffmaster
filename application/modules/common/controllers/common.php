<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*    @class_desc    This is common controller to handle common module such as state or country drop down. It will only called the function and can be used in any views/modules
*    @class_comments Dependent on Common_model. List of common module is: action, status,supers, states, countries, titles, genders, dob, location
*    
*/

class Common extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
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
	
	function check_super($name)
	{
		$supers = $this->common_model->get_supers();
		$found = false;
		foreach($supers as $super)
		{
			if ($super['name'] == $name)
			{
				$found = true;
			}
		}
		return $found;
	}
	
	function dropdown_states($field_name, $field_value=null)
	{
		$data['states'] = $this->common_model->get_states();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_states', isset($data) ? $data : NULL);
	}
	
	function dropdown_countries($field_name, $field_value=null)
	{
		$data['countries'] = $this->common_model->get_countries();
		$data['field_name'] = $field_name;
		if ($field_value == null || $field_value=='')
		{
			$field_value = 'AU';
		}
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_countries', isset($data) ? $data : NULL);
	}
	
	function dropdown_titles($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_titles', isset($data) ? $data : NULL);
	}
	
	function dropdown_genders($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_genders', isset($data) ? $data : NULL);
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
	*    @desc Show the rating input element
	*    @name rating
	*    @access public
	*    @param $field_name, $field_value=null; 
	*    @return loads the rating select element	
	* 
	*/
	function select_rating($field_name,$field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('select_rating', isset($data) ? $data : NULL);
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
		$staff_id = $this->input->post('staff_id');
		$user_id = $this->common_model->get_user($staff_id);
		
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
		$newfolder = md5($staff_id);
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
				'staff_id' => $staff_id,
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
		redirect('staff/edit/'.$staff_id);
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
		$data['field_value'] = $field_value;

		$this->load->view('set_availability', isset($data) ? $data : NULL);
	}
}