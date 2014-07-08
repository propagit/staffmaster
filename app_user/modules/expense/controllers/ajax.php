<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('expense_model');
	}
	
	
	function search_expenses() {
		$params = $this->input->post();
		$data['expenses'] = $this->expense_model->search_expenses($params);
		$this->load->view('table_list_view', isset($data) ? $data : NULL);
	}
	
	function update_expense_status() {
		$expense_id = $this->input->post('expense_id');
		$status = $this->input->post('status');
		$data = array('status' => $status);
		if ($status == EXPENSE_PAID) {
			$data['paid_on'] = date('Y-m-d H:i:s');
		} else {
			$data['paid_on'] = NULL;
		}
		$this->expense_model->update_expense($expense_id, $data);
		echo modules::run('expense/row_view', $expense_id);
	}
	
	function load_export_modal($ids) {
		$data['ids'] = urldecode($ids);
		$this->load->view('export_modal_view', isset($data) ? $data : NULL);
	}
	
	function exporting() {
		$input = $this->input->post();
		$ids = $input['ids'];
		$ids = explode(',', $ids);
		$export_id = $this->input->post('export_id');
		if ($export_id == '') {
			return;
		}
		# Mark all expenses as paid
		if (isset($input['mark_as_paid'])) {
			foreach($ids as $expense_id) {
				$expense = $this->expense_model->get_expense($expense_id);
				if ($expense['status'] != EXPENSE_PAID) {
					$this->expense_model->update_expense($expense_id, array(
						'status' => EXPENSE_PAID,
						'paid_on' => date('Y-m-d H:i:s')
					));
				}			
			}
		}
		
		$file_name = $this->_export_expense($ids, $export_id);
		echo $file_name;
	}
	
	private function _export_expense($ids, $export_id) {
		
		$fields = modules::run('export/get_fields', $export_id);
		
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("StaffBooks");
		$objPHPExcel->getProperties()->setLastModifiedBy("StaffBooks");
		$objPHPExcel->getProperties()->setTitle("Staff Expense");
		$objPHPExcel->getProperties()->setSubject("Staff Expense");
		$objPHPExcel->getProperties()->setDescription("Expense Excel file, generated from StaffBooks.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 0;
		$row = 1;
		foreach($fields as $field) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $field['title']);
			$i++;
		}
		$i = 0;
		foreach($ids as $expense_id) {
			$expense = $this->expense_model->get_export_expense($expense_id);
			$row++;
			foreach($fields as $field) {
				$value = $field['value']; # Convert $field, $timesheet
				$tax = $expense['tax'];
				$amount = $expense['staff_cost'];
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
				
				$value = str_replace('{tax_amount}', '$' . money_format('%i', $tax_amount), $value);
				$value = str_replace('{inc_tax_amount}', '$' . money_format('%i', $inc_tax_amount), $value);
				$value = str_replace('{ex_tax_amount}', '$' . money_format('%i', $ex_tax_amount), $value);
				$value = str_replace('{staff_first_name}', $expense['first_name'], $value);
				$value = str_replace('{staff_last_name}', $expense['last_name'], $value);
				$value = str_replace('{job_date}', date('d/m/Y', strtotime($expense['job_date'])), $value);
				if ($expense['paid_on'] != NULL) {
					$value = str_replace('{paid_on}', date('d/m/Y', strtotime($expense['paid_on'])), $value);
				} else {
					$value = str_replace('{paid_on}', '', $value);
				}
				
				$value = str_replace('{job_name}', $expense['job_name'], $value);
				$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);
				$i++;
			}
			$i=0;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('expense');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = 'staff_expense_' . time() . ".csv";
		$objWriter->save(EXPORTS_PATH . "/expense/" . $file_name);
		return $file_name;
	} 
}