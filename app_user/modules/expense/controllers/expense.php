<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Invoice
 * @author: namnd86@gmail.com
 */

class Expense extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('expense_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'view':
					$this->view_expense($param);
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
	
	function search_form() {
		$this->load->view('search_form_view', isset($data) ? $data : NULL);
	}
	
	function view_expense($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function row_view($expense_id) {
		$data['expense'] = $this->expense_model->get_detailed_expense($expense_id);
		$this->load->view('row_view', isset($data) ? $data : NULL);
	}
	
	function field_select_status($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => EXPENSE_UNPAID, 'label' => 'Unpaid'),
			array('value' => EXPENSE_PAID, 'label' => 'Paid'),
			array('value' => EXPENSE_DELETED, 'label' => 'Deleted')
		);
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	function menu_dropdown_status($expense_id) {
		$data['expense'] = $this->expense_model->get_expense($expense_id);
		$this->load->view('menu_dropdown_status', isset($data) ? $data : NULL);
	}
	
	function field_select_export_templates($field_name, $field_value = null) {
		$this->load->model('export/export_model');
		$data['single'] = $this->export_model->get_templates('expense', 'single');
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('field_select_export_templates', isset($data) ? $data : NULL);
	}
}