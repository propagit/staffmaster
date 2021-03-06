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
	
	
	function index($tab='create-payrun') {
		$data['tab'] = $tab;
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}	
	
	function create_view() {
		$this->load->view('create_view', isset($data) ? $data : NULL);
	}
	
	function search_payrun_view() {
		$this->load->view('search_payrun_view', isset($data) ? $data : NULL);	
	}
	
	function search_payslip_view() {
		$this->load->view('search_payslip_view', isset($data) ? $data : NULL);	
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
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		$data['staff_timesheets'] = $timesheets;
		$data['staff'] = $this->staff_model->get_staff($user_id);
		$data['expanded'] = $expanded;
		return $this->load->view('source/batched_staff_row', isset($data) ? $data : NULL, true);
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
		# get top parent
		$data['top_parent_id'] = modules::run('timesheet/get_top_parent',$timesheet_id);
		
		$this->load->view('source/timesheet_row', isset($data) ? $data : NULL);
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
	*	@name: field_select_type
	*	@desc: custom field select type of payrun
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected value of field
	*			- $size (optional): size 
	*	@return: custom select input field
	*/
	function field_select_type($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => STAFF_TFN, 'label' => 'TFN'),
			array('value' => STAFF_ABN, 'label' => 'ABN')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function field_select_export_templates($type, $field_name, $field_value=null) {
		$object = 'payrun_' . (($type == STAFF_TFN) ? 'tfn' : 'abn');
		$this->load->model('export/export_model');
		$data['templates'] = $this->export_model->get_templates($object);
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('field_select_export_templates', isset($data) ? $data : NULL);
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
			array('value' => PAYRUN_READY, 'label' => 'Yes')
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
			array('value' => 'revert', 'label' => 'Revert Selected')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
	
	function count_staff($tfn) {
		return $this->payrun_model->count_staff($tfn);
	}
	
	function get_total_amount($tfn) {
		return $this->payrun_model->get_total_amount($tfn);
	}
	
	function btn_api($staff_count)
	{
		$platform = $this->config_model->get('accounting_platform');
		
		if (!$platform)
		{
			return;
		}
		if ($platform == 'myob')
		{
			if (!$this->config_model->get('myob_company_id'))
			{
				return;
			}
			$platform = 'MYOB';
		}
		$data['platform'] = $platform;
		$data['staff_count'] = $staff_count;
		$this->load->view('btn_api', isset($data) ? $data : NULL);
	}
	
	function revert_xero_payrun($payrun_id)
	{
		$timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		foreach($timesheets as $ts){
			$this->payrun_model->update_synced($ts['timesheet_id'], array(
								'payrun_id' => 0,
								'external_id' => '',
								'external_msg' => '',
								'status_payrun_staff' => PAYRUN_READY,
								'staff_paid_on' => '0000-00-00 00:00:00'
							));		
		}
		$this->payrun_model->delete_payrun($payrun_id);
	}
}