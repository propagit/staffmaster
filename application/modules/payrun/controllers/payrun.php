<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Payrun
 * @author: namnd86@gmail.com
 */

class Payrun extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrun_model');
		$this->load->model('staff/staff_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	/**
	*	@name: main_view
	*	@desc: load the main layout of the payrun page
	*	@access: public
	*	@param: (void)
	*	@return: (void) load main layout of the payrun page
	*/
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: row_batched_staff
	*	@desc: load the row (tr) of batched timesheets of a specified staff
	*	@access: public
	*	@param: (int) $user_id
	*			(boolean) $expanded (default: false)
	*	@return: (html) row (tr) content of batched timesheets of a specified staff
	*/
	function row_batched_staff($user_id, $expanded = false) {
		$data['staff_timesheets'] = $this->payrun_model->get_staff_timesheets($user_id);
		$data['staff'] = $this->staff_model->get_staff($user_id);
		$data['expanded'] = $expanded;
		return $this->load->view('batched_staff_row', isset($data) ? $data : NULL, true);
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: load the row (tr) of single timesheet
	*	@access: public
	*	@param: (int) $timesheet_id
	*			(int) $user_id
	*	@return: (html) row (tr) content of single timesheet
	*/
	function row_timesheet($timesheet_id, $user_id) {
		$data['timesheet'] = $this->payrun_model->get_timesheet($timesheet_id);
		$data['user_id'] = $user_id;
		$this->load->view('timesheet_row', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: row_timesheets_staff
	*	@desc: load the rows (tr) of all timesheets of a specified staff
	*	@access: public
	*	@param: (int) $user_id
	*	@return: (html) rows (tr) of all timesheets of a specified staff 
	*/
	function row_timesheets_staff($user_id) 
	{
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		foreach($timesheets as $timesheet) {
			$this->row_timesheet($timesheet['timesheet_id'], $user_id);
		}
	}
	
	/**
	*	@name: menu_dropdown
	*	@desc: generate the dropdown menu of pay run
	*	@access: public
	*	@param: (string) $id
	*			(string) $label
	*	@return: (html) dropdown menu of pay run filter
	*/
	function menu_dropdown($id, $label) {
		$data = array(
			array('value' => '', 'label' => 'Any'),
			array('value' => TIMESHEET_PROCESSING, 'label' => 'Yes'),
			array('value' => TIMESHEET_BATCHED, 'label' => 'No')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	/**
	*	@name: menu_dropdown_actions
	*	@desc: generate the dropdown menu of actions
	*	@access: public
	*	@param: (string) $id
	*			(string) $label
	*	@return: (html) dropdown menu of actions
	*/
	function menu_dropdown_actions($id, $label) {
		$data = array(
			array('value' => 'process', 'label' => 'Set Yes for Pay Run'),
			array('value' => 'unprocess', 'label' => 'Set No for Pay Run'),
			array('value' => 'revert', 'label' => 'Revert Selected'),
			array('value' => 'archive', 'label' => 'Archive Selected'),
			array('value' => 'export', 'label' => 'Export Selected')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	function count_staff($tfn) {
		return $this->payrun_model->count_staff($tfn);
	}
	
	function get_total_amount($tfn) {
		return $this->payrun_model->get_total_amount($tfn);
	}
}