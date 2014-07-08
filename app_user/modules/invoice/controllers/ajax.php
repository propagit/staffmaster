<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: invoice
*	@controller: ajax
*/

class Ajax extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('invoice_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}
	
	function create_manual_invoice() {
		$client_id = $this->input->post('client_id');
		# Create invoice
		$invoice_data = array(
			'client_id' => $client_id,
			'title' => 'Manual Invoice',
			'issued_date' => date('Y-m-d H:i:s'),
			'due_date' => date('Y-m-d H:i:s', time() + 30*24*60*60)
		);
		$invoice_id = $this->invoice_model->add_client_invoice($invoice_data);
		
		
		$data_jobs = array();
		# Insert invoice items
		$jobs = $this->invoice_model->get_client_invoice($client_id);
		foreach($jobs as $job) {
			$data_jobs[] = array(
				'value' => $job['job_id'],
				'label' => $job['name']
			);
		}
		$this->invoice_model->update_invoice($invoice_id, array(
			'jobs' => serialize($data_jobs)
		));
		
		echo $invoice_id;
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
		$this->load->view('source/client_job_timesheets_list_view', isset($data) ? $data : NULL);
	}	
	
	/**
	*	@name: row_client_job
	*	@desc: ajax function to load the row (tr) of client job
	*	@access: public
	*	@oaram: (POST) job_id
	*	@return: (html) view of the row (tr)
	*/
	function row_client_job() {
		echo modules::run('invoice/row_client_job', $this->input->post('job_id'));
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
	
	function delete_invoices() {
		$invoice_ids = $this->input->post('invoices');
		foreach($invoice_ids as $invoice_id)
		{
			$this->invoice_model->delete_invoice($invoice_id);
		}
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
		if ($this->is_client)
		{
			$params['client_id'] = $this->user['user_id'];
		}
		$data['invoices'] = $this->invoice_model->search_invoices($params);
		$data['total_invoices'] = $this->invoice_model->search_invoices($params,true);
		$data['current_page'] = $this->input->post('current_page',true);
		$data['is_client'] = $this->is_client;
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
	/**
	*	@name: edit_client_invoice_title 
	*	@desc: ajax function to edit template client invoice for TITLE of the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_title() {
		$invoice_id = $this->input->post('pk');
		$title = $this->input->post('value');
		$data = array('title' => $title);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_issued_date
	*	@desc: ajax function to edit template client invoice for Issued Date of the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_issued_date() {
		$invoice_id = $this->input->post('pk');
		$issued_date = $this->input->post('value');
		$data = array('issued_date' => $issued_date);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_due_date
	*	@desc: ajax function to edit template client invoice for Due Date of the invoice
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_due_date() {
		$invoice_id = $this->input->post('pk');
		$due_date = $this->input->post('value');
		$data = array('due_date' => $due_date);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_number
	*	@desc: ajax function to edit template client invoice for Invoice Number
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_number() {
		$invoice_id = $this->input->post('pk');
		$invoice_number = $this->input->post('value');
		$data = array('invoice_number' => $invoice_number);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_number
	*	@desc: ajax function to edit template client invoice for Invoice Number
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_po_number() {
		$invoice_id = $this->input->post('pk');
		$data = array('po_number' => $this->input->post('value'));
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	
	/**
	*	@name: edit_client_invoice_company_name
	*	@desc: ajax function to edit template client invoice for profile company name
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_company_name() {
		$invoice_id = $this->input->post('pk');
		$profile_company_name = $this->input->post('value');
		$data = array('profile_company_name' => $profile_company_name);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_company_abn
	*	@desc: ajax function to edit template client invoice for profile company name
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_company_abn() {
		$invoice_id = $this->input->post('pk');
		$profile_abn = $this->input->post('value');
		$data = array('profile_abn' => $profile_abn);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_company_name
	*	@desc: ajax function to edit template client invoice for client company name
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_company_name() {
		$invoice_id = $this->input->post('pk');
		$client_company_name = $this->input->post('value');
		$data = array('client_company_name' => $client_company_name);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_invoice_profile_phone
	*	@desc: ajax function to edit template client invoice for profile company phone
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_invoice_profile_phone() {
		$invoice_id = $this->input->post('pk');
		$data = array('profile_company_phone' => $this->input->post('value'));
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_invoice_profile_email
	*	@desc: ajax function to edit template client invoice for profile company email
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_invoice_profile_email() {
		$invoice_id = $this->input->post('pk');
		$data = array('profile_company_email' => $this->input->post('value'));
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_address
	*	@desc: ajax function to edit template client invoice for client address
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_address() {
		$invoice_id = $this->input->post('pk');
		$client_address = $this->input->post('value');
		$data = array('client_address' => $client_address);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_suburb
	*	@desc: ajax function to edit template client invoice for client suburb
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_suburb() {
		$invoice_id = $this->input->post('pk');
		$client_suburb = $this->input->post('value');
		$data = array('client_suburb' => $client_suburb);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_state
	*	@desc: ajax function to edit template client invoice for client state
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_state() {
		$invoice_id = $this->input->post('pk');
		$client_state = $this->input->post('value');
		$data = array('client_state' => $client_state);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_postcode
	*	@desc: ajax function to edit template client invoice for client postcode
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_postcode() {
		$invoice_id = $this->input->post('pk');
		$client_postcode = $this->input->post('value');
		$data = array('client_postcode' => $client_postcode);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_phone
	*	@desc: ajax function to edit template client invoice for client phone
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_phone() {
		$invoice_id = $this->input->post('pk');
		$client_phone = $this->input->post('value');
		$data = array('client_phone' => $client_phone);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	/**
	*	@name: edit_client_invoice_client_email_address
	*	@desc: ajax function to edit template client invoice for client email address
	*	@access: public
	*	@param: (POST) invoice_id
	*	
	*/
	function edit_client_invoice_client_email_address() {
		$invoice_id = $this->input->post('pk');
		$client_email_address = $this->input->post('value');
		$data = array('client_email_address' => $client_email_address);
		# Update invoice
		$this->invoice_model->update_invoice($invoice_id, $data);	
		
	}
	
	function load_export_modal($ids) {
		$data['ids'] = urldecode($ids);
		$this->load->view('search/export_modal_view', isset($data) ? $data : NULL);
	}
	
	function exporting() {
		$input = $this->input->post();
		$ids = $input['ids'];
		$ids = explode(',', $ids);
		$export_id = $this->input->post('export_id');
		if ($export_id == '') {
			return;
		}
		# Mark all invoices as paid
		if (isset($input['mark_as_paid'])) {
			foreach($ids as $invoice_id) {
				$invoice = $this->invoice_model->get_invoice($invoice_id);
				if ($invoice['status'] != INVOICE_PAID) {
					$this->invoice_model->update_invoice($invoice_id, array(
						'status' => INVOICE_PAID,
						'paid_on' => date('Y-m-d H:i:s')
					));
				}			
			}
		}
		
		$file_name = $this->_export_invoices($ids, $export_id);
		echo $file_name;
	}
	
	private function _export_invoices($ids, $export_id) {
		$fields = modules::run('export/get_fields', $export_id);
		$template = modules::run('export/get_template', $export_id);
		
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("StaffBooks");
		$objPHPExcel->getProperties()->setLastModifiedBy("StaffBooks");
		$objPHPExcel->getProperties()->setTitle("Client Invoice");
		$objPHPExcel->getProperties()->setSubject("Client Invoice");
		$objPHPExcel->getProperties()->setDescription("Client Invoice Excel file, generated from StaffBooks.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 0;
		$row = 1;
		foreach($fields as $field) {
			#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $field['title']);
			
			if ($i < 26)
			{
				$letter = chr(97 + $i) . $row;
			}
			else
			{
				$letter = 'A' . chr(97 + ($i-26)) . $row;
			}
			$objPHPExcel->getActiveSheet()->SetCellValue($letter, $field['title']);
			$i++;
		}
		$i = 0;
		
		$date_format = 'd/m/Y';
		if ($template['target'] == 'shoebooks') {
			$date_format = 'M-d-Y';
		}
		foreach($ids as $invoice_id) {
			$invoice = $this->invoice_model->get_invoice($invoice_id);
			if ($template['level'] == 'invoice') {
				$row++;
				foreach($fields as $field) {
					$value = $field['value']; # Convert $field
					
					$client = modules::run('client/get_client', $invoice['client_id']);
					
					$value = str_replace('{tax_amount}', money_format('%i', $invoice['gst']), $value);
					$value = str_replace('{inc_tax_amount}', money_format('%i', $invoice['total_amount']), $value);
					$value = str_replace('{ex_tax_amount}', money_format('%i', $invoice['total_amount'] - $invoice['gst']), $value);
					$value = str_replace('{external_client_id}', $client['external_client_id'], $value);					
					$value = str_replace('{internal_client_id}', $client['user_id'], $value);
					$value = str_replace('{client_contact_name}', $client['full_name'], $value);
					$value = str_replace('{client_city}', $client['city'], $value);
					$value = str_replace('{client_country}', $client['country'], $value);
					$value = str_replace('{invoice_description}', $invoice['title'], $value);
					$value = str_replace('{client_company_name}', $invoice['client_company_name'], $value);
					$value = str_replace('{client_address}', $invoice['client_address'], $value);
					$value = str_replace('{client_suburb}', $invoice['client_suburb'], $value);
					$value = str_replace('{client_state}', $invoice['client_state'], $value);
					$value = str_replace('{client_postcode}', $invoice['client_postcode'], $value);
					$value = str_replace('{client_phone}', $invoice['client_phone'], $value);
					$value = str_replace('{client_email}', $invoice['client_email_address'], $value);
					
					
					
					$value = str_replace('{due_date}', date($date_format, strtotime($invoice['due_date'])), $value);
					$value = str_replace('{issued_date}', date($date_format, strtotime($invoice['issued_date'])), $value);
					$value = str_replace('{po_number}', $invoice['po_number'], $value);
					$value = str_replace('{invoice_id}', $invoice['invoice_id'], $value);
					
					
					if ($i < 26)
					{
						$letter = chr(97 + $i) . $row;
					}
					else
					{
						$letter = 'A' . chr(97 + ($i-26)) . $row;
					}
					$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);
					
					#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);
					$i++;
				}
				$i = 0;
			}
			else if ($template['level'] == 'item') {
				# Get all invoice item
				$invoice_items = $this->invoice_model->get_invoice_items($invoice_id);
				foreach($invoice_items as $item) {
					$row++;
					foreach($fields as $field) {
						$value = $field['value']; # Convert $field
						
						$title = $item['title'];
						if ($item['include_timesheets']) {
							$title .= ' - Staff Services';
						}
						
						
						$tax = $item['tax'];
						$amount = $item['amount'];
						$tax_amount = 0;
						$ex_tax_amount = $amount;
						$inc_tax_amount = $amount;
						if ($tax == GST_YES) {
							$tax_amount = $amount/11;
							$ex_tax_amount = $amount * 10/11;
							$inc_tax_amount = $amount;
						} else if ($tax == GST_ADD) {
							$tax_amount = $amount / 10;
							$ex_tax_amount = $amount;
							$inc_tax_amount = $amount * 1.1;
						}					
						$tax_type = modules::run('common/reverse_field_gst', $tax);
						if ($template['target'] == 'shoebooks') {
							if ($tax_amount > 0) {
								$tax_type = 2;
							} else {
								$tax_type = 3;
							}
						}
						
						$client = modules::run('client/get_client', $invoice['client_id']);
						
						$value = str_replace('{tax_amount}', money_format('%i', $tax_amount), $value);
						$value = str_replace('{inc_tax_amount}', money_format('%i', $inc_tax_amount), $value);
						$value = str_replace('{ex_tax_amount}', money_format('%i', $ex_tax_amount), $value);
						$value = str_replace('{external_client_id}', $client['external_client_id'], $value);
						$value = str_replace('{internal_client_id}', $client['user_id'], $value);
						$value = str_replace('{client_contact_name}', $client['full_name'], $value);
						$value = str_replace('{client_city}', $client['city'], $value);
						$value = str_replace('{client_country}', $client['country'], $value);
						$value = str_replace('{tax_type}', $tax_type, $value);
						$value = str_replace('{item_description}', $title, $value);
						$value = str_replace('{client_company_name}', $invoice['client_company_name'], $value);
						$value = str_replace('{client_address}', $invoice['client_address'], $value);
						$value = str_replace('{client_suburb}', $invoice['client_suburb'], $value);
						$value = str_replace('{client_state}', $invoice['client_state'], $value);
						$value = str_replace('{client_postcode}', $invoice['client_postcode'], $value);
						$value = str_replace('{client_phone}', $invoice['client_phone'], $value);
						$value = str_replace('{client_email}', $invoice['client_email_address'], $value);
						
						
						
						$value = str_replace('{due_date}', date($date_format, strtotime($invoice['due_date'])), $value);
						$value = str_replace('{issued_date}', date($date_format, strtotime($invoice['issued_date'])), $value);
						$value = str_replace('{po_number}', $invoice['po_number'], $value);
						$value = str_replace('{invoice_id}', $invoice['invoice_id'], $value);
						
						
						if ($i < 26)
						{
							$letter = chr(97 + $i) . $row;
						}
						else
						{
							$letter = 'A' . chr(97 + ($i-26)) . $row;
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);
						
						#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);
						$i++;
					}
					$i = 0;
				}
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('invoice');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = 'client_invoices_' . time() . ".csv";
		$objWriter->save(EXPORTS_PATH . "/invoice/" . $file_name);
		return $file_name;
	}
	
	/**
	*	@name: email_invoice
	*	@desc: ajax function to email invoice to client
	*	@access: public
	*	@param: (POST) invoice_id or invoice ids
	*	
	*/
	function email_invoice()
	{
		$params = $this->input->post();
		echo modules::run('invoice/email_invoice',$params);	
	}
}