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
			case 'generate':
					$this->generate($param);
				break;
			case 'view':
					$this->view($param);
				break;
			case 'search':
					$this->search();
				break;
			case 'download':
					$this->download($param);
				break;
			default:
					$this->main_view();
				break;
		}
		
	}
	
	/**
	*	@name: main_view
	*	@desc: load the main layout of the invoice page
	*	@access: public
	*	@param: (void)
	*	@return: (html) load main layout of the invoice page
	*/
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: create_view
	*	@desc: view of create invoice tab
	*	@access: public
	*	@param: (void)
	*	@return: (html) load main layout of the create invoice tab
	*/
	function create_view() {
		$this->load->view('create_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: search_form
	*	@desc: view of search invoice tab
	*	@access: public
	*	@param: (void)
	*	@return: (html) load search form of the search invoice tab
	*/
	function search_form() {
		$this->load->view('search_form', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: create
	*	@desc: create the invoice record for a client
	*	@access: public
	*	@param: (int) $user_id
	*	@return: (void) redirect to (html) invoice page
	*/
	function create($user_id) {
		$invoice_id = $this->invoice_model->check_client_invoice($user_id);
		# If found invoice, delete it
		if ($invoice_id) {
			$this->invoice_model->delete_invoice_items($invoice_id);
			$this->invoice_model->delete_invoice($invoice_id);
		}
		
		# Create invoice
		$invoice_data = array(
			'client_id' => $user_id,
			'title' => 'Services Rended',
			'issued_date' => date('Y-m-d H:i:s'),
			'due_date' => date('Y-m-d H:i:s', time() + 30*24*60*60)
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
			
		redirect('invoice/edit/' . $invoice_id);	
	}
	
	/**
	*	@name: edit
	*	@desc: edit invoice page
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (html) edit invoice page
	*/
	function edit($invoice_id) {
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		# If invoice is generated, cannot edit anymore, go to view page
		if ($invoice['status'] == INVOICE_GENERATED) {
			redirect('invoice/view/' . $invoice_id);
		}
		$data['invoice'] = $invoice;
		$data['client'] = modules::run('client/get_client', $invoice['client_id']);
		if ($invoice['breakdown']) {
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		}
		$this->load->view('create/edit_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: generate
	*	@desc: generate the invoice and link timesheets to the invoice
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (void) redirect to view invoice page
	*/
	function generate($invoice_id) {
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		# Update invoice status
		$user = $this->session->userdata('user_data');
		$this->invoice_model->update_invoice($invoice_id, array(
			'status' => INVOICE_GENERATED,
			'issued_by' => $user['user_id']
		));
		$this->invoice_model->generate_invoice_timesheets($invoice['client_id'], $invoice_id);
		redirect('invoice/view/' . $invoice_id);
	}
	
	/**
	*	@name: download
	*	@desc: generate and download the pdf
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (void)
	*/
	function download($invoice_id) {
		# As PDF creation takes a bit of memory, we're saving the created file in /uploads/pdf/
		$filename = "invoice_" . $invoice_id;
		$pdfFilePath = "./uploads/pdf/$filename.pdf";
		
		 
		ini_set('memory_limit','32M'); # boost the memory limit if it's low 
		
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice'] = $invoice;
		$data['client'] = modules::run('client/get_client', $invoice['client_id']);
		$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		$html = $this->load->view('create/download_view', isset($data) ? $data : NULL, true); 
		
				
		$this->load->library('pdf');
		$pdf = $this->pdf->load(); 			
		$stylesheet = file_get_contents('./assets/css/pdf.css');
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($pdfFilePath, 'F'); // save to file 
		 
		redirect("./uploads/pdf/$filename.pdf"); 
	}
	
	/**
	*	@name: view
	*	@desc: view of the single invoice
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (html) view invoice page 
	*/
	function view($invoice_id) {
		$invoice = $this->invoice_model->get_invoice($invoice_id);
		$data['invoice'] = $invoice;
		$data['client'] = modules::run('client/get_client', $invoice['client_id']);
		$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
		$this->load->view('create/generated_view', isset($data) ? $data : NULL); 
	}
	
	
	/**
	*	@name: row_job
	*	@desc: view of row of a job
	*	@access: public
	*	@param: (int) $job_id
	*	@return: (html) row (tr) of the job
	*/
	function row_job($job_id) {
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('source/job_row_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: view of row of a timesheet
	*	@access: public
	*	@param: (int) $timesheet_id
	*	@return: (html) row (tr) of a job
	*/
	function row_timesheet($timesheet_id) {
		$data['timesheet'] = $this->invoice_model->get_timesheet($timesheet_id);
		$this->load->view('source/timesheet_row_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: get_job_timesheets
	*	@desc: get invoiced timesheets of an invoiced job
	*	@access: public
	*	@param: (int) $job_id
	*			(int) $status
	*	@return: (array) of time sheet objects
	*/
	function get_job_timesheets($job_id, $status) {
		return $this->invoice_model->get_job_timesheets($job_id, $status);
	}
	
	/**
	*	@name: field_select_status
	*	@desc: custom field select status of invoice
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected value of field
	*			- $size (optional): size 
	*	@return: custom select input field
	*/
	function field_select_status($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => INVOICE_GENERATED, 'label' => 'Unpaid'),
			array('value' => INVOICE_PAID, 'label' => 'Paid')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: menu_dropdown_status
	*	@desc: generate the dropdown menu of invoice status
	*	@access: public
	*	@param: (int) $invoice_id
	*	@return: (html) dropdown menu of invoice status
	*/
	function menu_dropdown_status($invoice_id) {
		$data['invoice'] = $this->invoice_model->get_invoice($invoice_id);
		$this->load->view('search/menu_dropdown_status', isset($data) ? $data : NULL);
	}
	
}