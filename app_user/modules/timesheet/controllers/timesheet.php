<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Timesheet
 *	@controller: Timesheet
 */

class Timesheet extends MX_Controller {
	
	var $user = null;

	function __construct() {
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('job/job_shift_model');
		$this->load->model('attribute/payrate_model');
		$this->load->model('expense/expense_model');
		$this->user = $this->session->userdata('user_data');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'generate':
					$this->generate();
				break;
			/*case 'email_timesheet':
					$this->email_timesheet();
				break;*/
			case 'test':
					$this->test();
				break;
			default:
					$this->main_view();
				break;
		}
		
	}
	
	/**
	*	@name: main_view
	*	@desc: load main view of timesheet module (landing page)
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of the timesheet module landing page
	*/
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_form
	*	@desc: load search timesheets form view
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of search timesheets form
	*/
	function search_form() {
		$this->load->view('search_form_view', isset($data) ? $data : NULL);
	}
	
	function get_timesheet($timesheet_id) {
		return $this->timesheet_model->get_timesheet($timesheet_id);
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: load row view (tr) of one timesheet
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) tr view of one timesheet
	*/
	function row_timesheet($timesheet_id) {
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['client'] = modules::run('client/get_client', $timesheet['client_id']);
		$data['staff'] = modules::run('staff/get_staff', $timesheet['staff_id']);
		$data['timesheet'] = $timesheet;
		$data['shift'] = $this->job_shift_model->get_job_shift($timesheet['shift_id']);
		$data['job'] = modules::run('job/get_job', $timesheet['job_id']);
		
		# get top parent
		$data['top_parent_id'] = $this->get_top_parent($timesheet_id);
		
		$total_expenses = 0;
		$expenses = unserialize($timesheet['expenses']);
		if (is_array($expenses)) {
			foreach($expenses as $e) {
				$staff_cost = $e['staff_cost'];
				if ($e['tax'] == GST_ADD) {
					$staff_cost *= 1.1;
				}
				$total_expenses += $staff_cost;
			}
		}
		
		$paid_expenses = $this->expense_model->get_timesheet_expenses($timesheet_id);
		
		foreach($paid_expenses as $e) {
			$staff_cost = $e['staff_cost'];
			if ($e['tax'] == GST_ADD) {
				$staff_cost *= 1.1;
			}
			$total_expenses += $staff_cost;
		}
		
		$data['total_expenses'] = $total_expenses;
		
		$this->load->view('row_view', isset($data) ? $data : NULL);
	}
	
	function get_top_parent($timesheet_id)
	{
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		# get top parent
		$parent_ts_id = $timesheet_id;
		if($timesheet['parent_timesheet_id']){
			$has_parent = true;
			$parent_ts_id = $timesheet['parent_timesheet_id'];
			while($has_parent){
				$parent_ts = $this->timesheet_model->get_timesheet($parent_ts_id);
				# check if this has another child 	
				if($parent_ts['parent_timesheet_id']){
					$parent_ts_id = $parent_ts['parent_timesheet_id'];
				}else{
					$has_parent = false;	
				}
			}
		}
		return $parent_ts_id;	
	}
	
	
	# $user_type = 0: staff, 1: client
	function extract_timesheet_payrate($timesheet_id, $user_type = 0) {
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$payrate_id = $timesheet['payrate_id'];
		$client_payrate_id = $payrate_id;
		if ($timesheet['client_payrate_id'] > 0)
		{
			$client_payrate_id = $timesheet['client_payrate_id'];
		}
		$start_time = $timesheet['start_time'];
		$finish_time = $timesheet['finish_time'];
		$pay_rates = array();
		
		$current_rate = null;
		$payrate = $this->payrate_model->get_payrate($payrate_id);
		$client_payrate = $this->payrate_model->get_payrate($client_payrate_id);
		$current_group = $payrate['name'];
		$current_activity = $client_payrate['name'];
		$current_start = null;
		$current_hours = 0;
		for($i = $start_time; $i < $finish_time; $i = $i + 60*15) { # Every 15 minutes
			$day = date('N', $i); # Get day of the week (1: monday - 7: sunday)
			$hour = date('G', $i); # Get hour of the day (0 - 23)
			# Get the pay rate amount
			#$rate = $this->payrate_model->get_payrate_data($payrate_id, $user_type, $day, $hour);
			$rate = $this->payrate_model->get_payrate_full_data($payrate_id, $user_type, $day, $hour);
			$client_rate = $this->payrate_model->get_payrate_full_data($client_payrate_id, 1, $day, $hour);
			if ($current_rate == null) { # First rate
				#$current_rate = $rate;
				$current_rate = $rate['value'];
				$current_group = $rate['group'];
				$current_activity = $client_rate['group'];
				$current_start = $start_time;
			}
			if ($rate['value'] == $current_rate) { # The same rate
				$current_hours += 0.25;
			}			
			if ($rate['value'] != $current_rate) { # There is new rate
				# First store current rate
				$pay_rates[] = array(
					'start' => $current_start,
					'finish' => $current_start + $current_hours * 3600,
					'hours' => $current_hours,
					'rate' => $current_rate,
					'break' => 0,
					'group' => $rate['group'],
					'activity' => $client_rate['group']
				);
				
				# Then clear to set up new rate
				$current_rate = $rate['value'];
				$current_start = $i;
				$current_hours = 0.25;				
			}			
		}
		# Last pay rate
		$pay_rates[] = array(
			'start' => $current_start,
			'finish' => $current_start + $current_hours * 3600,
			'hours' => $current_hours,
			'rate' => $current_rate,
			'break' => 0,
			'group' => $current_group,
			'activity' => $current_group
		);
		
		
		$breaks = json_decode($timesheet['break_time']);
		if (count($breaks) > 0) {
			$final = array();
			foreach($pay_rates as $pay_rate) {
				foreach($breaks as $break) {
					$length = $break->length;
					$start_at = $break->start_at;
					$finish_at = $start_at + $length;
					if ($pay_rate['start'] <= $start_at && $pay_rate['finish'] >= $finish_at) {
						$pay_rate['break'] = $length;
					}
					if ($pay_rate['start'] <= $start_at && $pay_rate['finish'] > $start_at && $pay_rate['finish'] < $finish_at) {
						$pay_rate['break'] = $pay_rate['finish'] - $start_at;
					}
					if ($pay_rate['start'] > $start_at && $pay_rate['start'] < $finish_at && $pay_rate['finish'] > $finish_at) {
						$pay_rate['break'] = $finish_at - $pay_rate['start'];	
					}
				}
				$pay_rate['hours'] = $pay_rate['hours'] - $pay_rate['break'] / 3600;
				$final[] = $pay_rate;
			}
			$pay_rates = $final;
		}
		return $pay_rates;
	}
	
	/**
	*	@name: update_timesheet_hour_rate
	*	@desc: calculate and update client/staff cost of a timesheet based on hours & pay rate
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (boolean)
	*/
	function update_timesheet_hour_rate($timesheet_id) {
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$payrate_id = $timesheet['payrate_id'];
		$client_payrate_id = $payrate_id;
		if ($this->config_model->get('separate_client_payrate') && $timesheet['client_payrate_id'])
		{
			$client_payrate_id = $timesheet['client_payrate_id'];
		}
		$start_time = $timesheet['start_time'];
		$finish_time = $timesheet['finish_time'];
		$total_mins = 0;
		$total_amount_staff = 0;
		$total_amount_client = 0;
		for($i=$start_time; $i < $finish_time; $i = $i + 60*15) { # Every 15 minutes
			$day = date('N', $i); # Get day of the week (1: for monday, 7 for sunday)
			$hour = date('G', $i); # Get hour of the day (0 - 23)
			
			# Amount paid calculated by 15 minute
			
			$total_amount_staff += $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
			$total_amount_client += $this->payrate_model->get_payrate_data($client_payrate_id, 1, $day, $hour)/4;
			$total_mins = $total_mins + 15;
		}
		
		# Deduct the break
		
		$breaks = json_decode($timesheet['break_time']);
		if (count($breaks) > 0) {
			foreach($breaks as $break)
			{
				$length = $break->length;
				$start_at = $break->start_at;
				for($i=$start_at; $i < $start_at + $length; $i = $i + 60*15) { # Every 15 minute
					$day = date('N', $i);
					$hour = date('G', $i);
					$total_amount_staff -= $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
					$total_amount_client -= $this->payrate_model->get_payrate_data($client_payrate_id, 1, $day, $hour)/4;
					$total_mins = $total_mins - 15;
				}
			}
		}
		
		# Update expenses cost
		
		$expenses = unserialize($timesheet['expenses']);
		if (count($expenses) > 0) {
			foreach($expenses as $exp) {
				$exp['job_id'] = $timesheet['job_id'];
				$exp['timesheet_id'] = $timesheet['timesheet_id'];
				$exp['staff_id'] = $timesheet['staff_id'];
				$exp['client_id'] = $timesheet['client_id'];		
				$this->expense_model->add_expense($exp);				
			}
		}
		$expenses_staff_cost = $this->calculate_expenses($timesheet_id, 'staff');
		$expenses_client_cost = $this->calculate_expenses($timesheet_id, 'client');
		
		return $this->timesheet_model->update_timesheet($timesheet_id, array(
			'expenses_staff_cost' => $expenses_staff_cost,
			'expenses_client_cost' => $expenses_client_cost,
			'total_minutes' => $total_mins,
			'total_amount_staff' => $total_amount_staff,
			'total_amount_client' => $total_amount_client
		));
		
	}
	
	/**
	*	@name: field_select_status
	*	@desc: custom field select timesheet status
	*	@access: public
	*	@param: $field_name, $field_value (optional), $size (optional)
	*	@return: (html) custom field select
	*/
	function field_select_status($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => TIMESHEET_PENDING, 'label' => 'Pending'),
			array('value' => TIMESHEET_SUBMITTED, 'label' => 'Submitted'),
			array('value' => TIMESHEET_APPROVED, 'label' => 'Approved')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: menu_dropdown_actions
	*	@desc: generate the dropdown menu of actions applied to timesheets
	*	@access: public
	*	@param: $id, $label
	*	@return: (html) dropdown menu of actions applied to timesheets
	*/
	function menu_dropdown_actions($id, $label) {
		$data = array(
			array('value' => 'batch', 'label' => '<i class="fa fa-share-square-o"></i> Batch Selected'),
			#array('value' => 'revert', 'label' => '<i class="fa fa-times"></i> Delete Selected')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	/**
	*	@name: status_to_class
	*	@desc: convert timesheet status to css class
	*	@access: public
	*	@param: $status
	*	@return: class_name
	*/
	function status_to_class($status,$timesheet_id = '') {
		$class = '';
		if($timesheet_id){
			$timesheet = $this->get_timesheet($timesheet_id);
			if($timesheet['reject_note'] != '' && $timesheet['status'] == TIMESHEET_PENDING){
				return 'danger';	
			}
		}
		switch($status) {
			case TIMESHEET_SUBMITTED: $class = 'warning';
				break;
			case TIMESHEET_APPROVED: $class = 'success';
				break;
			case SHIFT_UNASSIGNED:
			default: $class = '';
				break;
		}
		return $class;
	}
	
	/**
	*	@name: add_expense_form
	*	@desc: load add expense form view
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) add expense form view
	*/
	function add_expense_form($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('edit/expense/add_form', isset($data) ? $data : NULL);
	}
	
	function generate() 
	{
		
		$this->load->model('staff/staff_model');
		$shifts = $this->timesheet_model->get_finished_shifts();
		foreach($shifts as $shift)
		{
			$this->job_shift_model->update_job_shift($shift['shift_id'], array('status' => SHIFT_FINISHED));
			# Update user_staffs table field - last_worked_date
			$data_user_staff = array('last_worked_date' => $shift['job_date'].' 00:00:00');
			$this->staff_model->update_staff($shift['staff_id'],$data_user_staff);
			
			unset($shift['status']);
			unset($shift['created_on']);
			unset($shift['modified_on']);
			unset($shift['payrate_type']);			
			unset($shift['is_alert']);			
			unset($shift['information_sheet']);
			$job = modules::run('job/get_job', $shift['job_id']);
			$shift['client_id'] = $job['client_id'];
			$timesheet_id = $this->timesheet_model->insert_timesheet($shift);
			#$this->update_timesheet_hour_rate($timesheet_id);
		}
		#redirect('timesheet');
	}
	
	/**
	*	@name: calculate_expenses
	*	@desc: calculate total expenses of a timesheet
	*	@access: public
	*	@param: $timesheet_id
	*	@return: $total_expenses
	*/
	function calculate_expenses($timesheet_id, $type='staff') 
	{
		if ($type != 'staff' && $type != 'client') { return 0; }
		$type .= '_cost';
		$total_expenses = 0;
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		
		# If timesheet is not batched yet, include expenses in timesheet table
		$expenses = unserialize($timesheet['expenses']);
		if (is_array($expenses) && $timesheet['status'] < TIMESHEET_BATCHED) {
			foreach($expenses as $e) {
				$cost = $e[$type];
				if ($e['tax'] == GST_ADD) {
					$cost *= 1.1;
				}
				$total_expenses += $cost;
			}
		}
		# If timesheet is not batched yet, only get expenses already paid expenses in expenses table
		$status = EXPENSE_UNPAID;
		if ($timesheet['status'] < TIMESHEET_BATCHED) {
			$status = EXPENSE_PAID;
		}
		$paid_expenses = $this->expense_model->get_timesheet_expenses($timesheet_id, $status);
		foreach($paid_expenses as $e) {
			$cost = $e[$type];
			if ($e['tax'] == GST_ADD) {
				$cost *= 1.1;
			}
			$total_expenses += $cost;
		}
		return $total_expenses;
	}
	
	/**
	*   @name: get_ungenerated_timesheet_count
	*	@desc: Calculates the number of new timesheets to be generated
	*/
	function get_ungenerated_timesheet_count()
	{
		$shifts = $this->timesheet_model->get_finished_shifts();	
		return count($shifts);
	}
	
	# Email timesheet for approval
	function email_timesheet()
	{
		# generate timesheet key
		$this->_generate_timesheet_key();

		# if configured to send timesheet to all staff 
		if($this->config_model->get('ts_email_staff')){
			$this->_send_email_timesheet(TIMESHEET_STAFF_KEY_TYPE);	
		}
		
		# if configured to send timesheet to supervisor
		if($this->config_model->get('ts_email_supervisor')){
			$this->_send_email_timesheet(TIMESHEET_SUPERVISOR_KEY_TYPE);		
		}
		
		# mark this record as email sent
		# this is run at the end because if both the staff and supervisor is configured to get the timesheet they might miss some records as only one field is used to track email sent status 
		#if($this->config_model->get('ts_email_staff')){
			$timesheets = $this->timesheet_model->get_timesheet_for_email(TIMESHEET_STAFF_KEY_TYPE);
			foreach($timesheets as $ts){
				$this->timesheet_model->mark_record_as_email_sent(TIMESHEET_STAFF_KEY_TYPE,$ts['staff_key']);
			}
		
		#}
		#if($this->config_model->get('ts_email_supervisor')){
			$timesheets = $this->timesheet_model->get_timesheet_for_email(TIMESHEET_SUPERVISOR_KEY_TYPE);
			foreach($timesheets as $ts){
				$this->timesheet_model->mark_record_as_email_sent(TIMESHEET_SUPERVISOR_KEY_TYPE,$ts['supervisor_key']);
			}
		#}
	}
	
	function _send_email_timesheet($key_type)
	{
		/**
			Since the email only contains an encrypted key - and a link
			The idea here to get as little data from db to optimize performance.
			We do this by grouping the data by key as all the records for a staff or a supervisor has same key 
				for the given number of generated timesheet at any given time - see the function 'get_timesheet_for_email()' in timesheet_model.php for sql
		*/
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		
		//get company profile
		$company = $this->setting_model->get_profile();	
		$template_info = $this->email_template_model->get_template(TIMESHEET_EMAIL_TEMPLATE_ID);
		$email_body = $template_info->template_content;
		$timesheets = $this->timesheet_model->get_timesheet_for_email($key_type);	
		#echo '<pre>'.print_r($timesheets,true).'</pre>';die();
		foreach($timesheets as $ts){
			$user_id = $key_type == TIMESHEET_SUPERVISOR_KEY_TYPE ? $ts['supervisor_id'] : $ts['staff_id'];
			$user = modules::run('user/get_user',$user_id);
			//get receiver obj
			$key = $key_type == TIMESHEET_SUPERVISOR_KEY_TYPE ? $ts['supervisor_key'] : $ts['staff_key'];
			$email_obj_params = array(
							'template_id' => TIMESHEET_EMAIL_TEMPLATE_ID,
							'user_id' => $user_id,
							'company' => $company,
							'timesheet_key_type' => $key_type,
							'timesheet_key' => $key
						);
			$obj = modules::run('email/get_email_obj',$email_obj_params);	
			$email_data = array(
									'to' => $user['email_address'],
									'from' => $template_info->email_from,
									'from_text' => $company['email_c_name'],
									'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
									'message' => modules::run('email/format_template_body',$email_body,$obj)
								);
	
			modules::run('email/send_email',$email_data);
		}
	}
	
	function get_timesheet_email($key_type,$key)
	{
		#$key_type = TIMESHEET_SUPERVISOR_KEY_TYPE;
		#$key = '4e919c0c109d3de1b0da400c08d1748a';
		
		
		$total_timesheets = $this->timesheet_model->get_timesheet_by_key($key_type,$key);
		# the last param is to group by staff
		$total_staff = $this->timesheet_model->get_timesheet_by_key($key_type,$key,true);
		$data['total_ts'] = count($total_timesheets);
		$data['total_staff'] = count($total_staff);
		$data['url'] = base_url().'pts/ls_ts/' . $key_type . '/' . $key;
		return $this->load->view('email/email_template', isset($data) ? $data : NULL, true);
	}
	
	
	# generate timesheet key
	function _generate_timesheet_key()
	{
		# the generated key will be different each time and won't affect previous records 
		# this is because it only affects records that has not been approved for payrun and records that as not been marked as email sent
		
		# IMPORTANT - Please note that this function is to be called in conjustion of _send_email_timesheet() as this function tags the record as email sent
		
		$timesheets = $this->timesheet_model->get_timesheet_for_email();
		$time = time();
				
		# insert supervisor key
		foreach($timesheets as $ts){
			  # flush supervisor key to prevent previous value being added to the records
			  $data['supervisor_key'] = '';
			  if($ts['supervisor_id']){
			  	$data['supervisor_key'] = md5($time . SUPERVISOR_TIMESHEET_SALT . $ts['supervisor_id']);
			  }
			  $data['staff_key'] = md5($time . STAFF_TIMESHEET_SALT . $ts['staff_id']);
			  $this->timesheet_model->update_timesheet($ts['timesheet_id'], $data);
		}	
	}
	
	function test()
	{
		$payrates = $this->extract_timesheet_payrate(33, $user_type = 0);	
		echo count($payrates);
		echo '<pre>' . print_r($payrates,true) . '</pre>';
	}
	
	function __test()
	{
		$key_type = TIMESHEET_SUPERVISOR_KEY_TYPE;
		$key = 'd85d8af65ae09072ff38797b5028a060';
		
		
		$total_timesheets = $this->timesheet_model->get_timesheet_by_key($key_type,$key);
		# the last param is to group by staff
		$total_staff = $this->timesheet_model->get_timesheet_by_key($key_type,$key,true);
		$data['total_ts'] = count($total_timesheets);
		$data['total_staff'] = count($total_staff);
		$data['url'] = base_url().'pts/ls_ts/' . $key_type . '/' . $key;
		echo $this->load->view('email/email_template', isset($data) ? $data : NULL, true);
	}
}