<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrun_model');
	}
	
	/**
	*	@name: list_payruns
	*	@desc: ajax function to get the list of staff with batched timesheets
	*	@access: public
	*	@param: (void)
	*	@return: (html) main layout of list pay runs 
	*/
	function list_payruns() {
		$data['staffs'] = $this->payrun_model->get_staffs();
		$this->load->view('payruns_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: get_payrun_stats
	*	@desc: ajax function to get the stats of pay run
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of pay run stats
	*/
	function get_payrun_stats() {
		$this->load->view('stats', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: set_filter
	*	@desc: ajax function to set filter for list pay runs and save to sessions
	*	@access: public
	*	@param: (via POST) 
	*		- name
	*		- value
	*	@return: (void)
	*/
	function set_filter() {
		$this->session->set_userdata('prf_' . $this->input->post('name'), $this->input->post('value'));
	}
	
	function select_payrun_staff($user_id, $checked) {
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		foreach($timesheets as $timesheet) {
			$this->select_payrun_timesheet($timesheet['timesheet_id'], $checked);
		}
	}
	
	function select_payrun_timesheet($timesheet_id, $checked) {
		$timesheets = $this->session->userdata('payrun_timesheets');
		if ($checked == "true") {
			if (!in_array($timesheet_id, $timesheets)) {
				$timesheets[] = $timesheet_id;
			}
		}
		else {
			if (in_array($timesheet_id, $timesheets)) {
				unset($timesheets[array_search($timesheet_id, $timesheets)]);
			}
		}
		$this->session->set_userdata('payrun_timesheets', $timesheets);
	}
	
	/**
	*	@name: row_timesheets_staff
	*	@desc: ajax function to display the row (tr) content of batched staff
	*	@access: public
	*	@param: (via POST)
	*		- (int) user_id
	*		- (boolean) expanded
	*	@return: (html) the row (tr) of batched staff
	*/
	function row_timesheets_staff() {
		echo modules::run('payrun/row_batched_staff', $this->input->post('user_id'), $this->input->post('expanded'));
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: ajax function to display the row (tr) content of single timesheet
	*	@access: public
	*	@param: (via POST)
	*		- (int) timesheet_id
	*		- (int) user_id
	*	@return: (html) the row (tr) of single timesheet
	*/
	function row_timesheet() {
		echo modules::run('payrun/row_timesheet', $this->input->post('timesheet_id'), $this->input->post('user_id'));
	}
		
	function process_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->process_staff_payruns($user_id);
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		$output = array();
		foreach($timesheets as $timesheet)
		{
			$output[] = $timesheet['timesheet_id'];
		}
		echo json_encode($output);
	}
	
	function unprocess_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->unprocess_staff_payruns($user_id);
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		$output = array();
		foreach($timesheets as $timesheet)
		{
			$output[] = $timesheet['timesheet_id'];
		}
		echo json_encode($output);
	}
	
	function process_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->process_payrun($timesheet_id);
	}
	
	function unprocess_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->unprocess_payrun($timesheet_id);
	}
	
	function expand_staff_timehsheets() {
		$user_id = $this->input->post('user_id');
		$parent = modules::run('payrun/row_batched_staff', $user_id, true);
		$children = modules::run('payrun/row_timesheets_staff', $user_id);
		echo json_encode(array(
			'parent' => $parent,
			'children' => $children
		));
	}
	
	function revert_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->revert_staff_payruns($user_id);		
	}
	
	function revert_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->revert_payrun($timesheet_id);
	}
	

}