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
					$date = json_decode($value);
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
						
						$thumbnail = $dir . '/thumbnail';
						mkdir($thumbnail);
						chmod($thumbnail,0777);
						$fp = fopen($thumbnail.'/index.html', 'w');
						fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
						fclose($fp);
						
						$thumbnail2 = $dir.'/thumbnail2';
						mkdir($thumbnail2);
						chmod($thumbnail2);
						$fp = fopen($thumbnail2.'/index.html', 'w');
						fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
						fclose($fp);
					}
					
					foreach($pictures as $picture) {
						$hero = (!$hero) ? 1 : 0;
						# Move file across
						$source = UPLOADS_PATH . '/tmp/' . $picture;
						$destination = UPLOADS_PATH . '/staff/' . $user_id . '/' . $picture;
						rename($source, $destination);
						
						
						
						$this->staff_model->add_picture(array(
							'user_id' => $user_id,
							'name' => $picture,
							'hero' => $hero
						));
					}					
				}
			}
		}
		$this->form_model->accept_applicant($applicant_id);
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
	