<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Shift extends MX_Controller {

	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->is_client = modules::run('auth/is_client');
	}


	function form_create($job_id)
	{
		$data['job_id'] = $job_id;
		$job = $this->job_model->get_job($job_id);
		$start_date = '';
		$finish_time = '';
		$break_start_at = '';
		if ($job['type'] == 1)
		{
			$start_date = $job['start_date'] . ' 09:00';
			$finish_time = $job['start_date'] . ' 17:00';
			$break_start_at = $job['start_date'] . ' 12:00';
		}
		$data['start_date'] = $start_date;
		$data['finish_time'] = $finish_time;
		$data['break_start_at'] = $break_start_at;
		$this->load->view('shift_create_form', isset($data) ? $data : NULL);
	}

	function row_view($shift_id)
	{
		$data['is_client'] = $this->is_client;
		$data['shift'] = $this->job_shift_model->get_job_shift($shift_id);
		$this->load->view('shift/row_view', isset($data) ? $data : NULL);
	}

	function search_staff_form($shift_id) {
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['shift'] = $shift;
		$location_id = null;
		$parent_id = null;
		$venue = modules::run('attribute/venue/get_venue', $shift['venue_id']);
		if ($venue) {
			$location = modules::run('attribute/location/get_location', $venue['location_id']);
			if ($location) {
				$location_id = $location['location_id'];
				$parent_id = $location['parent_id'];
			}
		}
		$data['parent_id'] = $parent_id;
		$data['location_id'] = $location_id;
		$this->load->view('shift/search_staff/search_form', isset($data) ? $data : NULL);
	}

	function search_candidate_form($shift_ids) {
		$data['shift_ids'] = $shift_ids;
		$this->load->view('shift/search_staff/search_candidate_form', isset($data) ? $data : NULL);
	}

	function add_expense_form($shift_id) {
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/expense/add_form', isset($data) ? $data : NULL);
	}

	function get_shift($shift_id) {
		return $this->job_shift_model->get_job_shift($shift_id);
	}

	/**
	*	@name: field_select_status
	*	@desc: custom select shift status field
	*	@access: public
	*	@param: - $field_name
	*			- $field_value (optional)
	*			- $size (optional)
	*	@return: custom select staff status field
	*/
	function field_select_status($field_name, $field_value=null, $size=null)
	{
		$temp_field_value = $field_value;
		$array = array(
			array('value' => SHIFT_UNASSIGNED, 'label' => 'Un-Filled Shifts'),
			array('value' => SHIFT_UNCONFIRMED, 'label' => 'Un-Confirmed Shifts'),
			array('value' => SHIFT_REJECTED, 'label' => 'Rejected Shifts'),
			array('value' => SHIFT_CONFIRMED, 'label' => 'Confirmed Shifts'),
			array('value' => SHIFT_FINISHED, 'label' => 'Completed Shifts')
		);
		if($field_value == "" || $field_value == "all") {
			$temp_field_value = null;
		}
		else if($field_value === 0){
			$temp_field_value = SHIFT_UNASSIGNED; #'Un-Filled Shifts';
		}
		else if($field_value == -2){
			$temp_field_value = SHIFT_REJECTED; #'Rejected Shifts';
		}
		return modules::run('common/field_select', $array, $field_name, $temp_field_value, $size);
	}

	function field_select_fields($field_name, $field_value=null, $size=null)
	{
		$fields = array(
			#array('value' => 'job_date', 'label' => 'Job Date'),
			array('value' => 'start_time', 'label' => 'Start Time'),
			array('value' => 'finish_time', 'label' => 'Finish Time'),
			#array('value' => 'break_time', 'label' => 'Break Time'),
			array('value' => 'venue_id', 'label' => 'Venue'),
			array('value' => 'role_id', 'label' => 'Role'),
			array('value' => 'uniform_id', 'label' => 'Uniform'),
			array('value' => 'payrate_id', 'label' => 'Pay Rate'),
			array('value' => 'supervisor_id', 'label' => 'Supervisor')
			#array('value' => 'staff_id', 'label' => 'Staff'),
			#array('value' => 'expenses', 'label' => 'Expenses')
		);
		return modules::run('common/field_select', $fields, $field_name, $field_value, $size);
	}

	function status_to_text($status)
	{
		$text = '';
		switch($status)
		{
			case SHIFT_REJECTED: $text = 'rejected';
				break;
			case SHIFT_UNCONFIRMED: $text = 'unconfirmed';
				break;
			case SHIFT_CONFIRMED: $text = 'confirmed';
				break;
			case SHIFT_FINISHED: $text = 'finished';
				break;
		}
		return $text;
	}

	function get_shift_second($shift)
	{
		$s = $shift['finish_time'] - $shift['start_time'];
		$a = json_decode($shift['break_time']);

		if (count($a) > 0)
		{
			foreach($a as $break)
			{
				$s -= $break->length;
			}
		}
		return $s;
	}
	/**
	*	@name: update_shift_time
	*	@desc: Update shift time - this function is mostly used while updating time for multiple shifts
	*	@access: public
	*	@param: ([array]) shift ids, start time or finish time to update, new time
	*	@return: null
	*/
	function update_shift_time($params)
	{
		if(isset($params['shift_ids'])){
			$shift_time_mode = $params['shift_time_mode'];
			foreach($params['shift_ids'] as $shift_id){
				$shift_info = $this->job_shift_model->get_job_shift($shift_id);
				$old_shift_time_date_only = date('Y-m-d',$shift_info[$shift_time_mode]);
				$new_shift_start_or_finish_time = strtotime($old_shift_time_date_only.' '.$params['time_hour'].':'.$params['time_minutes'].':'.'00');
				$this->job_shift_model->update_job_shift($shift_id, array($shift_time_mode => $new_shift_start_or_finish_time));
			}
		}
	}

	/**
	*	@name: toggle_shift_information_sheet_status
	*	@desc: Toggle information sheet from a shift. It is done by changing the information_sheet status to 0 'zero' or 1 'one' in job_shifts table
	*	@access: public
	*	@param: ([array] shift id, information sheet status)
	*	@return: success or failed status
	*/
	function toggle_shift_information_sheet_status($params)
	{
		return $this->job_shift_model->update_job_shift($params['shift_id'],array('information_sheet' => $params['status']));
	}
	/**
	*	@name: get_apply_for_shift_email
	*	@desc: Loads shift details for apply to work email
	*	@access: public
	*	@param: ([array] shift ids)
	*
	*/
	function get_apply_for_shift_email($shift_ids, $user_id = 0)
	{
		$comma_separate_shift_ids = implode(',',$shift_ids);
		if ($user_id) {
			$data = $this->job_shift_model->get_user_job_shifts_by_shift_ids($user_id, $comma_separate_shift_ids);
			if(count($data) <= 0){
				$data = $this->job_shift_model->get_job_shifts_by_shift_ids($comma_separate_shift_ids);	
			}
		} else {
			$data = $this->job_shift_model->get_job_shifts_by_shift_ids($comma_separate_shift_ids);
		}
		$data['shifts'] = $data;
		$this->load->view('shift/email/apply_for_shift_template', isset($data) ? $data : NULL);
	}
	/**
	*	@name: get_shift_info_for_email
	*	@desc: loads shift details for work confirmation and shift reminder email
	*	@access: public
	*	@param: ([int] shift id)
	*
	*/
	function get_shift_info_for_email($shift_id)
	{
		$data['shift'] = $this->job_shift_model->get_job_shift($shift_id);
		$this->load->view('shift/email/shift_info_email_template', isset($data) ? $data : NULL);
	}
	/**
	*	@name: get_shift_reminders_email
	*	@desc: Loads shift details for shift reminder email
	*	@access: public
	*	@param: ([array] shift ids)
	*
	*/
	function get_shift_reminders_email($shift_params)
	{
		$comma_separate_shift_ids = implode(',',$shift_params['shift_ids']);
		$user_id = $shift_params['user_id'];
		$data['shifts'] = $this->job_shift_model->get_user_job_shifts_by_shift_ids($user_id,$comma_separate_shift_ids);
		$this->load->view('shift/email/shift_reminder_email', isset($data) ? $data : NULL);
	}
	/**
	*	@name: email_work_confirmation
	*	@desc: function to email work confirmation to a staff
	*	@access: public
	*	@param: ([via post]) email parameters such as body of email, user id, invoice id
	*
	*/
	function email_work_confirmation($params)
	{
		$shift_id = $params['shift_id'];

		$shift = $this->job_shift_model->get_job_shift($shift_id);
		if ($shift['status'] == SHIFT_CONFIRMED)
		{
			$user_id = $shift['staff_id']; #$user_id = $params['user_id'];
			$email_template_id = WORK_CONFIRMATION_EMAIL_TEMPLATE_ID;

			if($user_id && $shift_id){

				$this->load->model('user/user_model');
				$this->load->model('setting/setting_model');
				$this->load->model('email/email_template_model');
				  //get user
				  $user = $this->user_model->get_user($user_id);
				  //get template info
				  $template_info = $this->email_template_model->get_template($email_template_id);
				  $company = $this->setting_model->get_profile();
				  //get receiver object
				  $email_obj_params = array(
										  'template_id' => $template_info->email_template_id,
										  'user_id' => $user_id,
										  'company' => $company,
										  'shift_id' => $shift_id
									  );
				  $obj = modules::run('email/get_email_obj',$email_obj_params);
				  $email_data = array(
									  'to' => $user['email_address'],
									  'from' => $company['email_c_email'],
									  'from_text' => $company['email_c_name'],
									  'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
									  'message' => modules::run('email/format_template_body',$template_info->template_content,$obj)
								  );
				  modules::run('email/send_email',$email_data);

			}
			echo 'sent';
		}
	}
}
