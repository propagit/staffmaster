<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
	}
	
	/** 
	*	@name: search_jobs
	*	@desc: ajax function to search job(s)
	*	@access: public
	*	@param: an array of search parameters (via POST)
	*	@return: view of list of jobs  
	*/
	function search_jobs()
	{
		$data = $this->input->post();
		$data['jobs'] = $this->job_model->search_jobs($data);
		$this->load->view('jobs_search_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: create_job_shifts
	*	@desc: ajax function to create shift(s) to job
	*	@access: public
	*	@param: an array of shift parameters (via POST)
	*	@return: json encode of result {ok: $boolean, error_id: $string}
	*/
	function create_job_shifts()
	{
		$data = $this->input->post();
		$filter_data = array();
		$filter_data['job_id'] = $data['job_id'];
		$filter_data['job_date'] = date('Y-m-d', strtotime($data['job_date']));
		
		if (strtotime($data['job_date']) <= now())
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
		if ($data['venue'])
		{
			$venue = modules::run('attribute/venue/get_venue_by_name', $data['venue']);
			if (!$venue)
			{
				echo json_encode(array('ok' => false, 'error_id' => 'venue'));
				return;
			}
			else
			{
				$filter_data['venue_id'] = $venue['venue_id'];
			}
		}
		else
		{
			$filter_data['venue_id'] = $data['venue'];
		}
		
		$filter_data['role_id'] = $data['role_id'];
		$filter_data['uniform_id'] = $data['uniform_id'];
		$filter_data['payrate_id'] = $data['payrate_id'];
		$filter_data['payrate_type'] = $data['payrate_type'];
		
		$count = $data['count'];
		if ($count < 1)
		{
			echo json_encode(array('ok' => false, 'error_id' => 'count'));
			return;
		}
		
		for($i=0; $i < $count; $i++)
		{
			$this->job_shift_model->insert_job_shift($filter_data);
		}
		echo json_encode(array('ok' => true, 'job_date' => $filter_data['job_date']));
		
		
	}
	
	
	function load_job_shifts()
	{
		$job_id = $this->input->post('job_id');
		$job_dates = $this->job_shift_model->get_job_dates($job_id);
		$date = $this->input->post('date');
		$this->session->set_userdata('job_date', $date);
		
		$data['total_date'] = count($job_dates);
		$key = 0;
		foreach($job_dates as $index => $value)
		{
			if ($value['job_date'] == $this->session->userdata('job_date'))
			{
				$key = $index;	
			}
		}
		
		
		if ($key == 0)
		{
			$right_index = 2;
			$left_index = 0;
		}
		else if ($key == count($job_dates) - 1)
		{
			$right_index = $key;
			$left_index = $key - 2;
		}
		else
		{
			$right_index = $key + 1;
			$left_index = $key - 1;
		}
		
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
		$data['job_shifts'] = $this->job_shift_model->get_job_shifts($job_id, $this->session->userdata('job_date'));
		$this->load->view('job_shifts_list_view', isset($data) ? $data : NULL);
	}	
	function load_month_view()
	{
		$this->session->set_userdata('calendar_view', 'month');
		echo date('Y-m-d', $this->input->post('date'));
	}
	function load_week_view()
	{
		$this->session->set_userdata('calendar_view', 'week');
		echo date('Y-m-d', $this->input->post('date'));
	}	
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
		$data['job_id'] = $job_id;
		
		if (!$this->session->userdata('calendar_view') || $this->session->userdata('calendar_view') == 'week')
		{
			$this->load->view('job_shifts_week_view', isset($data) ? $data : NULL);	
		} else if ($this->session->userdata('calendar_view') == 'month')
		{
			$out = array();
			foreach($job_dates as $date)
			{
				$out[] = array(
					'id' => $this->job_shift_model->count_job_shifts($job_id, $date['job_date']),
					'title' => $job_id,
					'url' => $date['job_date'],
					'start' => strtotime($date['job_date']) . '000',
					'end' => strtotime($date['job_date']) . '000',
				);
			}
			$data['events_source'] = json_encode($out);
			$this->load->view('job_shifts_month_view', isset($data) ? $data : NULL);
		}
	}	
	function load_job_week()
	{
		$date = $this->input->post('date');
		$date += (int) $this->input->post('step') * 7*24*60*60;
		echo date('Y-m-d', $date);	
	}
	
	function update_shift_venue()
	{
		$shift_id = $this->input->post('pk');
		$venue = modules::run('attribute/venue/get_venue_by_name', $this->input->post('value'));
		if (!$venue)
		{
			$this->output->set_status_header('400');
			echo 'Venue not found. Please try again';
		}
		else
		{
			$this->job_shift_model->update_job_shift($shift_id, array('venue_id' => $venue['venue_id']));
			echo json_encode(array('status' => 'success', 'value' => $this->input->post('value')));
		}
	}
	function update_shift_role()
	{
		$shift_id = $this->input->post('pk');
		$this->job_shift_model->update_job_shift($shift_id, array('role_id' => $this->input->post('value')));
		
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
	
	function load_shift_staff()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$this->load->model('staff/staff_model');
		$data['staffs'] = $this->staff_model->search_staffs();
		$data['shift_id'] = $shift_id;
		$this->load->view('shift_staff', isset($data) ? $data : NULL);
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
	*	@name: update_selected_day
	*	@desc: ajax function to update selected day (to the sessions of array of all selected days) for copying shift function
	*	@access: public
	*	@param: null
	*	@return: json encode {success: true/false, msg: ''}
	*/
	function update_selected_day()
	{
		$ts = $this->input->post('ts');
		$all_ts = $this->session->userdata('all_ts');
		if (!$all_ts) {
			$all_ts = array();
		}
		$key = array_search($ts, $all_ts);
		if ($key !== false) {
			unset($all_ts[$key]);
		}
		else
		{
			if ($ts > now())
			{
				$all_ts[] = $ts;
			}
			else
			{				
				echo json_encode(array('success' => false, 'msg' => 'Cannot copy to date in the past'));
				return;
			}
		}
		
		$this->session->set_userdata('all_ts', $all_ts);
		echo json_encode(array('success' => true));	
	}
	function get_selected_days()
	{
		$all_ts = $this->session->userdata('all_ts');
		$out = array();
		
		if ($all_ts) foreach($all_ts as $ts)
		{
			$out[] = array(
				'class' => 'selected',
				'start' => $ts . '000',
				'end' => $ts . '000'
			);
		}
	
		echo json_encode(array('success' => 1, 'result' => $out));
	}
	
	/**
	*	@name: clear_selected_days
	*	@desc: ajax function to clear session of selected days for copy
	*	@access: public
	*	@param: (none)
	*	@return: (void)
	*/
	function clear_selected_days()
	{
		$this->session->unset_userdata('all_ts');
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
		$all_ts = $this->session->userdata('all_ts');
		if ($all_ts)
		{
			$shifts = $this->input->post('shifts');
			foreach($all_ts as $ts)
			{
				foreach($shifts as $shift_id)
				{
					$shift = $this->job_shift_model->get_job_shift($shift_id);
					$new_shift = $shift;
					unset($new_shift['shift_id']);
					unset($new_shift['created_on']);
					$new_shift['job_date'] = date('Y-m-d', $ts);
					$start_time = strtotime(date('Y-m-d', $ts) . ' ' . date('H:i', $shift['start_time']));
					$finish_time = $start_time + $shift['finish_time'] - $shift['start_time'];
					$new_shift['start_time'] = $start_time;
					$new_shift['finish_time'] = $finish_time;
					
					$breaks = json_decode($shift['break_time']);
					$new_breaks = array();
					foreach($breaks as $break)
					{
						$new_breaks[] = array(
							'length' => $break->length,
							'start_at' => $start_time + $break->start_at - $shift['start_time']
						);
					}
					$new_shift['break_time'] = json_encode($new_breaks);
					$this->job_shift_model->insert_job_shift($new_shift);
				}				
			}
			$this->session->unset_userdata('all_ts');
			echo json_encode(array('success' => true));
		}
		else
		{
			echo json_encode(array('success' => false, 'msg' => 'No day selected'));
		}		
	}
		
}