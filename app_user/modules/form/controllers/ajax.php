<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('form_model');
	}
	
	function add_form() {
		$input = $this->input->post();
		if (!$input['name']) {
			echo json_encode(array('ok' => false));
			return;
		}
		$form_id = $this->form_model->add_form($input);
		echo json_encode(array('ok' => true, 'form_id' => $form_id));
	}
	
	function delete_form() {
		$form_id = $this->input->post('form_id');
		$this->form_model->delete_form($form_id);
	}
	
	function update_settings() {
		$input = $this->input->post();
		$this->form_model->update_form($input['form_id'], array('receive_email' => $input['receive_email']));
	}
	
	function active_field() {
		$input = $this->input->post();
		if ($this->form_model->active_field($input['form_id'], $input['label'], $input['name'])) {
			echo 'success';
		} else {
			echo 'default';
		}
	}
	
	function require_field() {
		$input = $this->input->post();
		if ($this->form_model->require_field($input['form_id'], $input['name'])) {
			echo 'success';
		} else {
			echo 'default';
		}
	}
	
	function view_applicant($applicant_id) {
		$data['applicant_id'] = $applicant_id;
		$data['applicant'] = $this->form_model->get_applicant($applicant_id);
		$this->load->view('applicant/modal_view', isset($data) ? $data : NULL);
	}
	
	function accept_applicant() {
		$applicant_id = $this->input->post('applicant_id');
		$status = $this->input->post('status');
		$fields = $this->form_model->get_applicant($applicant_id);
		$user_data = array(
			'status' => $status,
			'is_admin' => 0,
			'is_staff' => 1,
			'is_client' => 0,
			'email_address' => '',
			'username' => '',
			'password' => '',
			'title' => '',
			'first_name' => '',
			'last_name' => '',
			'address' => '',
			'suburb' => '',
			'city' => '',
			'state' => '',
			'postcode' => '',
			'country' => '',
			'phone' => '',
			'mobile' => ''
		);
		
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');
		
		# Copy user details
		foreach($fields as $field) {
			if (isset($user_data[$field['name']])) {
				$user_data[$field['name']] = $field['value'];
			}
			if ($field['name'] == 'email') {
				if (valid_email($field['value']) && !$this->user_model->check_user_email($field['value'])) {
					$user_data['email_address'] = $field['value'];
					$user_data['username'] = $field['value'];
				}
			}
		}
		$user_id = $this->user_model->insert_user($user_data);
		
		$staff_data = array(
			'user_id' => $user_id,
			'gender' => '',
			'dob' => '',
			'emergency_contact' => '',
			'emergency_phone' => ''			
		);
		
		# Copy staff personal details
		foreach($fields as $field) {
			if (isset($staff_data[$field['name']])) {
				if ($field['name'] == 'dob') {
					$date = json_decode($field['value']);
					$staff_data['dob'] = $date->year . '-' . $date->month . '-' . $date->day;
				}
				else {
					$staff_data[$field['name']] = $field['value'];
				}				
			}
		}
		$staff_id = $this->staff_model->insert_staff($staff_data);
		
		
		# Copy group, role
		foreach($fields as $field) {
			if ($field['name'] == 'group') {
				$groups = json_decode($field['value']);
				if (count($groups) > 0) {
					foreach($groups as $group_id) {
						$this->staff_model->add_staff_group($user_id, $group_id);
					}
				}
			}
			if ($field['name'] == 'availability') {
				$days = json_decode($field['value']);
				$values = '';			
				for($day=1; $day <=7; $day++) {
					for($hour=0; $hour <=23; $hour++) {
						$ok = in_array($day, $days) ? '1' : '0';
						$values .= '('.$user_id.','.$day.','.$hour.','.$ok.'),'; 		
					}
				}  
				$values = rtrim($values,',');
				$sql = "INSERT INTO `user_staff_availability` (`user_id`, `day`, `hour`, `value`) VALUES ".$values;
				$this->db->query($sql);
			}
			if ($field['name'] == 'role') {
				$roles = json_decode($field['value']);
				if (count($roles) > 0) {					
					foreach($roles as $role_id) {
						$this->staff_model->add_staff_role($user_id, $role_id);
					}
				}
			}
			if ($field['name'] == 'picture') {
				$pictures = json_decode($field['value']);
				if (count($pictures) > 0) {
					$hero = 0;
					$dir = UPLOADS_PATH . '/staff/' . $user_id;
					if(!is_dir($dir))
					{
						mkdir($dir);
						chmod($dir,0777);
						$fp = fopen($dir.'/index.html', 'w');
						fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
						fclose($fp);
						
						$dir_thumb = $dir . '/thumb';
						mkdir($dir_thumb);
						chmod($dir_thumb,0777);
						$fp = fopen($dir_thumb.'/index.html', 'w');
						fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
						fclose($fp);
						
					}
					
					foreach($pictures as $picture) {
						$hero = (!$hero) ? 1 : 0;
						# Move file across
						$source = UPLOADS_PATH . '/tmp/' . $picture;
						$destination = $dir . '/' . $picture;
						copy($source, $destination);
						
						# Create thumb						
						copy($destination, $dir_thumb . '/' . $picture); # Copy to thumb directory
						$thumb_size = 216; # Thumbnail size
						
						$config['image_library'] = 'gd2';
						$config['source_image'] = $dir_thumb . '/' . $picture;
						$config['create_thumb'] = FALSE;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = $thumb_size;
						$config['height'] = $thumb_size;
						
						list($width_orig, $height_orig) = getimagesize($dir_thumb . '/' . $picture);
						if ($height_orig != $width_orig) {
							if ($height_orig > $width_orig) { # If height is larger than width
								$new_width = $thumb_size;
								$new_height = $thumb_size * $height_orig / $width_orig;
								$config['x_axis'] = 0;
								$config['y_axis'] = round(($new_height - $new_width) / 2);
							} else { # Height is smaller than width
								$new_height = $thumb_size;
								$new_width = $thumb_size * $width_orig / $height_orig;
								$config['x_axis'] = round(($new_width - $new_height) / 2);
								$config['y_axis'] = 0;
							}
						}
						
						$this->load->library('image_lib', $config); 
						$this->image_lib->crop();
												
						# Add to database 
						$this->staff_model->add_picture(array(
							'user_id' => $user_id,
							'name' => $picture,
							'hero' => $hero
						));
					}					
				}
			}
			
		}
		
		
		
		# Copy custom attributes
		$custom_fields = $this->form_model->get_custom_fields($fields);
		foreach($custom_fields as $custom_field) {
			foreach($fields as $field) {
				if ($field['name'] == $custom_field['field_id']) {
					$array = false;
					if ($custom_field['type'] == 'file') {
						$array = true;
						copy(UPLOADS_PATH . '/tmp/' . $field['value'], UPLOADS_PATH . '/staff/' . $user_id . '/' . $field['value']);
					}
					$this->staff_model->update_custom_field($user_id, $field['name'], $field['value'], $array);
				}
			}
		}
		
		#$this->form_model->accept_applicant($applicant_id);
	}
	
	function reject_applicant() {
		$applicant_id = $this->input->post('applicant_id');
		$this->form_model->reject_applicant($applicant_id);
	}
	
	function reject_applicants() {
		$applicant_ids = $this->input->post('applicant_ids');
		foreach($applicant_ids as $applicant_id) {
			$this->form_model->reject_applicant($applicant_id);
		}
	}
}
	