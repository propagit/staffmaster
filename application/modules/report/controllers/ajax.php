<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Report/Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('report/report_model');
	}
	
	function load_financial_year_data() {
		$year = $this->input->post('year');
		$start_month = $year . '-07'; # Start of financial year
		$months[] = $start_month;
		for($i=1; $i < 12; $i++) {
			$months[] = date('Y-m', strtotime("$start_month +$i month"));
		}
		$categories = array();
		$expenses = array();
		$staff_pays = array();
		foreach($months as $month) {
			$categories[] = date('M y', strtotime($month));
			$expenses[] = (int) $this->report_model->get_expenses_cost($month);
			$invoices[] = (int) $this->report_model->get_invoice_amount($month);
			$pays[] = (int) $this->report_model->get_staff_cost($month);
		}
		$profits = array();
		for($i=0; $i<12; $i++) {
			$profits[$i] = $invoices[$i] - $expenses[$i] - $pays[$i];
		}
		$data['categories'] = implode(',', $categories);
		$data['expenses'] = $expenses;
		$data['invoices'] = $invoices;
		$data['pays'] = $pays;
		$data['profits'] = $profits;
		echo json_encode($data);
	}
	
}