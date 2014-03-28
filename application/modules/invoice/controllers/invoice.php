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
		$this->load->model('expense/expense_model');
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
			
			
			$timesheets = $this->invoice_model->get_job_timesheets($job['job_id'], INVOICE_READY);
			foreach($timesheets as $timesheet) {
				$expenses = $this->expense_model->get_timesheet_expenses($timesheet['timesheet_id']);
				
				if (count($expenses) > 0) {
					foreach($expenses as $exp) {
						$item_data = array(
							'invoice_id' => $invoice_id,
							'job_id' => $job['job_id'],
							'expense_id' => $exp['expense_id'],
							'title' => $exp['description'],
							'tax' => $exp['tax'],
							'amount' => $exp['client_cost']
						);
						$total += $exp['client_cost'];
						$this->invoice_model->add_invoice_item($item_data);
					}
				}	
			}
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
		$data['company_profile'] = modules::run('setting/company_profile');
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
	function download($invoice_id,$redirect = true) {
		# As PDF creation takes a bit of memory, we're saving the created file in /uploads/pdf/
		$filename = "invoice_" . $invoice_id;
		if(!file_exists('/uploads/pdf/'.$filename.'.pdf')){
			$pdfFilePath = "./uploads/pdf/$filename.pdf";
			
			$dir = './uploads/pdf/';
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			 
			ini_set('memory_limit','32M'); # boost the memory limit if it's low 
			
			$invoice = $this->invoice_model->get_invoice($invoice_id);
			$data['invoice'] = $invoice;
			$data['client'] = modules::run('client/get_client', $invoice['client_id']);
			$data['items'] = $this->invoice_model->get_invoice_items($invoice_id);
			$data['company_profile'] = modules::run('setting/company_profile');
			$html = $this->load->view('create/download_view', isset($data) ? $data : NULL, true); 
	
			
					
			$this->load->library('pdf');
			$pdf = $this->pdf->load(); 			
			$stylesheet = file_get_contents('./assets/css/pdf.css');
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, 'F'); // save to file 
		}
		if($redirect){ 
			redirect("./uploads/pdf/$filename.pdf"); 
		}
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
		$data['company_profile'] = modules::run('setting/company_profile');
		$this->load->view('create/generated_view', isset($data) ? $data : NULL); 
	}
	
	function row_client_job($job_id) {
		$data['job'] = $this->invoice_model->get_job($job_id);
		$data['timesheets'] = $this->invoice_model->get_timesheets($job_id);
		$this->load->view('source/client_job_row_view', isset($data) ? $data : NULL);
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
	
	function field_select_export_templates($field_name, $field_value = null) {
		$object = 'invoice';
		$this->load->model('export/export_model');
		$data['single'] = $this->export_model->get_templates($object, 'single');		
		$data['batched'] = $this->export_model->get_templates($object, 'batched');
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('search/field_select_export_templates', isset($data) ? $data : NULL);
	}
	/**
	*	@name: email_invoice
	*	@desc: function to email invoice to client
	*	@access: public
	*	@param: ([array]) email parameters such as body of email, user id, invoice id
	*	
	*/
	function email_invoice($params)
	{
		$this->load->model('user/user_model');
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		
		//get post data from params
		$selected_module_ids = $params['selected_module_ids'];
		$email_body = $params['email_body'];
		$selected_user_ids = $params['selected_user_ids'];
		$email_template_id = $params['email_template_select'];
		if($selected_module_ids){
			$invoice_ids = json_decode($selected_module_ids);
			foreach($invoice_ids as $invoice_id){
				//get template info
				$template_info = $this->email_template_model->get_template($email_template_id);	
				$company = $this->setting_model->get_profile();
				//get invoice details
				$invoice = $this->invoice_model->get_invoice($invoice_id);
				//get user
				$user = $this->user_model->get_user($invoice['client_id']);
				//get receiver object
				$email_obj_params = array(
										'template_id' => $template_info->email_template_id,
										'user_id' => $invoice['client_id'],
										'company' => $company,
										'invoice_id' => $invoice_id
									);	
				$obj = modules::run('email/get_email_obj',$email_obj_params);
				//check file for attachment
				if(!file_exists('/uploads/pdf/invoice_'.$invoice_id.'.pdf')){
					//create attachment	
					modules::run('invoice/download',$invoice_id,false);
				}
				$email_data = array(
									'to' => $user['email_address'],
									'from' => $company['email_c_email'],
									'from_text' => $company['email_c_name'],
									'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
									'message' => modules::run('email/format_template_body',$email_body,$obj),
									'attachment' => realpath(__DIR__.'/../../../../uploads/pdf/invoice_'.$invoice_id.'.pdf')	
								);
				modules::run('email/send_email',$email_data);
			}
		}
		echo 'sent';
	}
	
}