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
		$this->load->model('attribute/payrate_model');
		$this->load->model('expense/expense_model');
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
	
	function run_forecast()
	{
		$this->report_model->clear_forecast();
		$today = date('Y-m-d');
		$months[] = date('Y-m');
		for($i=1; $i <= 3; $i++) {
			$months[] = date('Y-m', strtotime("$today +$i month"));
		}
		foreach($months as $month) {
			$shifts = $this->report_model->get_month_shifts($month);
			foreach($shifts as $shift) {
				$expenses_staff_cost = 0;
				$expenses_client_cost = 0;
				$total_amount_staff = 0;
				$total_amount_client = 0;
				
				$payrate_id = $shift['payrate_id'];
				$start_time = $shift['start_time'];
				$finish_time = $shift['finish_time'];
				if ($payrate_id)
				{
					for($i=$start_time; $i < $finish_time; $i = $i + 60*15) 
					{ # Every 15 minutes
						$day = date('N', $i); # Get day of the week (1: for monday, 7 for sunday)
						$hour = date('G', $i); # Get hour of the day (0 - 23)
						
						# Amount paid calculated by 15 minute
						
						$total_amount_staff += $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
						$total_amount_client += $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/4;
					}
					
					# Deduct the break
					
					$breaks = json_decode($shift['break_time']);
					if (count($breaks) > 0) {
						foreach($breaks as $break)
						{
							$length = $break->length;
							$start_at = $break->start_at;
							for($i=0; $i < $length; $i = $i + 60*15) { # Every 15 minute
								$start_at = $start_at + $i;
								$day = date('N', $i);
								$hour = date('G', $i);
								$total_amount_staff -= $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour)/4;
								$total_amount_client -= $this->payrate_model->get_payrate_data($payrate_id, 1, $day, $hour)/4;
							}
						}
					}
					
					# Update expenses cost
					
					$expenses = unserialize($shift['expenses']);
					if ($expenses && is_array($expenses)) {
						foreach($expenses as $exp) {
							$client_cost = $exp['client_cost'];
							$staff_cost = $exp['staff_cost'];
							if ($exp['tax'] == GST_ADD)
							{
								$client_cost *= 1.1;
								$staff_cost *= 1.1;
							}
							$expenses_client_cost += $client_cost;
							$expenses_staff_cost += $staff_cost;
						}
					}
				}
				
				$data = array(
					'shift_id' => $shift['shift_id'],
					'job_date' => $shift['job_date'],
					'expenses_staff_cost' => $expenses_staff_cost,
					'expenses_client_cost' => $expenses_client_cost,
					'total_amount_staff' => $total_amount_staff,
					'total_amount_client' => $total_amount_client
				);
				$forecast_id = $this->report_model->add_forecast($data);
			}
		}
	}
	
	function load_forecast_data()
	{
		$today = date('Y-m-d');
		$months[] = date('Y-m');
		for($i=1; $i <= 3; $i++) {
			$months[] = date('Y-m', strtotime("$today +$i month"));
		}
		$categories = array();
		$expenses = array();
		$invoices = array();
		$pays = array();
		$profits = array();
		foreach($months as $month) {
			$categories[] = date('M Y', strtotime($month));
			$timesheets = $this->report_model->get_forecast($month);
			$expense = 0;
			$invoice = 0;
			$pay = 0;
			$profit = 0;
			foreach($timesheets as $timesheet)
			{
				$expense += $timesheet['expenses_staff_cost'];
				$invoice += $timesheet['expenses_client_cost'] + $timesheet['total_amount_client'];
				$pay += $timesheet['total_amount_staff'];
			}
			$expenses[] = (int) $expense;
			$invoices[] = (int) $invoice;
			$pays[] = (int) $pay;
			$profits[] = (int) ($invoice - $expense - $pay);
		}
		$data['categories'] = implode(',', $categories);
		$data['expenses'] = $expenses;
		$data['invoices'] = $invoices;
		$data['pays'] = $pays;
		$data['profits'] = $profits;
		$data['months'] = $months;
		echo json_encode($data);
	}
}