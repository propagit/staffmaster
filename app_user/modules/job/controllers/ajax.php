<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: job
 *	@controller: ajax
 */

class Ajax extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}
	
	/** 
	*	@name: search_jobs
	*	@desc: ajax function to search job(s)
	*	@access: public
	*	@param: an array of search parameters (POST)
	*	@return: view of list of jobs
	*/
	function search_jobs()
	{
		$data = $this->input->post();
		if (modules::run('auth/is_client'))
		{
			$data['client_id'] = $this->user['user_id'];
		}
		$data['jobs'] = $this->job_model->search_jobs($data);
		$this->load->view('jobs_search_results_view', isset($data) ? $data : NULL);
	}
	
	function delete_job()
	{
		$job_id = $this->input->post('job_id');
		# Delete all shift in that job
		$this->job_shift_model->delete_job_shifts($job_id);
		# Delete all timesheet in that job
		
		# Delete job
		$this->job_model->delete_job($job_id);
	}
	
	function search_shifts()
	{
		$data = $this->input->post();
		if (modules::run('auth/is_client'))
		{
			$data['client_id'] = $this->user['user_id'];
		}
		$data['shifts'] = $this->job_shift_model->search_shifts($data,
						$this->session->userdata('shifts_sort_key'),
						$this->session->userdata('shifts_sort_value'));
		$this->load->view('shifts_search_results_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: create_shifts
	*	@desc: ajax function to create shift(s) for a job
	*	@access: public
	*	@param: an array of shift parameters (POST)
	*	@return: json encode of result
	*			- failed: {ok: false, error_id: (string)}
	*			- success: {ok: true, job_date: (string) YYYY-DD-MM
	*/
	function create_shifts()
	{
		$data = $this->input->post();
		$filter_data = array();
		$filter_data['job_id'] = $data['job_id'];
		
		$filter_data['job_date'] = date('Y-m-d', strtotime($data['job_date']));
		
		if (strtotime($data['job_date']) <= now() && false)
		{
			# Job start date can not be in the past
			echo json_encode(array('ok' => false, 'error_id' => 'start_date'));
			return;
		}	
		
		$filter_data['start_time'] = strtotime($data['job_date']);		
		$filter_data['finish_time'] = strtotime($data['finish_time']);
				
		
		if ($filter_data['finish_time'] <= $filter_data['start_time'])
		{
			# Finish time can not be less than start time
			echo json_encode(array('ok' => false, 'error_id' => 'finish_time'));
			return;
		}
		
		if ($data['break_length'] > 0)
		{
			$break_time = array(
				'length' => $data['break_length'] * 60, # seconds
				'start_at' => strtotime($data['break_start_at'])
			);
			
			if ($break_time['start_at'] <= $filter_data['start_time'] || $break_time['start_at'] >= $filter_data['finish_time'])
			{
				echo json_encode(array('ok' => false, 'error_id' => 'break_start_at'));
				return;
			}
			$breaks = array();
			$breaks[] = $break_time;
			$filter_data['break_time'] = json_encode($breaks);
		}
		
		
		
		$filter_data['role_id'] = $data['role_id'];
		$filter_data['venue_id'] = $data['venue_id'];
		$filter_data['uniform_id'] = $data['uniform_id'];
		
		if ($this->is_client)
		{
			$filter_data['is_alert'] = 1;
		}
		else
		{
			if ($data['payrate_id'] == '')
			{
				echo json_encode(array('ok' => false, 'error_id' => 'payrate_id'));
				return;
			}
			$filter_data['payrate_id'] = $data['payrate_id'];
			$filter_data['supervisor_id'] = $data['supervisor_id'];
		}
		
		$count = (int) $data['count'];
		if ($count < 1 || $count > 1000)
		{
			echo json_encode(array('ok' => false, 'error_id' => 'count'));
			return;
		}
		else if (!$this->is_client)
		{
			if ($count > modules::run('account/get_credits'))
			{
				echo json_encode(array('ok' => false, 'error_id' => 'count'));
				return;
			}
		}
		
		for($i=0; $i < $count; $i++)
		{
			$this->job_shift_model->insert_job_shift($filter_data);
		}

		# Take the credits out
		$this->load->model('account/account_model');
		$this->account_model->deduct_credits($count);
	
		echo json_encode(array('ok' => true, 'job_date' => $filter_data['job_date']));
	}
	
	/**
	*	@name: sort_shifts
	*	@desc: ajax function to set sort key & value when getting shifts
	*	@access: public
	*	@param: (POST) 'key'
	*	@return: (void)
	*/
	function sort_shifts()
	{
		$key = $this->input->post('key');
		$shifts_sort_value = 'asc';
		$shifts_sort_key = $this->session->userdata('shifts_sort_key');
		if ($shifts_sort_key == $key)
		{
			# Change sort value
			$shifts_sort_value = $this->session->userdata('shifts_sort_value');
			if ($shifts_sort_value == 'asc')
			{
				$shifts_sort_value = 'desc';
			} else
			{
				$shifts_sort_value = 'asc';
			}
		}
		else
		{
			# Init sort key & value
			$shifts_sort_key = $key;
		}
		$this->session->set_userdata('shifts_sort_key', $shifts_sort_key);
		$this->session->set_userdata('shifts_sort_value', $shifts_sort_value);
	}
	
	function load_more_day_shifts()
	{
		$group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		# throw HTTP error if group number is not valid
		if(!is_numeric($group_number)){
		    header('HTTP/1.1 500 Invalid number!');
		    exit();
		}
		
		# get current starting point of records
		$position = ($group_number * SHIFTS_PER_LOAD);
		$job_id = $this->input->post('job_id');
		$date = $this->input->post('date');
		$job_shifts = $this->job_shift_model->get_job_shifts($job_id, $date,
						$this->session->userdata('shift_status_filter'),
						$this->session->userdata('shifts_sort_key'),
						$this->session->userdata('shifts_sort_value'), $position);
		foreach($job_shifts as $shift)
		{
			echo modules::run('job/shift/row_view', $shift['shift_id']);
		}			
	}
	
	/**
	*	@name: load_day_shifts
	*	@desc: ajax function to load list view of shifts by day
	*	@access: public
	*	@param: (POST) (int) job_id, (string: YYYY-MM-DD) job_date
	*	@return: list view (table) of shifts
	*/
	function load_day_shifts()
	{
		$job_id = $this->input->post('job_id');
		# Get all dates of the job
		$job_dates = $this->job_shift_model->get_job_dates($job_id);
		
		# Get selected date from POST request first
		$date = $this->input->post('date');
		
		# Then check the session
		if (!$date)
		{
			$date = $this->session->userdata('job_date');
		}
		
		# Otherwise, get the very next day
		if (!$date) {
			foreach($job_dates as $job_date)
			{
				if (strtotime($job_date['job_date']) >= strtotime(date('Y-m-d', now())))
				{
					$date = $job_date['job_date'];
					break;
				}
			}
		}
		
		$this->session->set_userdata('job_date', $date);
		
		$data['total_date'] = count($job_dates);
		
		# Get previous and next days
		$key = 0;
		foreach($job_dates as $index => $value)
		{
			if ($value['job_date'] == $date)
			{
				$key = $index;
			}
		}		
		if ($key == 0) {
			$right_index = 2;
			$left_index = 0;
		} else if ($key == count($job_dates) - 1) {
			$right_index = $key;
			$left_index = $key - 2;
		} else {
			$right_index = $key + 1;
			$left_index = $key - 1;
		}
		
		# Optimized job dates array
		$op_job_dates = array();
		foreach($job_dates as $index => $value)
		{
			if ($index >= $left_index && $index <= $right_index)
			{
				$op_job_dates[] = $value;
			}
		}
		
		$data['job_id'] = $job_id;
		$data['job_dates'] = $op_job_dates;
		$data['job_shifts'] = $this->job_shift_model->get_job_shifts($job_id, $date,
						$this->session->userdata('shift_status_filter'),
						$this->session->userdata('shifts_sort_key'),
						$this->session->userdata('shifts_sort_value'));
		$data['total_shifts'] = $this->job_shift_model->count_job_shifts($job_id, $date,
						$this->session->userdata('shift_status_filter'));
						
		$data['is_client'] = $this->is_client;
		$this->load->view('shifts_day_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: load_month_view
	*	@desc: ajax function to set calendar_view to month
	*	@access: public
	*	@param: (POST) (int) 'date' timestamp
	*	@return: (string) YYYY-MM-DD
	*/
	function load_month_view()
	{
		$this->session->set_userdata('calendar_view', 'month');
		echo date('Y-m-d', $this->input->post('date'));
	}
	
	/**
	*	@name: load_week_view
	*	@desc: ajax function to set calendar_view to week
	*	@access: public
	*	@param: (POST) (int) 'date' timestamp
	*	@return: (string) YYYY-MM-DD
	*/
	function load_week_view()
	{
		$this->session->set_userdata('calendar_view', 'week');
		echo date('Y-m-d', $this->input->post('date'));
	}
	
	/**
	*	@name: load_job_calendar
	*	@desc: ajax function to load calendar view (month/week) of shifts
	*	@access: public
	*	@param: (POST) (int) 'job_id'
	*	@return: (view) calendar view
	*/
	function load_job_calendar()
	{
		$job_id = $this->input->post('job_id');
		$job_dates = $this->job_shift_model->get_job_dates($job_id);
		$data['custom_date'] = now();
		if ($job_dates)
		{
			$data['custom_date'] = strtotime($job_dates[0]['job_date']);
		}
		if ($this->input->post('date'))
		{
			$data['custom_date'] = strtotime($this->input->post('date'));
		}
		if ($data['custom_date'] < now())
		{
			$data['custom_date'] = now();
		}
		$data['job_id'] = $job_id;
		$data['is_client'] = $this->is_client;
		if (!$this->session->userdata('calendar_view') || $this->session->userdata('calendar_view') == 'week') 
		{
			$this->load->view('shifts_week_view', isset($data) ? $data : NULL);	
		} 
		else if ($this->session->userdata('calendar_view') == 'month') 
		{
			$out = array();
			foreach($job_dates as $date)
			{
				
				#$unassign = modules::run('job/count_job_shifts', $job_id, $date['job_date'], '0');
				#$completed = modules::run('job/count_job_shifts', $job_id, $date['job_date'], SHIFT_FINISHED); 


				$out[] = array(
					'unassigned' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date'], '0'),
					'unconfirmed' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date'], SHIFT_UNCONFIRMED),
					'rejected' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date'], SHIFT_REJECTED),
					'confirmed' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date'], SHIFT_CONFIRMED),
					'completed' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date'], SHIFT_FINISHED),
					'title' => $job_id,
					'url' => $date['job_date'],
					'start' => strtotime($date['job_date']) . '000',
					'end' => strtotime($date['job_date']) . '000',
				);
			}
			$data['events_source'] = json_encode($out);
			$this->load->view('shifts_month_view', isset($data) ? $data : NULL);
		}
	}
	
	function load_job_week()
	{
		$date = $this->input->post('date');
		$date += (int) $this->input->post('step') * 7*24*60*60;
		echo date('Y-m-d', $date);	
	}
	
	function unlock_shift()
	{
		$shift_id = $this->input->post('pk');
		$this->load->model('timesheet/timesheet_model');
		# First delete the timesheet
		$this->timesheet_model->delete_shift_timesheet($shift_id);
		# Then update shift status
		$this->job_shift_model->update_job_shift($shift_id, array('status' => SHIFT_CONFIRMED));
		echo modules::run('job/shift/row_view', $shift_id);
	}
	
	function update_shift_venue()
	{
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('venue_id' => $this->input->post('value')));
	}
	function update_shift_role()
	{
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('role_id' => $this->input->post('value')));	
	}
	
	function update_shift_uniform() {
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('uniform_id' => $this->input->post('value')));	
	}
	
	
	function update_shift_supervisor() {
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('supervisor_id' => $this->input->post('value')));
	}
	
	function update_shift_payrate()
	{
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('payrate_id' => $this->input->post('value')));
	}
	
	function update_shift_start_time()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$new_start_time = strtotime($this->input->post('value') . ':00');
		if ($new_start_time >= $shift['finish_time'])
		{
			$this->output->set_status_header('400');
			echo 'Start time cannot be greater than finish time';
		}
		else
		{
			$this->job_shift_model->update_job_shift($shift_id, array('start_time' => $new_start_time));
			echo json_encode(array('status' => 'success', 'value' => $new_start_time));
		}
	}
	function update_shift_finish_time()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$new_finish_time = strtotime($this->input->post('value') . ':00');
		if ($new_finish_time <= $shift['start_time'])
		{
			$this->output->set_status_header('400');
			echo 'Finish time cannot be less than start time';
		}
		else
		{
			$this->job_shift_model->update_job_shift($shift_id, array('finish_time' => $new_finish_time));
			echo json_encode(array('status' => 'success', 'value' => $new_finish_time));
		}
	}
	
	/**
	*	@name: load_shift_staff
	*	@desc: ajax function to load view of assign staff to a shift
	*	@access: public
	*	@param: (via POST) pk: (int) id of the shift
	*	@return: (view) form to assign staff to the shift
	*/
	function load_shift_staff()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['staff'] = modules::run('staff/get_staff', $shift['staff_id']);
		$data['shift'] = $shift;
		$this->load->view('shift_staff', isset($data) ? $data : NULL);
	}
	
	function load_shift_supervisor()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['supervisor'] = modules::run('staff/get_staff', $shift['supervisor_id']);
		$data['shift'] = $shift;
		$this->load->view('shift_supervisor', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_staff_for_shift
	*	@desc: ajax function to search staffs for a shift
	*	@access: public
	*	@param: (via POST) query: (string) keyword for staff name
	*	@return: (view) of list of searched staffs
	*/
	function search_staff_for_shift()
	{
		$query = $this->input->post('query');
		$this->load->model('staff/staff_model');
		$data['staffs'] = $this->staff_model->search_staffs(array('keyword' => $query, 'limit' => 6));
		$this->load->view('staffs_for_shift', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_shift_staff
	*	@desc: ajax function to update staff assign / status to the shift
	*	@access: public
	*	@param: (via POST)
	*			- shift_id
	*			- shift_staff_id: (int) id of staff
	*			- status: (int) 1 assigned / 2 confirmed / 3 rejected
	*			- shift_staff: (string) staff first name and last name
	*	@return: json encode
	*/
	function update_shift_staff()
	{
		$data = $this->input->post();
		$update_shift_data = array();
		if ($data['shift_staff'])
		{
			$staff = modules::run('staff/get_staff', $data['shift_staff_id']);
			
			if ($staff)
			{
				$update_shift_data = array(
					'staff_id' => $data['shift_staff_id'],
					'status' => $data['status']
				);
			}
			else {
				echo json_encode(array('ok' => false, 'msg' => 'Staff not found'));
				return;
			}
		}
		else {
			$update_shift_data = array(
				'staff_id' => 0,
				'status' => 0
			);
		}
		
		echo json_encode(array(
			'ok' => true, 
			'shift_id' => $data['shift_id'], 
			'value' => ($data['shift_staff']) ? $data['shift_staff'] : 'No Staff Assigned',
			'class_name' => modules::run('job/status_to_class', $update_shift_data['status'])
		));
	}
		
	/**
	*	@name: load_shift_breaks
	*	@desc: ajax function to load all breaks of the shift
	*	@access: public
	*	@param: (int) shift_id, via POST
	*	@return: (view) form with shift break information filled in
	*/
	function load_shift_breaks()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['breaks'] = json_decode($shift['break_time']);
		$data['shift_id'] = $shift_id;
		$data['shift'] = $shift;
		$this->load->view('shift_breaks', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_shift_break
	*	@desc: ajax function to load form view to add new break to the shift
	*	@access: public
	*	@param: (int) shift_id, via POST
	*	@return: (view) form to enter new break for the shift
	*/
	function add_shift_break()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['shift'] = $shift;
		$this->load->view('shift_add_break', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_job_shift_breaks
	*	@desc: ajax function to update breaks of the shift
	*	@access: public
	*	@param: two arrays of breaks length and start time (via POST)
	*	@return: json encode - if successful {ok: true, shift_id: (int), minutes: int}
	*						 - if failed	{ok: false, number: error_number}
	*/
	function update_job_shift_breaks()
	{
		$length = $this->input->post('break_length');
		$start_at = $this->input->post('break_start_at');
		$job_shift = $this->job_shift_model->get_job_shift($this->input->post('shift_id'));
		
		$breaks = array();
		$total = 0;
		foreach($length as $index => $value)
		{
			if ($value > 0)
			{
				$break_time = array(
					'length' => $value * 60,
					'start_at' => strtotime($start_at[$index])
				);
				
				if ($break_time['start_at'] <= $job_shift['start_time'] || $break_time['start_at'] >=$job_shift['finish_time'])
				{
					echo json_encode(array('ok' => false, 'number' => $index));
					return;
				}
				$total += $value;
				$breaks[] = $break_time;
			}
		}
		
		if ($this->job_shift_model->update_job_shift($job_shift['shift_id'], array('break_time' => json_encode($breaks))))
		{
			if ($total > 0) {				
				$minutes = $total . ' mins';
				echo json_encode(array('ok' => true, 'shift_id' => $job_shift['shift_id'],'minutes' => $minutes));
			}
			else
			{
				echo json_encode(array('ok' => true, 'shift_id' => $job_shift['shift_id'],'minutes' => 0));
			}
		}
	}
		
	/** 
	*	@name: delete_shifts
	*	@desc: ajax function to delete shift(s)
	*	@access: public
	*	@param: an array of integers (via POST), which are primary keys of shifts
	*	@return: json encode {job_id: (int) $job_id, job_date: (YYYY-MM-DD) $job_date}  
	*/
	function delete_shifts()
	{
		$shifts = $this->input->post('shifts');
		$shift = null;
		$result = array();
		foreach($shifts as $shift_id)
		{
			$shift = $this->job_shift_model->get_job_shift($shift_id);
			$this->job_shift_model->delete_job_shift($shift_id);
		}
		if ($shift)
		{
			$result['job_id'] = $shift['job_id'];
			if (modules::run('job/count_job_shifts', $shift['job_id'], strtotime($shift['job_date'])) > 0)
			{
				$result['job_date'] = $shift['job_date'];
			}
		}		
		echo json_encode($result);
	}
	
	/**
	*	@name: load_shifts_copy
	*	@desc: ajax function to load the calendar popup for copying shifts across
	*	@access: public
	*	@param: string of shift id 1~2~3~4 (via GET)
	*	@return: calendar view
	*/
	function load_shifts_copy($s = '')
	{
		$shifts = explode('~', $s);
		
		$data['shift'] = $this->job_shift_model->get_job_shift($shifts[0]);
		$data['shifts'] = $shifts;		
		$this->load->view('shifts_copy', isset($data) ? $data : NULL);
	}	
	
	
	/**
	*	@name: copy_selected_days
	*	@desc: ajax function to copy selected shifts to selected days
	*	@access: public
	*	@param: array of shift id
	*	@return: json encode {success: (boolean), msg: (string)}
	*/
	function copy_selected_days()
	{
		$dates = $this->input->post('dates');
		if ($dates)
		{
			$shifts = $this->input->post('shifts');
			if (count($dates) * count($shifts) > modules::run('account/get_credits'))
			{
				echo json_encode(array('ok' => false, 'msg' => 'Not enough credits.'));
				return;
			}
			
			$count = 0;
			
			foreach($dates as $date)
			{
				foreach($shifts as $shift_id)
				{
					$shift = $this->job_shift_model->get_job_shift($shift_id);
					$new_shift = $shift;
					unset($new_shift['shift_id']);
					unset($new_shift['created_on']);
					unset($new_shift['modified_on']);
					$ts = strtotime($date);
					$new_shift['job_date'] = date('Y-m-d', $ts);
					$start_time = strtotime(date('Y-m-d', $ts) . ' ' . date('H:i', $shift['start_time']));
					$finish_time = $start_time + $shift['finish_time'] - $shift['start_time'];
					$new_shift['start_time'] = $start_time;
					$new_shift['finish_time'] = $finish_time;
					
					$breaks = json_decode($shift['break_time']);
					$new_breaks = array();
					if (count($breaks) > 0)
					{
						foreach($breaks as $break)
						{
							$new_breaks[] = array(
								'length' => $break->length,
								'start_at' => $start_time + $break->start_at - $shift['start_time']
							);
						}
					}
					
					$new_shift['break_time'] = json_encode($new_breaks);
					$new_shift_id = $this->job_shift_model->insert_job_shift($new_shift);
					
					# Copy request staff
					$request_staffs = $this->job_shift_model->get_request_staffs($shift_id);
					if($request_staffs)
					{
						foreach($request_staffs as $request_staff)
						{
							$this->job_shift_model->add_request_staff(array(
								'shift_id' => $new_shift_id,
								'staff_id' => $request_staff['staff_id']
							));
						}
					}
					
					# copy notes
					$notes = $this->job_shift_model->get_job_shift_notes($shift_id);
					if($notes)
					{
						foreach($notes as $note)
						{
							$data_note = array(
									'shift_id' => $new_shift_id,
									'note' => $note->note,
									'added_by_user_id' => $note->added_by_user_id
									);
						    $this->job_shift_model->add_note($data_note);
						}
					}
					# copy briefs
					$briefs = $this->job_shift_model->get_shift_brief_by_shift_id($shift_id);
					if($briefs)
					{
						foreach($briefs as $brief)
						{
							$data_brief = array(
										'shift_id' => $new_shift_id,
										'brief_id' => $brief->brief_id
										);	
							$this->job_shift_model->add_brief($data_brief);
						}
					}
					$count++;
				}				
			}
			
			# Take the credits out
			$this->load->model('account/account_model');
			$this->account_model->deduct_credits($count);
			echo json_encode(array('ok' => true, 'date' => $date));
		}
		else
		{
			echo json_encode(array('ok' => false, 'msg' => 'No day selected'));
		}		
	}
	
	
	
	function search_staffs($shift_id)
	{
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/search_staff/modal_view', isset($data) ? $data : NULL);
	}
	
	function applied_staffs($shift_id) {
		$data['staffs'] = $this->job_shift_model->get_applied_staffs($shift_id);
		$data['shift_id'] = $shift_id;
		$data['shift'] = $this->job_shift_model->get_job_shift($shift_id);
		$this->load->view('shift/applied_staff/modal_view', isset($data) ? $data : NULL);
	}
	
	function load_client_departments() {
		$user_id = $this->input->post('user_id');
		if ($user_id)
		{
			echo modules::run('client/field_select_departments', $user_id, 'department_id');	
		}
	}
		
}