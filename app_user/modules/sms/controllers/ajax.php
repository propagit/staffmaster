<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbf_model');
	}
	
	function list_receivers() {
		$shift_ids = explode(',', $this->input->post('shift_ids'));
		$users = array();
		if(count($shift_ids) > 0){
			foreach($shift_ids as $shift_id) {
				$shift = modules::run('job/shift/get_shift', $shift_id);
				if ($shift['staff_id']) {
					$users[] = modules::run('user/get_user', $shift['staff_id']);
				}
				
			}
		}
		$data['users'] = $users;
		$this->load->view('receivers_list_view', isset($data) ? $data : NULL);
	}
	
	function sendsms() {
		$shift_ids = explode(',', $this->input->post('selected_shift_ids'));
		if(count($shift_ids) > 0){
			foreach($shift_ids as $shift_id) {
				$shift = modules::run('job/shift/get_shift', $shift_id);
				if ($shift['staff_id']) {
					$user = modules::run('user/get_user', $shift['staff_id']);
					$to = mobile_phone($user['mobile']);
					$source = '447624812938';
					$msg = $this->input->post('msg');
					$msg = str_replace('{FirstName}', $user['first_name'], $msg);
					$role = modules::run('attribute/role/display_role', $shift['role_id']);
					$date = date('d-m-Y', $shift['start_time']);
					$time = date('H:i', $shift['start_time']);
					$venue = modules::run('attribute/venue/display_venue', $shift['venue_id']);
					$code = random_string('numeric', 3);
					$msg = str_replace('{Role}', $role, $msg);
					$msg = str_replace('{Date}', $date, $msg);
					$msg = str_replace('{Time}', $time, $msg);
					$msg = str_replace('{Venue}', $venue, $msg);
					$msg = str_replace('{Y}', 'Y' . $code, $msg);
					$msg = str_replace('{N}', 'N' . $code, $msg);
					$company = modules::run('setting/company_profile');
					$msg = str_replace('{CompanyName}', $company['company_name'], $msg);
					$twoway = true;
					$this->cbf_model->send_sms($to, $source, $msg, $twoway);
				}				
			}
		}
	}
}