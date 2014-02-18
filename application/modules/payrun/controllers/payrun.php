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
	
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function row_batched_staff($user_id) {
		$data['staff_timesheets'] = $this->payrun_model->get_staff_timesheets($user_id);
		$data['staff'] = $this->staff_model->get_staff($user_id);
		return $this->load->view('batched_staff_row', isset($data) ? $data : NULL, true);
	}
	
	function row_timesheets_staff($user_id) 
	{
		$data['user_id'] = $user_id;
		$data['timesheets'] = $this->payrun_model->get_staff_timesheets($user_id);
		return $this->load->view('timesheets_staff_row', isset($data) ? $data : NULL, true);
	}
	
	function menu_dropdown($id, $label) {
		$data = array(
			array('value' => '', 'label' => 'Any'),
			array('value' => TIMESHEET_PROCESSING, 'label' => 'Yes'),
			array('value' => TIMESHEET_BATCHED, 'label' => 'No')
		);
		return modules::run('common/menu_dropdown', $data, $id, $label);
	}
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