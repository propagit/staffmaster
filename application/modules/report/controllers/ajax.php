<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Report/Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function load_financial_year_data() {
		$year = $this->input->post('year');
		$start_month = $year . '-07'; # Start of financial year
		$months[] = $start_month;
		for($i=1; $i < 12; $i++) {
			$months[] = date('Y-m', strtotime("$start_month +$i month"));
		}
		$categories = array();
		foreach($months as $month) {
			$categories[] = date('M y', strtotime($month));
		}
		
		$data['categories'] = implode(',', $categories);
		echo json_encode($data);
	}
	
	function get_sample_invoices() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = rand(80,200) * 10;
		}
		return $data;
	}
	function get_sample_pays() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = rand(40,100) * 10;
		}
		return $data;
	}
	function get_sample_expenses() {
		$data = array();
		for($i=0; $i < 12; $i++) {
			$data[] = rand(10,50) * 10;
		}
		return $data;
	}
}