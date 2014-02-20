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
	
}