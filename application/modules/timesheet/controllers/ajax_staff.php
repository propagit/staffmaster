<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Job
 * @author: namnd86@gmail.com
 */

class Ajax_staff extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet_staff_model');
		$this->load->model('expense/expense_model');
	}
	
	
	function list_timesheets() {
		$data['timesheets'] = $this->timesheet_staff_model->get_timesheets();
		$data['is_supervised'] = 0;
		$this->load->view('staff/timesheets_list', isset($data) ? $data : NULL);
	}
	
	function load_supervised_timesheets() {
		$data['timesheets'] = $this->timesheet_staff_model->get_supervised_timesheets();
		$data['is_supervised'] = 1;
		$this->load->view('staff/timesheets_list', isset($data) ? $data : NULL);
	}
	
	function refresh_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$is_supervised = $this->input->post('is_supervised');
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet_id, $is_supervised);
	}
	
	function submit_timesheet() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->timesheet_staff_model->submit_timesheet($timesheet_id);
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
		$this->load->view('staff/edit/expense/modal_view', isset($data) ? $data : NULL);
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
		$timesheet = $this->timesheet_staff_model->get_timesheet($timesheet_id);
		if($timesheet) {
			$data['expenses'] = unserialize($timesheet['expenses']);
		}
		$data['timesheet_id'] = $timesheet_id;
		$data['paid_expenses'] = $this->expense_model->get_timesheet_expenses($timesheet_id);
		$this->load->view('staff/edit/expense/table_list_view', isset($data) ? $data : NULL);
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
		$timesheet = $this->timesheet_staff_model->get_timesheet($data['timesheet_id']);
		$expenses = $timesheet['expenses'];
		if ($expenses == '') {
			$expenses = array();
		} else {
			$expenses = unserialize($expenses);
		}
		array_push( $expenses, array(
			'description' => $data['description'],
			'staff_cost' => $data['staff_cost'],
			'client_cost' => 0,
			'tax' => $data['tax']
		));
		$updated = $this->timesheet_staff_model->update_timesheet($data['timesheet_id'], array(
			'expenses' => serialize($expenses)
		));
		if ($updated) {
			echo json_encode(array('ok' => true));
		}
	}
}