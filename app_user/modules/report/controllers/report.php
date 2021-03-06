<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Report
 * @author: namnd86@gmail.com
 */

class Report extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('report/report_model');
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
	
	function financial_year_view() {
		$this->load->view('financial_year_view', isset($data) ? $data : NULL);
	}
		
	function fore_cast_view() {
		$this->load->view('forecast_view', isset($data) ? $data : NULL);
	}
	
	function top_clients_view() {
		$this->load->view('top_clients_view', isset($data) ? $data : NULL);
	}
	
	function top_staff_view() {
		$this->load->view('top_staff_view', isset($data) ? $data : NULL);
	}
	
	function per_job_view() {
		$this->load->view('per_job_view', isset($data) ? $data : NULL);
	}
	
	function field_select_financial_year($field_name, $field_value=null, $size=null) {
		$max_year = date('Y');
		if (date('n') >= 7) {
			$max_year++;
		}
		$years = array();
		for($i=$max_year; $i > 2013; $i--) {
			$years[] = array('value' => ($i - 1), 'label' => ($i - 1) . '-' . $i);
		}
		$field_value = $max_year - 1;
		return modules::run('common/field_select', $years, $field_name, $field_value, $size, false);
		
	}
	
	function field_select_year($field_name, $field_value=null, $size=null) {
		$years = array(
			array('value' => '2014', 'label' => '2014')
		);
		return modules::run('common/field_select', $years, $field_name, $field_value, $size, false);
	}
	
	function field_select_month($field_name, $field_value=null, $size=null) {
		$months = array(
			array('value' => '', 'label' => 'All Months'),
			array('value' => '01', 'label' => 'January'),
			array('value' => '02', 'label' => 'February'),
			array('value' => '03', 'label' => 'March'),
			array('value' => '04', 'label' => 'April'),
			array('value' => '05', 'label' => 'May'),
			array('value' => '06', 'label' => 'June'),
			array('value' => '07', 'label' => 'July'),
			array('value' => '08', 'label' => 'August'),
			array('value' => '09', 'label' => 'September'),
			array('value' => '10', 'label' => 'October'),
			array('value' => '11', 'label' => 'November'),
			array('value' => '12', 'label' => 'December')
		);
		return modules::run('common/field_select', $months, $field_name, $field_value, $size, false);
	}
	
	function field_select_week_month($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => 'week', 'label' => 'This Week'),
			array('value' => 'month', 'label' => 'This Month')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size, false);
	}
}