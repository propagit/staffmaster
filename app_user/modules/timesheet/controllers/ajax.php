<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@module: Timesheet
 *	@controller: Ajax
 */

class Ajax extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('timesheet_model');
		$this->load->model('expense/expense_model');
	}
	
	/**
	*	@name: search_timesheets
	*	@desc: ajax function to search timesheets
	*	@access: public
	*	@param: (POST)
	*	@return: (html) view of list of timesheets
	*/
	function search_timesheets() {
		$params = $this->input->post();
		$data['timesheets'] = $this->timesheet_model->search_timesheets($params);
		$this->load->view('table_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: batch_timesheet
	*	@desc: ajax function to batch a timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (void)
	*/
	function batch_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		modules::run('timesheet/update_timesheet_hour_rate', $timesheet_id);
		$this->timesheet_model->update_timesheet($timesheet_id, array(
			'status' => TIMESHEET_BATCHED,
			'status_payrun_staff' => PAYRUN_PENDING,
			'status_invoice_client' => INVOICE_PENDING
		));
	}
	
	/**
	*	@name: details
	*	@desc: ajax function to load details modal view of a timesheet
	*	@access: public
	*	@param: $timesheet_id
	*	@return: (html) details modal view
	*/
	function details($timesheet_id) {
		$data['timesheet'] = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['paid_expenses'] = $this->expense_model->get_timesheet_expenses($timesheet_id);
		$this->load->view('details_modal_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: delete_timesheet
	*	@desc: ajax function to delete a timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (void)
	*/
	function delete_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		# First get the timesheet
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		
		# Delete the timesheet
		$this->timesheet_model->delete_timesheet($timesheet_id);
		
		# Unlock the shift
		$this->load->model('job/job_shift_model');
		$this->job_shift_model->update_job_shift($timesheet['shift_id'], array('status' => SHIFT_CONFIRMED));
	}
	
	/**
	*	@name: update_timesheet_start_time
	*	@desc: ajax function to update timesheet start time (inline edit)
	*	@access: public
	*	@param: (POST) pk, value
	*	@return: (JSON) {status: boolean, value: $new_start_time}
	*/
	function update_timesheet_start_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$new_start_time = strtotime($this->input->post('value') . ':00');
		if ($new_start_time >= $timesheet['finish_time']) {
			$this->output->set_status_header('400');
			echo 'Start time cannot be greater than finish time';
		} else {
			$this->timesheet_model->update_timesheet($timesheet_id, array('start_time' => $new_start_time));
			echo json_encode(array('status' => 'success', 'value' => $new_start_time));
		}
	}
	
	/**
	*	@name: update_timesheet_finish_time
	*	@desc: ajax function to update timesheet finish time (inline edit)
	*	@access: public
	*	@param: (POST) pk, value
	*	@return: (JSON) {status: boolean, value: $new_finish_time}
	*/
	function update_timesheet_finish_time() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$new_finish_time = strtotime($this->input->post('value') . ':00');
		if ($new_finish_time <= $timesheet['start_time']) {
			$this->output->set_status_header('400');
			echo 'Finish time cannot be less than start time';
		} else {
			$this->timesheet_model->update_timesheet($timesheet_id, array('finish_time' => $new_finish_time));
			echo json_encode(array('status' => 'success', 'value' => $new_finish_time));
		}
	}
	
	/**
	*	@name: update_timesheet_payrate
	*	@desc: ajax function to update timesheet pay rate
	*	@access: public
	*	@param: (POST) pk, value
	*	@return: (void)
	*/
	function update_timesheet_payrate() {
		$timesheet_id = $this->input->post('pk');
		$this->timesheet_model->update_timesheet($timesheet_id, array('payrate_id' => $this->input->post('value')));
	}
	
	/**
	*	@name: refresh_timesheet
	*	@desc: ajax function to reload timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (html) tr view of one timesheet
	*/
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		echo modules::run('timesheet/row_timesheet', $timesheet_id);
	}
	
	/**
	*	@name: load_ts_breaks
	*	@desc: ajax function to load break edit view
	*	@access: public
	*	@param: (POST) pk - timesheet_id
	*	@return: (html) edit view of break
	*/
	function load_ts_breaks() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['breaks'] = json_decode($timesheet['break_time']);
		$data['timesheet_id'] = $timesheet_id;
		$data['timesheet'] = $timesheet;
		$this->load->view('edit/break/list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_ts_break
	*	@desc: ajax function to load add break form view
	*	@access: public
	*	@param: (POST) pk - timesheet_id
	*	@return: (html) add form view
	*/
	function add_ts_break() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['timesheet'] = $timesheet;
		$this->load->view('edit/break/add_form_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_ts_breaks
	*	@desc: ajax function to update breaks
	*	@access: public
	*	@param: (POST) break_length (array of minutes), break_start_at (array of datetime)
	*	@return: (JSON) {ok: boolean}
	*/
	function update_ts_breaks() {
		$length = $this->input->post('break_length');
		$start_at = $this->input->post('break_start_at');
		$timesheet = $this->timesheet_model->get_timesheet($this->input->post('timesheet_id'));
		
		$breaks = array();
		foreach($length as $index => $value) {
			if ($value > 0) {
				$break_time = array(
					'length' => $value * 60,
					'start_at' => strtotime($start_at[$index])
				);
				
				if ($break_time['start_at'] <= $timesheet['start_time'] || $break_time['start_at'] >= $timesheet['finish_time']) {
					echo json_encode(array('ok' => false, 'number' => $index));
					return;
				}
				$breaks[] = $break_time;
			}
		}
		
		if ($this->timesheet_model->update_timesheet($timesheet['timesheet_id'], array('break_time' => json_encode($breaks)))) {
			echo json_encode(array('ok' => true));
		}
	}
	
	/**
	*	@name: load_ts_staff
	*	@desc: ajax function to load search staff form
	*	@access: public
	*	@param: (POST) pk - timesheet_id
	*	@return: (html) view of search staff form
	*/
	function load_ts_staff() {
		$timesheet_id = $this->input->post('pk');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$data['timesheet'] = $timesheet;
		$data['staff'] = modules::run('staff/get_staff', $timesheet['staff_id']);
		$this->load->view('edit/staff/search_form_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_staff_for_ts
	*	@desc: ajax function to search staff
	*	@access: public
	*	@param: (POST) query
	*	@return: (html) search results view
	*/
	function search_staff_for_ts() {
		$query = $this->input->post('query');
		$this->load->model('staff/staff_model');
		$data['staffs'] = $this->staff_model->search_staffs(array('keyword' => $query, 'limit' => 6));
		$this->load->view('edit/staff/search_results_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: update_ts_staff
	*	@desc: ajax function to update staff of the timesheet
	*	@access: public
	*	@param: (POST)
	*	@return: (JSON) {ok:boolean, msg: string}
	*/
	function update_ts_staff() {
		$data = $this->input->post();
		$update_ts_data = array();
		if ($data['ts_staff']) {
			$staff = modules::run('staff/get_staff_by_name', $data['ts_staff']);
			
			if ($staff) {
				$this->timesheet_model->update_timesheet($data['timesheet_id'], array('staff_id' => $data['ts_staff_id']));
				echo json_encode(array('ok' => true));
			}
			else {
				echo json_encode(array('ok' => false, 'msg' => 'Staff not found'));
				return;
			}
		}
		else {
			echo json_encode(array('ok' => false, 'msg' => 'This field cannot be empty'));
			return;
		}		
	}
	
	/**
	*	@name: load_expenses_modal
	*	@desc: ajax function to open modal of timesheet expenses
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (html) modal view of expense
	*/
	function load_expenses_modal($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('edit/expense/modal_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: list_expenses
	*	@desc: ajax function to list expenses of a timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (html) list view of expense items
	*/
	function list_expenses() {
		$timesheet_id = $this->input->post('timesheet_id');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		if($timesheet) {
			$data['expenses'] = unserialize($timesheet['expenses']);
		}
		$data['timesheet_id'] = $timesheet_id;
		$data['paid_expenses'] = $this->expense_model->get_timesheet_expenses($timesheet_id);
		$this->load->view('edit/expense/table_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_expense
	*	@desc: ajax function to add an expense item of a timesheet
	*	@access: public
	*	@param: (POST) description, staff_cost, client_cost, tax, timesheet_id
	*	@return: (JSON) {ok:(boolean)}
	*/
	function add_expense() {
		$data = $this->input->post();
		if ($data['description'] == '') {
			echo json_encode(array('ok' => false, 'error_id' => 'description'));
			return;
		}
		if (!is_numeric($data['staff_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'staff_cost'));
			return;
		}
		if (!is_numeric($data['client_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'client_cost'));
			return;
		}
		$timesheet = $this->timesheet_model->get_timesheet($data['timesheet_id']);
		$expenses = $timesheet['expenses'];
		if ($expenses == '') {
			$expenses = array();
		} else {
			$expenses = unserialize($expenses);
		}
		array_push( $expenses, array(
			'description' => $data['description'],
			'staff_cost' => $data['staff_cost'],
			'client_cost' => $data['client_cost'],
			'tax' => $data['tax']
		));
		$updated = $this->timesheet_model->update_timesheet($data['timesheet_id'], array(
			'expenses' => serialize($expenses)
		));
		if ($updated) {
			echo json_encode(array('ok' => true));
		}
	}
	
	/**
	*	@name: delete_expense
	*	@desc: ajax function to delete an expense item of a timesheet
	*	@access: public
	*	@param: (POST) 	timesheet_id, i (index of the expense item)
	*	@return: (void)
	*/
	function delete_expense() {
		$timesheet_id = $this->input->post('timesheet_id');
		$index = $this->input->post('i');
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		$expenses = unserialize($timesheet['expenses']);
		$array = array();
		if ($expenses) {
			$i = 0;
			foreach($expenses as $expense) {
				if ($i!=$index) {
					$array[] = $expense;
				}
				$i++;
			}
		}
		$this->timesheet_model->update_timesheet($timesheet_id, array(
			'expenses' => serialize($array)
		));
	}
}