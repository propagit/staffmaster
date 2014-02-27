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
	
	/**
	*	@name: list_temp_invoices
	*	@desc: ajax function to get the list of temporary client invoices
	*	@access: public
	*	@param: (void)
	*	@return: (html) list of temporary client invoices
	*/
	function list_temp_invoices() {
		$data['invoices'] = $this->invoice_model->get_invoiced_clients();
		$this->load->view('invoices_temp_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: list_clients
	*	@desc: ajax function to get the list of client with batched timesheets
	*	@access: public
	*	@param: (void)
	*	@return: (html) layout of list clients
	*/
	function list_clients() {
		$data['clients'] = $this->invoice_model->get_clients();
		$this->load->view('clients_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: load_client_jobs
	*	@desc: ajax function to load all billable jobs of client
	*	@access: public
	*	@param: (POST) user_id
	*	@return: (html) layout of list of jobs by a client
	*/
	function load_client_jobs() {
		$user_id = $this->input->post('user_id');
		$data['user_id'] = $user_id;
		$data['jobs'] = $this->invoice_model->get_jobs($user_id);
		$this->load->view('client_jobs_list_view', isset($data) ? $data : NULL);
	}
	
	function row_client_job() {
		echo modules::run('invoice/row_client_job', $this->input->post('job_id'));
	}
	
	/**
	*	@name: load_job_timesheets
	*	@desc: ajax function to load all timesheets in a job
	*	@access: public
	*	@param: (POST) job_id
	*	@return: (html) layout of list of timesheets in a job
	*/
	function load_job_timesheets() {
		$job_id = $this->input->post('job_id');
		$job = $this->invoice_model->get_job($job_id);
		$data['job'] = $job;
		$data['client'] = modules::run('client/get_client', $job['client_id']);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('job_timesheets_list', isset($data) ? $data : NULL);
	}
	
	function row_timesheet() {
		echo modules::run('invoice/row_timesheet', $this->input->post('timesheet_id'));
	}
	
	/**
	*
	*
	*
	*
	*
	*/
	function row_timesheets_job() {
		echo modules::run('invoice/row_job', $this->input->post('job_id'));
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
	
	
	/**
	*
	*
	*
	*
	*
	*/
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
		$data['invoice'] = $this->invoice_model->get_invoice($invoice_id);
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
	
	/**
	*
	*
	*
	*
	*
	*/
	function show_breakdown() {
		$invoice_id = $this->input->post('invoice_id');
		if ($this->input->post('show') == "true") {
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
			$this->invoice_model->update_invoice($invoice_id, array('breakdown' => 1));
			$this->load->view('invoice_breakdown', isset($data) ? $data : NULL);
		} else {			
			$this->invoice_model->update_invoice($invoice_id, array('breakdown' => 0));
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
	
	
	function search_invoices() {
		$params = $this->input->post();
		$data['invoices'] = $this->invoice_model->search_invoices($params);
		$this->load->view('search_results', isset($data) ? $data : NULL);
	}
	
	function mark_as_paid() {
		$invoice_id = $this->input->post('invoice_id');
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, array('status' => INVOICE_PAID));
		# Update timesheet
		$this->invoice_model->mark_paid_timesheets($invoice_id);
		echo modules::run('invoice/menu_dropdown_status', $invoice_id);
	}
	
	function mark_as_unpaid() {
		$invoice_id = $this->input->post('invoice_id');
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, array('status' => INVOICE_GENERATED));
		# Update timesheet
		$this->invoice_model->mark_unpaid_timesheets($invoice_id);
		echo modules::run('invoice/menu_dropdown_status', $invoice_id);
	}
}