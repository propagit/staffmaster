<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Invoice
 * @author: namnd86@gmail.com
 */

class Invoice extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'create':
					$this->create($param);
				break;
			case 'edit':
					$this->edit($param);
				break;
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function row_client_job($job_id) {
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('job_client_row', isset($data) ? $data : NULL);
	}
	
	function row_timesheets_job($job_id) {
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('timesheets_job_row', isset($data) ? $data : NULL);
	}
	
	function row_timesheet($timesheet_id) {
		$data['timesheet'] = $this->invoice_model->get_timesheet($timesheet_id);
		$this->load->view('timesheet_row', isset($data) ? $data : NULL);
	}
	
	function by_client($user_id) {
		return $this->invoice_model->check_client_invoice($user_id);
	}
	
	function create($user_id) {
		$invoice_id = $this->by_client($user_id);
		if ($invoice_id == 0) {
			# Create invoice
			$invoice_data = array(
				'client_id' => $user_id,
				'title' => 'Services Rended',
				'issued_date' => date('Y-m-d')
			);
			$invoice_id = $this->invoice_model->add_client_invoice($invoice_data);
			$data_jobs = array();
			$total = 0;
			# Insert invoice items
			$jobs = $this->invoice_model->get_client_invoice($user_id);
			foreach($jobs as $job) {
				$item_data = array(
					'invoice_id' => $invoice_id,
					'job_id' => $job['job_id'],
					'include_timesheets' => 1,
					'title' => $job['name'],
					'tax' => GST_YES,
					'amount' => $job['total_amount']
				);
				$data_jobs[] = array(
					'value' => $job['job_id'],
					'label' => $job['name']
				);
				$total += $job['total_amount'];
				$this->invoice_model->add_invoice_item($item_data);
			}
			$this->invoice_model->update_invoice($invoice_id, array(
				'jobs' => serialize($data_jobs),
				'total_amount' => $total
			));
			
		} 
		redirect('invoice/edit/' . $invoice_id);	
	}
	
	function edit($invoice_id) {
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice'] = $invoice;
		$data['client'] = modules::run('client/get_client', $invoice['client_id']);
		$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		$this->load->view('invoice_view', isset($data) ? $data : NULL);
	}
	
	function job_timesheets($job_id) {
		return $this->invoice_model->get_job_timesheets($job_id);
	}
	
}