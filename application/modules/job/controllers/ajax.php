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
		
		if (!$data['start_time'])
		{
			# Start time is required
			#echo json_encode(array('ok' => false, 'error_id' => 'start_time'));
			#return;
		}
		$filter_data['start_time'] = strtotime($filter_data['job_date'] . ' ' . $data['start_time']);
		
		$filter_data['finish_time'] = strtotime($filter_data['job_date'] . ' ' . $data['finish_time']);
		if ($filter_data['finish_time'] < $filter_data['start_time'])
		{
			# Finish time can not be less than start time
			echo json_encode(array('ok' => false, 'error_id' => 'finish_time'));
			return;
		}
		
		if ($data['break_length'] > 0)
		{
			$break_time = array(
				'length' => $data['break_length'] * 60,
				'start_at' => strtotime($filter_data['job_date'] . ' ' . $data['break_start_at'])
			);
			
			if ($break_time['start_at'] < $filter_data['start_time'] || $break_time['start_at'] > $filter_data['finish_time'])
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
			$out[] = array();
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
			if (count($job_dates) > 0)
			{
				$data['events_source'] = str_replace('[],', '',json_encode($out));	
			}
			else
			{
				$data['events_source'] = '[]';
			}
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
		$new_start_time = strtotime($shift['job_date'] . ' ' . $this->input->post('value') . ':00');
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
		$new_finish_time = strtotime($shift['job_date'] . ' ' . $this->input->post('value') . ':00');
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
	
	function load_shift_breaks()
	{
		$shift_id = $this->input->post('pk');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$data['breaks'] = json_decode($shift['break_time']);
		$data['shift_id'] = $shift_id;
		$this->load->view('shift_breaks', isset($data) ? $data : NULL);
	}
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
					'start_at' => strtotime($job_shift['job_date'] . ' ' . $start_at[$index])
				);
				
				if ($break_time['start_at'] < $job_shift['start_time'] || $break_time['start_at'] > $job_shift['finish_time'])
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
			$minutes = $total . ' mins';
			echo json_encode(array('ok' => true, 'shift_id' => $job_shift['shift_id'],'minutes' => $minutes));
		}
	}
	
	
	function set_order_param()
	{
		$param = $_POST['param'];
		$this->session->set_userdata('job_sort_key', $param);
		
		$value = $this->session->userdata('job_sort_value');
		$value = ($value == 'ASC') ? 'DESC' : 'ASC';
		$this->session->set_userdata('job_sort_value', $value);
	}
	
	function sendmail()
	{
		if ($this->input->post())
    	{
    		$email = $this->input->post('email');
    		if (!valid_email($email))
    		{
	    		echo json_encode(array(
	    			'result' => false,
	    			'msg' => 'Invalid email address'
	    		));
    		}
    		else
    		{
	    		$order = $this->job_model->get_job($this->input->post('order_id'));
		    	# Sending email
				$config = array();
				$config['useragent']		= "CodeIgniter";
				$config['mailpath']			= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
				$config['protocol']			= "smtp";
				$config['smtp_host']		= "localhost";
				$config['smtp_port']		= "25";
				$config['mailtype'] 		= 'html';
				$config['charset']  		= 'utf-8';
				$config['newline']  		= "\r\n";
				$config['wordwrap'] 		= TRUE;
				#$config['send_multipart']	= FALSE;
				
				$this->load->library('email');
				
				$this->email->initialize($config);
				$user = $this->session->userdata('user_data');
				
				$this->email->from($user['company_email'], $user['company_name']);
				
				$this->email->subject('Order Confirmation: ' . $order['sys_rma']);
				$this->email->to($email); 
				$message = $this->load->view('email_receipt', array('order' => $order, 'user' => $user), true);
		        $this->email->message($message);
		        
				if($this->email->send())
				{
					echo json_encode(array(
						'result' => true
					));	
				}
    		}
    		
    	}
	}
		
}