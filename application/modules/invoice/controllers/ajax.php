<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
	}
	
	function list_clients() {
		$data['clients'] = $this->invoice_model->get_clients();
		$this->load->view('clients_list_view', isset($data) ? $data : NULL);
	}
	
	function load_client_jobs() {
		$user_id = $this->input->post('user_id');
		$data['user_id'] = $user_id;
		$data['jobs'] = $this->invoice_model->get_jobs($user_id);
		$this->load->view('client_jobs_list_view', isset($data) ? $data : NULL);
	}
	
	function row_client_job() {
		echo modules::run('invoice/row_client_job', $this->input->post('job_id'));
	}
	
	
	function load_job_timesheets() {
		$job_id = $this->input->post('job_id');
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('job_timesheets_list', isset($data) ? $data : NULL);
	}
	
	function row_timesheet() {
		echo modules::run('invoice/row_timesheet', $this->input->post('timesheet_id'));
	}
	
	function row_timesheets_job() {
		echo modules::run('invoice/row_timesheets_job', $this->input->post('job_id'));
	}
	
	function add_job_to_invoice() {
		$job_id = $this->input->post('job_id');
		$this->invoice_model->add_job_to_invoice($job_id);
		if ($this->input->post('apply_all')) {
			$timesheets = $this->invoice_model->get_timesheets($job_id);
			$output = array();
			foreach($timesheets as $timesheet) {
				$output[] = $timesheet['timesheet_id'];
			}
			echo json_encode($output);
		}
		
	}
	
	function add_timesheet_to_invoice() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->invoice_model->add_timesheet_to_invoice($timesheet_id);
	}
	
	function remove_job_from_invoice() {
		$job_id = $this->input->post('job_id');
		$this->invoice_model->remove_job_from_invoice($job_id);
		if ($this->input->post('apply_all')) {
			$timesheets = $this->invoice_model->get_timesheets($job_id);
			$output = array();
			foreach($timesheets as $timesheet) {
				$output[] = $timesheet['timesheet_id'];
			}
			echo json_encode($output);
		}
	}
	
	function remove_timesheet_from_invoice() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->invoice_model->remove_timesheet_from_invoice($timesheet_id);
	}
	
	function list_invoices() {
		$data['invoices'] = $this->invoice_model->get_invoiced_clients();
		$this->load->view('invoices_list_view', isset($data) ? $data : NULL);
	}
	
	function list_items() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice'] = $invoice;
		$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		$this->load->view('invoice_items_list', isset($data) ? $data : NULL);
	}
	
	function get_total() {
		$invoice_id = $this->input->post('invoice_id');
		$total = 0;
		$gst = 0;
		$items = $this->invoice_model->get_invoice_items($invoice_id);
		foreach($items as $item) {
			$total += $item['amount'];
			if ($item['tax']) {
				$gst += $item['amount'] / 11;
			}
		}
		$this->invoice_model->update_invoice($invoice_id, array('gst' => $gst,'total_amount' => $total));
		$data['total'] = $total;
		$data['gst'] = $gst;
		$this->load->view('invoice_charge_details', isset($data) ? $data : NULL);
	}
	
	function add_item() {
		$data = $this->input->post();
		if ($data['tax'] == GST_ADD) {
			$data['amount'] = $data['amount'] * 1.1;
		}
		$this->invoice_model->add_invoice_item($data);
	}
	
	function check_breakdown() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$jobs = unserialize($invoice['jobs']);
		$items = $this->invoice_model->get_invoice_items($invoice_id);
		foreach($items as $key => $item) {
			if (!$item['include_timesheets']) {
				unset($items[$key]);
			}
		}
		if (count($items) == count($jobs)) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	function show_breakdown() {
		$invoice_id = $this->input->post('invoice_id');
		if ($this->input->post('show') == "true") {
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
			$this->load->view('invoice_breakdown', isset($data) ? $data : NULL);
		}
	}
	
	function delete_item() {
		$this->invoice_model->delete_invoice_item($this->input->post('item_id'));
	}
	
	function delete_invoice() {
		$invoice_id = $this->input->post('invoice_id');
		$this->invoice_model->delete_invoice_items($invoice_id);
		$this->invoice_model->delete_invoice($invoice_id);
	}
	
}