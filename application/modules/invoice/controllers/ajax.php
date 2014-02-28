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
		$this->load->view('create/temporary_list_view', isset($data) ? $data : NULL);
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
		$this->load->view('source/clients_list_view', isset($data) ? $data : NULL);
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
		$data['jobs'] = $this->invoice_model->get_client_jobs($user_id);
		$this->load->view('source/client_jobs_list_view', isset($data) ? $data : NULL);
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
		$this->load->view('source/client_job_timesheets_list', isset($data) ? $data : NULL);
	}	
	
	/**
	*	@name: row_client_job
	*	@desc: ajax function to load the row (tr) of client job
	*	@access: public
	*	@oaram: (POST) job_id
	*	@return: (html) view of the row (tr)
	*/
	function row_client_job() {
		$job_id = $this->input->post('job_id');
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('source/client_job_row_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: ajax function to load the row (tr) of timesheet
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (html) view of the row (tr)
	*/
	function row_timesheet() {
		echo modules::run('invoice/row_timesheet', $this->input->post('timesheet_id'));
	}
	
	/**
	*	@name: row_job
	*	@desc: ajax function to load the row (tr) of job
	*	@access: public
	*	@param: (POST) job_id
	*	@return: (html) view of the row (tr)
	*/
	function row_job() {
		echo modules::run('invoice/row_job', $this->input->post('job_id'));
	}
	
	/**
	*	@name: add_job_to_invoice
	*	@desc: ajax function to add a job to the invoice
	*	@access: public
	*	@param: (POST) job_id
	*	@return: json encode of array of time sheet id
	*/
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
	
	/**
	*	@name: add_timesheet_to_invoice
	*	@desc: ajax function to add a time sheet to the invoice
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (boolean)
	*/
	function add_timesheet_to_invoice() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->invoice_model->add_timesheet_to_invoice($timesheet_id);
	}
	
	/**
	*	@name: remove_job_from_invoice
	*	@desc: ajax function to remove a job from the invoice
	*	@access: public
	*	@param: (POST) job_id
	*			(boolean) apply_all
	*	@return: json encode of array of time sheet id
	*/
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
	
	/**
	*	@name: remove_timesheet_from_invoice
	*	@desc: ajax function to remove a time sheet from the invoice
	*	@access: public
	*	@param: (POST) timesheet_id
	*	@return: (boolean)
	*/
	function remove_timesheet_from_invoice() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->invoice_model->remove_timesheet_from_invoice($timesheet_id);
	}
	
	
	/**
	*	@name: list_items
	*	@desc: ajax function to list all items of the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (html) view of the items list
	*/
	function list_items() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice'] = $invoice;
		$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		$this->load->view('create/items_list', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: get_total
	*	@desc: ajax function to get the total charge details
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (html) view of the total charge details
	*/
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
		$this->load->view('create/charge_details', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: add_item
	*	@desc: add new item to the invoice
	*	@access: public
	*	@param: (POST) array of data
	*	@return: (void)
	*/
	function add_item() {
		$data = $this->input->post();
		if ($data['tax'] == GST_ADD) {
			$data['amount'] = $data['amount'] * 1.1;
		}
		$this->invoice_model->add_invoice_item($data);
	}
	
	/**
	*	@name: check_breakdown
	*	@desc: ajax function to check if the invoice can be break down or not
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (string) "true" or "false"
	*/
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
	*	@name: show_breakdown
	*	@desc: ajax function to enable/disable break down items of the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (html) view of the break down item list
	*/
	function show_breakdown() {
		$invoice_id = $this->input->post('invoice_id');
		if ($this->input->post('show') == "true") {
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
			$this->invoice_model->update_invoice($invoice_id, array('breakdown' => 1));
			$this->load->view('create/breakdown', isset($data) ? $data : NULL);
		} else {			
			$this->invoice_model->update_invoice($invoice_id, array('breakdown' => 0));
		}
	}
	
	/**
	*	@name: delete_item
	*	@desc: ajax function to delete an item from the invoice
	*	@access: public
	*	@param: (POST) item_id
	*	@return: (boolean) 
	*/
	function delete_item() {
		return $this->invoice_model->delete_invoice_item($this->input->post('item_id'));
	}
	
	/**
	*	@name: delete_invoice
	*	@desc: ajax function to delete the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (void)
	*/
	function delete_invoice() {
		$invoice_id = $this->input->post('invoice_id');
		$this->invoice_model->delete_invoice_items($invoice_id);
		$this->invoice_model->delete_invoice($invoice_id);
	}
	
	/**
	*	@name: search_invoices
	*	@desc: ajax function to search invoices
	*	@access: public
	*	@param: (POST) (array) of parameters
	*	@return: (array) of invoice objects
	*/
	function search_invoices() {
		$params = $this->input->post();
		$data['invoices'] = $this->invoice_model->search_invoices($params);
		$this->load->view('search/results_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: mark_as_paid
	*	@desc: ajax function to mark an invoice as paid
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (html) menu dropdown status of the invoice
	*/
	function mark_as_paid() {
		$invoice_id = $this->input->post('invoice_id');
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, array(
			'status' => INVOICE_PAID,
			'paid_on' => date('Y-m-d H:i:s')
		));
		# Update timesheet
		$this->invoice_model->mark_paid_timesheets($invoice_id);
		echo modules::run('invoice/menu_dropdown_status', $invoice_id);
	}
	
	/**
	*	@name: mark_as_unpaid
	*	@desc: ajax function to mark an invoice as unpaid
	*	@access: public
	*	@param: (POST) invoice_id
	*	@return: (html) menu dropdown status of the invoice
	*/
	function mark_as_unpaid() {
		$invoice_id = $this->input->post('invoice_id');
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, array('status' => INVOICE_GENERATED));
		# Update timesheet
		$this->invoice_model->mark_unpaid_timesheets($invoice_id);
		echo modules::run('invoice/menu_dropdown_status', $invoice_id);
	}
}