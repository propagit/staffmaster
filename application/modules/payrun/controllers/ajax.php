<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrun_model');
		$this->load->model('expense/expense_model');
	}
	
	/**
	*	@name: list_staffs
	*	@desc: ajax function to get the list of staff with batched timesheets
	*	@access: public
	*	@param: (void)
	*	@return: (html) main layout of list pay runs 
	*/
	function list_staffs() {
		$data['staffs'] = $this->payrun_model->get_staffs();
		$this->load->view('source/staffs_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: get_payrun_stats
	*	@desc: ajax function to get the stats of pay run
	*	@access: public
	*	@param: (void)
	*	@return: (html) view of pay run stats
	*/
	function get_payrun_stats() {
		$this->load->view('create/stats', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: set_filter
	*	@desc: ajax function to set filter for list pay runs and save to sessions
	*	@access: public
	*	@param: (via POST) 
	*		- name
	*		- value
	*	@return: (void)
	*/
	function set_filter() {
		$this->session->set_userdata('prf_' . $this->input->post('name'), $this->input->post('value'));
	}
	
	function select_payrun_staff($user_id, $checked) {
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		foreach($timesheets as $timesheet) {
			$this->select_payrun_timesheet($timesheet['timesheet_id'], $checked);
		}
	}
	
	function select_payrun_timesheet($timesheet_id, $checked) {
		$timesheets = $this->session->userdata('payrun_timesheets');
		if ($checked == "true") {
			if (!in_array($timesheet_id, $timesheets)) {
				$timesheets[] = $timesheet_id;
			}
		}
		else {
			if (in_array($timesheet_id, $timesheets)) {
				unset($timesheets[array_search($timesheet_id, $timesheets)]);
			}
		}
		$this->session->set_userdata('payrun_timesheets', $timesheets);
	}
	
	/**
	*	@name: row_timesheets_staff
	*	@desc: ajax function to display the row (tr) content of batched staff
	*	@access: public
	*	@param: (via POST)
	*		- (int) user_id
	*		- (boolean) expanded
	*	@return: (html) the row (tr) of batched staff
	*/
	function row_timesheets_staff() {
		echo modules::run('payrun/row_batched_staff', $this->input->post('user_id'), $this->input->post('expanded'));
	}
	
	/**
	*	@name: row_timesheet
	*	@desc: ajax function to display the row (tr) content of single timesheet
	*	@access: public
	*	@param: (via POST)
	*		- (int) timesheet_id
	*		- (int) user_id
	*	@return: (html) the row (tr) of single timesheet
	*/
	function row_timesheet() {
		echo modules::run('payrun/row_timesheet', $this->input->post('timesheet_id'), $this->input->post('user_id'));
	}
	
	/**
	*	@name: process_staff_payruns
	*	@desc: ajax function to add all timesheets of staff to payrun
	*	@access: public
	*	@param: (POST) user_id
	*	@return: json encode of array of all timesheet id
	*/
	function process_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->process_staff_payruns($user_id);
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		$output = array();
		foreach($timesheets as $timesheet)
		{
			$output[] = $timesheet['timesheet_id'];
		}
		echo json_encode($output);
	}
	
	function unprocess_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$this->payrun_model->unprocess_staff_payruns($user_id);
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		$output = array();
		foreach($timesheets as $timesheet)
		{
			$output[] = $timesheet['timesheet_id'];
		}
		echo json_encode($output);
	}
	
	function process_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->process_payrun($timesheet_id);
	}
	
	function unprocess_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->unprocess_payrun($timesheet_id);
	}
	
	function expand_staff_timehsheets() {
		$user_id = $this->input->post('user_id');
		$parent = modules::run('payrun/row_batched_staff', $user_id, true);
		$children = modules::run('payrun/row_timesheets_staff', $user_id);
		echo json_encode(array(
			'parent' => $parent,
			'children' => $children
		));
	}
	
	function revert_staff_payruns() {
		$user_id = $this->input->post('user_id');
		$timesheets = $this->payrun_model->get_staff_timesheets($user_id);
		foreach($timesheets as $timesheet) {
			$this->_revert_payrun($timesheet['timesheet_id']);
		}
	}
	
	function revert_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->_revert_payrun($timesheet_id);
	}
	
	private function _revert_payrun($timesheet_id) {
		$this->payrun_model->revert_payrun($timesheet_id);
		$this->expense_model->delete_timesheet_expenses($timesheet_id);
	}
		
	function load_export($type) {
		$data['type'] = $type;
		$this->load->view('create/export_view', isset($data) ? $data : NULL);
	}
	
	function export_payrun($payrun_id) {
		$payrun = $this->payrun_model->get_payrun($payrun_id);
		$data['payrun'] = $payrun;
		$this->load->view('search_payrun/export_view', isset($data) ? $data : NULL);
	}
	function exporting() {
		$payrun_id = $this->input->post('payrun_id');
		$export_id = $this->input->post('export_id');
		if ($export_id == '') {
			return;
		}
		$file_name = $this->_export_payrun($payrun_id, $export_id);
		echo $file_name;
	}
	
	function create_payrun() {
		if ($this->input->post('export_id') == '') {
			echo json_encode(array(
				'export' => true,
				'success' => false
			));
			return;
		}
		$type = $this->input->post('type');
		$amount = $this->payrun_model->get_total_amount($type);
		$total_staffs = $this->payrun_model->count_staff($type);
		$timesheets = $this->payrun_model->get_payrun_timesheets($type);
		$data = array(
			'type' => $type,
			'amount' => $amount,
			'total_staffs' => $total_staffs,
			'total_timesheets' => count($timesheets)
		);
		$payrun_id = $this->payrun_model->create_payrun($data);
		foreach($timesheets as $timesheet) {
			$this->payrun_model->add_timesheet_to_payrun($timesheet['timesheet_id'], $payrun_id);
		}
		if ($this->input->post('export_id')) {
			$file_name = $this->_export_payrun($payrun_id, $this->input->post('export_id'));
			echo json_encode(array(
				'export' => true,
				'success' => true,
				'file_name' => $file_name
			));
		} else {
			echo json_encode(array('export' => false));
		}
	}
	
	/**
	*	@name: _export_payrun
	*	@desc: export a pay run
	*	@access: private
	*	@param: $payrun_id, $export_id
	*	@return: (string) $file_name
	*/
	private function _export_payrun($payrun_id, $export_id) {
		$timesheets = $this->payrun_model->get_export_timesheets($payrun_id);
		
		$fields = modules::run('export/get_fields', $export_id);
		
		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Staff Master");
		$objPHPExcel->getProperties()->setLastModifiedBy("Staff Master");
		$objPHPExcel->getProperties()->setTitle("Pay Run");
		$objPHPExcel->getProperties()->setSubject("Pay Run");
		$objPHPExcel->getProperties()->setDescription("Pay Run Excel file, generated from Staff Master.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 0;
		$row = 1;
		foreach($fields as $field) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $field['title']);
			$i++;
		}
		$i = 0;
		foreach($timesheets as $timesheet) {
			$row++;
			foreach($fields as $field) {
				$value = $field['value']; # Convert $field, $timesheet
				$value = str_replace('{staff_name}', $timesheet['first_name'] . ' ' . $timesheet['last_name'], $value);
				$value = str_replace('{internal_staff_id}', $timesheet['user_id'], $value);
				$value = str_replace('{external_staff_id}', $timesheet['external_staff_id'], $value);
				$value = str_replace('{job_date}', date('d/m/Y', $timesheet['start_time']), $value);
				$value = str_replace('{start_time}', date('H:i', $timesheet['start_time']), $value);
				$value = str_replace('{finish_time}', date('H:i', $timesheet['finish_time']), $value);
				$value = str_replace('{hours}', $timesheet['total_minutes']/60, $value);
				$value = str_replace('{venue}', $timesheet['venue'], $value);
				$value = str_replace('{job_name}', $timesheet['job_name'], $value);
				$value = str_replace('{pay_rate}', $timesheet['payrate'], $value);
				$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);
				$i++;
			}
			$i=0;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('payrun');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = $payrun_id . "_" . time() . ".csv";
		$objWriter->save("./exports/payrun/" . $file_name);
		return $file_name;
	}
	
	function search_payruns() {
		$params = $this->input->post();
		$data['payruns'] = $this->payrun_model->search_payruns($params);
		$this->load->view('search_payrun/results_list_view', isset($data) ? $data : NULL);
	}
	
	function search_payslips() {
		$params = $this->input->post();
		$data['payslips'] = $this->payrun_model->search_timesheets($params);
		$this->load->view('search_payslip/results_list_view', isset($data) ? $data : NULL);
	}
}