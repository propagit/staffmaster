<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Invoice
 * @author: namnd86@gmail.com
 */

class Invoice_client extends MX_Controller {

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
					echo modules::run('invoice/main_view');
				break;
		}
		
	}
	
	function download($invoice_id)
	{
		if($invoice_id){
			redirect(base_url().UPLOADS_URL."/pdf/invoice_$invoice_id.pdf"); 	
		}else{
			redirect('invoice');	
		}
	}

}