<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Report
 * @author: namnd86@gmail.com
 */

class Report extends MX_Controller {

	function __construct()
	{
		parent::__construct();
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
		$invoices = $this->get_sample_invoices();
		$data['invoices'] = implode(',', $invoices);
		$pays = $this->get_sample_pays();
		$data['pays'] = implode(',', $pays);
		$expenses = $this->get_sample_expenses();
		$data['expenses'] = implode(',', $expenses);
		$profits = array();
		for($i=0; $i < 12; $i++) {
			$profits[] = $invoices[$i] - $expenses[$i] - $pays[$i];
		}
		$data['profits'] = implode(',', $profits);
		$this->load->view('financial_year_view', isset($data) ? $data : NULL);
	}
	
	function get_sample_invoices() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = mt_rand(80,200) * 10;
		}
		return $data;
	}
	function get_sample_pays() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = mt_rand(40,100) * 10;
		}
		return $data;
	}
	function get_sample_expenses() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = mt_rand(10,50) * 10;
		}
		return $data;
	}
	
	function fore_cast_view() {
		$today = date('Y-m-d');
		$months[] = date('Y-m');
		for($i=1; $i <= 3; $i++) {
			$months[] = date('Y-m', strtotime("$today +$i month"));
		}
		$categories = array();
		foreach($months as $month) {
			$categories[] = date('M Y', strtotime($month));
		}
		$data['categories'] = '\'' . implode('\' , \'', $categories) . '\'';
		$data['months'] = $months;
		$this->load->view('fore_cast_view', isset($data) ? $data : NULL);
	}
	
	function field_select_financial_year($field_name, $field_value=null, $size=null) {
		$max_year = date('Y');
		if (date('n') > 7) {
			$max_year++;
		}
		$years = array();
		for($i=$max_year; $i > 2010; $i--) {
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
			array('value' => '1', 'label' => 'January'),
			array('value' => '2', 'label' => 'February'),
			array('value' => '3', 'label' => 'March'),
			array('value' => '4', 'label' => 'April'),
			array('value' => '5', 'label' => 'May'),
			array('value' => '6', 'label' => 'June'),
			array('value' => '7', 'label' => 'July'),
			array('value' => '8', 'label' => 'August'),
			array('value' => '9', 'label' => 'September'),
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