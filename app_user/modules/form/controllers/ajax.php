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
		$form_id = (isset($fields[0]['form_id'])) ? $fields[0]['form_id'] : 0;
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
			'emergency_phone' => '',
			'f_acc_name' => '',
			'f_acc_number' => '',
			'f_bsb' => '',
			's_choice' => 'own',
			's_fund_name' => '',
			's_membership' => '',
			'locations' => ''		
		);
		
		# Copy staff personal details
		foreach($fields as $field) {
			if (isset($staff_data[$field['name']])) {
				if ($field['name'] == 'dob') {
					$date = json_decode($field['value']);
					$staff_data['dob'] = $date->year . '-' . $date->month . '-' . $date->day;
				} else {
					$staff_data[$field['name']] = $field['value'];
				}
			}
			if ($field['name'] == 'location') {
				$parent_id = $field['value'];
				$data = array();
				$location = array();
				$all = modules::run('attribute/location/get_locations', $parent_id);
				foreach($all as $a) {
					$location[] = $a['location_id'];
				}
				$data[$parent_id] = $location;
				$staff_data['locations'] = json_encode($data);
			}
		}
		$staff_id = $this->staff_model->insert_staff($staff_data);
		
		
		# Copy group, role, photos, and others
		$this->load->helper('image');
		
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
						rename($source, $destination);
						
						# Create thumb
						$thumb_size = 216; # Thumbnail size			
						#copy($destination, $dir_thumb . '/' . $picture); # Copy to thumb directory
						scale_image($destination, $dir_thumb . '/' . $picture, $thumb_size, $thumb_size);
						
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
		$custom_fields = $this->form_model->get_custom_fields($form_id);
		foreach($custom_fields as $custom_field) {
			foreach($fields as $field) {
				if ($field['name'] == $custom_field['field_id']) {
					$array = false;
					if ($custom_field['type'] == 'file') {
						$array = true;
						rename(UPLOADS_PATH . '/tmp/' . $field['value'], UPLOADS_PATH . '/staff/' . $user_id . '/' . $field['value']);
					}
					$this->staff_model->update_custom_field($user_id, $field['name'], $field['value'], $array);
				}
			}
		}
		
		#$this->form_model->accept_applicant($applicant_id);
		$this->form_model->delete_applicant($applicant_id);
	}
	
	function reject_applicant() {
		$applicant_id = $this->input->post('applicant_id');
		#$this->form_model->reject_applicant($applicant_id);
		$this->form_model->delete_applicant($applicant_id);
	}
	
	function reject_applicants() {
		$applicant_ids = $this->input->post('applicant_ids');
		foreach($applicant_ids as $applicant_id) {
			#$this->form_model->reject_applicant($applicant_id);
			$this->form_model->delete_applicant($applicant_id);
		}
	}
	
	function print_applicants() {
		$applicant_ids = $this->input->post('applicant_ids');
		
		# As PDF creation takes a bit of memory, we're saving the created file in /uploads/pdf/
		$filename = "applicants_" . date('Y-m-d');
		#if(!file_exists(UPLOADS_PATH.'/pdf/'.$filename.'.pdf')){
			$pdfFilePath = UPLOADS_PATH."/pdf/$filename.pdf";
			
			$dir = UPLOADS_PATH.'/pdf/';
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			 
			ini_set('memory_limit','128M'); # boost the memory limit if it's low 
			
			$applicants = array();
			foreach($applicant_ids as $applicant_id)
			{
				$data['applicant_id'] = $applicant_id;
				$data['applicant'] = $this->form_model->get_applicant($applicant_id);
				$applicants[] = $this->load->view('applicant/download_view', isset($data) ? $data : NULL, true);
			}
			$html = implode('<pagebreak />', $applicants);
			
					
			$this->load->library('pdf');
			$pdf = $this->pdf->load(); 			
			$stylesheet = file_get_contents('./assets/css/pdf.css');
			$custom_styles = '<style>'.modules::run('custom_styles').'</style>';
			//echo $custom_styles;exit();
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($custom_styles,1);
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, 'F'); // save to file 
		#}
		
		echo $filename . ".pdf";
	}
}
	