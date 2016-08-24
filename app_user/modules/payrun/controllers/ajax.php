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

	function process_selected_timesheets() {
		$timesheet_ids = $this->input->post('timesheet_ids');
		foreach($timesheet_ids as $timesheet_id) {
			$this->payrun_model->process_payrun($timesheet_id);
		}
	}

	function process_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->process_payrun($timesheet_id);
	}

	function unprocess_selected_timesheets() {
		$timesheet_ids = $this->input->post('timesheet_ids');
		foreach($timesheet_ids as $timesheet_id) {
			$this->payrun_model->unprocess_payrun($timesheet_id);
		}
	}

	function unprocess_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->payrun_model->unprocess_payrun($timesheet_id);
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

	function revert_selected_timesheets() {
		$timesheet_ids = $this->input->post('timesheet_ids');
		foreach($timesheet_ids as $timesheet_id) {
			$this->_revert_payrun($timesheet_id);
		}
	}

	function revert_payrun() {
		$timesheet_id = $this->input->post('timesheet_id');
		$this->_revert_payrun($timesheet_id);
	}

	private function _revert_payrun($timesheet_id) {
		$this->payrun_model->revert_payrun($timesheet_id);
		$this->expense_model->delete_timesheet_expenses($timesheet_id);
		# revert any split timesheet
		$timesheet = modules::run('timesheet/get_timesheet',$timesheet_id);
		if($timesheet['child_timesheet_id']){
			
			$has_child = true;
			$child_ts_id = $timesheet['child_timesheet_id'];
			while($has_child){
				# get child timesheet
				$child_ts = modules::run('timesheet/get_timesheet',$child_ts_id);
				
				# revert
				$this->payrun_model->revert_payrun($child_ts_id);
				$this->expense_model->delete_timesheet_expenses($child_ts_id);
				
				# check if this has another child 	
				if($child_ts['child_timesheet_id']){
					$child_ts_id = $child_ts['child_timesheet_id'];
				}else{
					$has_child = false;	
				}
			}
					
		}
		
	}

	function load_export($type, $mode = '') {
		$data['type'] = $type;
		$data['mode'] = $mode;
		$data['period'] = $this->payrun_model->get_payrun_timesheets_date_period($type);
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

	function load_xero_payrun() {
		$this->load->view('create/xero_payruns');
	}

	function populate_xero_payrun_period() {
		$id = $this->input->post('id');
		$payrun = modules::run('api/xero/get_payrun', $id);
		echo json_encode(array(
			'start_date' => date('d-m-Y', strtotime($payrun['PayRunPeriodStartDate'])),
			'end_date' => date('d-m-Y', strtotime($payrun['PayRunPeriodEndDate'])),
			'payment_date' => date('d-m-Y', strtotime($payrun['PaymentDate']))
		));
	}

	function create_payrun() {
		$input = $this->input->post();
		$export = false;

		if (isset($input['export_csv'])) {
			if (!isset($input['export_id']) || $input['export_id'] == '') {
				echo json_encode(array(
					'ok' => false,
					'error_id' => 'export_id'
				));
				return;
			}
			$export = true;
		}

		$type = $input['type'];
		$platform = isset($input['platform']) ? $input['platform'] : '';
		$date_from = '';
		$date_to = '';
		$payable_date = '';
		if ($type == STAFF_TFN) {
			if ($platform == 'myob')
			{
				$period = $this->payrun_model->get_payrun_timesheets_date_period($type);
				if (!isset($input['date_from']) || $input['date_from'] == '' || strtotime(date('Y-m-d', $period['start_date'])) <= strtotime($input['date_from'])) {
					echo json_encode(array(
						'ok' => false,
						'error_id' => 'date_from'
					));
					return;
				}
				if (!isset($input['date_to']) || $input['date_to'] == '' || strtotime(date('Y-m-d', $period['finish_date'])) >= strtotime($input['date_to'])) {
					echo json_encode(array(
						'ok' => false,
						'error_id' => 'date_to'
					));
					return;
				}

			}

			$date_from = date('Y-m-d', strtotime($input['date_from']));
			$date_to = date('Y-m-d', strtotime($input['date_to']));
			$payable_date = date('Y-m-d', strtotime($input['payable_date']));
		}




		$timesheets = $this->payrun_model->get_payrun_timesheets($type);

		if ($platform == 'myob')
		{
			foreach($timesheets as $timesheet)
			{
				$result = modules::run('api/myob/connect', 'validate_append_timesheet~' . $timesheet['timesheet_id']);
				if (!$result['ok'])
				{
					echo json_encode(array(
						'ok' => true,
						'export' => false,
						'pushed_ok' => false,
						'pushed_msg' => $result['msg']
					));
					return;
				}
			}
		}
		if ($platform == 'xero')
		{
			
			# check if all timesheet jobdate falls on the payrun period
			foreach($timesheets as $timesheet)
			{
				if($timesheet['job_date'] > $date_to || $timesheet['job_date'] < $date_from){

					echo json_encode(array(
						'ok' => true,
						'export' => false,
						'pushed_ok' => false,
						'pushed_msg' => "<div class='text-center'>
											<p>
											<span class='text-danger xero-payrun-error'>Error - Don't Panic!</span><br>
											(No data has been pushed)<br><br>
											Xero returned the response<br>
											<i>Time sheets in this payrun fall outside of the pay period <br>
											(" . date('d M, Y',strtotime($date_from)) . " - " . date('d M, Y',strtotime($date_to)) . ")</i><br><br> 
											<strong>Please remove these timesheets to proceed <i class='fa fa-smile-o'></i></strong>
											</p>
										</div>"
					));
					return;	
				}
				
			}

			
			$not_found_pay_items = array();
			foreach($timesheets as $timesheet)
			{
				$not_found = modules::run('api/xero/validate_timesheet_payitems', $timesheet['timesheet_id']);
				$not_found_pay_items = array_merge($not_found, $not_found_pay_items);
			}

			$not_found_pay_items = array_unique($not_found_pay_items);

			if (count($not_found_pay_items) > 0)
			{
				echo json_encode(array(
					'ok' => true,
					'export' => false,
					'pushed_ok' => false,
					'pushed_msg' => "<div class='text-center'>
										<p>
										<span class='text-danger xero-payrun-error'>Error - Don't Panic!</span><br>
										(No data has been pushed)<br><br>
										Xero returned the response<br>
										<i>Xero can't find following Pay Item(s):</i></p>
										<ul style='list-style:none; padding:0;'><li>" . implode("</li><li>", $not_found_pay_items) . "</li></ul>
										<p>
										<strong>To proceed login to your Xero account and create the above pay items and try again <i class='fa fa-smile-o'></i></strong>
										</p>
									</div>"
				));
				return;
			}

			$employee_pay_items = array();
			foreach($timesheets as $timesheet)
			{
				$errors = modules::run('api/xero/validate_timesheet_employee_payitems', $timesheet['timesheet_id'],$input['xero_payrun_id']);
				$employee_pay_items = array_merge($errors, $employee_pay_items);
			}
			$employee_pay_items = array_unique($employee_pay_items);
			if (count($employee_pay_items) > 0)
			{
				echo json_encode(array(
					'ok' => true,
					'export' => false,
					'pushed_ok' => false,
					'pushed_msg' => "<div class='text-center'>
										<p>
										<span class='text-danger xero-payrun-error'>Error - Don't Panic!</span><br>
										(No data has been pushed)<br><br>
										Xero returned the response(s)<br>"
										 . implode("", $employee_pay_items) . 
									 	"
										<br>
										<strong>To proceed login to your Xero account and correct the employee records mentioned above and try again <i class='fa fa-smile-o'></i></strong>
										</p>
									 </div>"
				));
				return;
			}

		}

		$amount = $this->payrun_model->get_total_amount($type);
		$total_staffs = $this->payrun_model->count_staff($type);
		$data = array(
			'date_from' => $date_from,
			'date_to' => $date_to,
			'payable_date' => $payable_date,
			'type' => $type,
			'amount' => $amount,
			'total_staffs' => $total_staffs,
			'total_timesheets' => count($timesheets)
		);
	
		$payrun_id = $this->payrun_model->create_payrun($data);
		foreach($timesheets as $timesheet) {
			$this->payrun_model->add_timesheet_to_payrun($timesheet['timesheet_id'], $payrun_id);
		}

		if ($export) # Export to CSV
		{
			$file_name = $this->_export_payrun($payrun_id, $this->input->post('export_id'));
			echo json_encode(array(
				'ok' => true,
				'export' => true,
				'file_name' => $file_name
			));
		}
		else
		{
			$pushed_msg = '';
			if ($platform == 'shoebooks') {
				$pushed_results = modules::run('api/shoebooks/append_payslip', $payrun_id);
				if (count($pushed_results) > 0)
				{
					$pushed_msg = '<p> ' . count($pushed_results) . '/' . count($timesheets) . ' time sheets have been pushed to Shoebooks successfully!</p>';
				}
				if (count($timesheets) > count($pushed_results))
				{
					$pushed_msg .= '<p> ' . (count($timesheets) - count($pushed_results)) . ' time sheets have been pushed to Shoebooks with errors!</p>';
				}

			}
			else if ($platform == 'myob')
			{
				$result = modules::run('api/myob/connect', 'append_timesheets~' . $payrun_id);
				if ($result['ok'])
				{
					$pushed_msg = '<p>' . count($timesheets) . ' time sheets have been pushed to MYOB successfully!</p>';
				}
			}
			else if ($platform == 'xero')
			{
				 $result = modules::run('api/xero/create_timesheets', $payrun_id);
				 
				 if ($result) {
					$res = json_decode($result);
					if($res->ok){
						$pushed_msg = '<p>' . count($timesheets) . ' time sheets have been pushed to Xero successfully!</p>';
						echo json_encode(array(
							'ok' => true,
							'export' => false,
							'payrun_id' => $payrun_id,
							'pushed_ok' => true,
							'pushed_msg' => $pushed_msg
						));	
						return;
					}else{
						# error
						# delete payroll
						# revert timesheet to batched status
						modules::run('payrun/revert_xero_payrun',$payrun_id);
						echo json_encode(array(
											'ok' => true,
											'export' => false,
											'pushed_ok' => false,
											'pushed_msg' => "<div class='text-center'>
																<p>
																<span class='text-danger xero-payrun-error'>Error - Don't Panic!</span><br>
																(No data has been pushed)<br><br>
																<hr style='border-top:1px solid #ccc;'>
																<strong>Important Note:</strong><br>
																<span class='text-danger'>Xero has detected</span><br>
																Timesheet(s) contained in this payrun already exists in Xero.<br>
																(An employee can only contain 1 set of timesheet data<br> per pay period in Xero)
																<br><br>
																<strong><i>Login to Xero and review the pay period to determine which employees already have timesheet data </i> <i class='fa fa-smile-o'></i></strong>
																</p>
															 </div>"
											));
					}
					
				 }
				 return;
			}

			echo json_encode(array(
				'ok' => true,
				'export' => false,
				'payrun_id' => $payrun_id,
				'pushed_ok' => true,
				'pushed_msg' => $pushed_msg
			));
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

		usort($timesheets, function($a, $b) { // anonymous function
		    // compare numbers only
		    if (isset($a['external_staff_id'])) {
			    return $a['external_staff_id'] - $b['external_staff_id'];
		    }


		    // compare numbers or strings
		    //return strcmp($a['weight'], $b['weight']);

		    // compare numbers or strings non-case-sensitive
		    //return strcmp(strtoupper($a['weight']), strtoupper($b['weight']));
		});

		$template = modules::run('export/get_template', $export_id);
		$fields = modules::run('export/get_fields', $export_id);

		if ($template['level'] == 'staff') {
			$timesheets = $this->payrun_model->get_export_timesheets_by_staff($payrun_id);
		}

		ini_set('memory_limit', '128M');
		ini_set('max_execution_time', 3600); //300 seconds = 5 minutes

		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("StaffBooks");
		$objPHPExcel->getProperties()->setLastModifiedBy("StaffBooks");
		$objPHPExcel->getProperties()->setTitle("Pay Run");
		$objPHPExcel->getProperties()->setSubject("Pay Run");
		$objPHPExcel->getProperties()->setDescription("Pay Run Excel file, generated from StaffBooks.");

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
			$date_format = 'd/m/Y';
		}

		foreach($timesheets as $timesheet) {
			if ($template['level'] == 'pay_rate') {
				$pay_rates = modules::run('timesheet/extract_timesheet_payrate', $timesheet['timesheet_id']);
				foreach($pay_rates as $pay_rate) {
					$row++;
					foreach($fields as $field) {
						$value = $field['value']; # Convert $field, $timesheet


						$value = str_replace('{staff_name}', $timesheet['first_name'] . ' ' . $timesheet['last_name'], $value);
						$value = str_replace('{internal_staff_id}', $timesheet['user_id'], $value);
						$value = str_replace('{external_staff_id}', $timesheet['external_staff_id'], $value);
						#$value = str_replace('{venue}', $timesheet['venue'], $value);
						$value = str_replace('{job_name}', $timesheet['job_name'], $value);
						$value = str_replace('{pay_rate}', $timesheet['payrate'], $value);
						$value = str_replace('{job_id}', $timesheet['job_id'], $value);
						$value = str_replace('{pay_run_date_from}', date($date_format, strtotime($timesheet['date_from'])), $value);
						$value = str_replace('{pay_run_date_to}', date($date_format, strtotime($timesheet['date_to'])), $value);
						$value = str_replace('{payable_date}', date($date_format, strtotime($timesheet['payable_date'])), $value);
						$value = str_replace('{start_time}', date('H:ia', $pay_rate['start']), $value);
						$value = str_replace('{finish_time}', date('H:ia', $pay_rate['finish']), $value);
						$group = trim($pay_rate['group']);
						if (!$group)
						{
							$group = $timesheet['payrate'];
						}
						$value = str_replace('{pay_rate_group}', $group, $value);

						$value = str_replace('{hours}', $pay_rate['hours'], $value);
						$value = str_replace('{job_date}', date($date_format, $pay_rate['start']), $value);
						$value = str_replace('{pay_rate_amount}', $pay_rate['rate'], $value);
						if ($pay_rate['break']) {
							$value = str_replace('{break}', ' w/ ' . $pay_rate['break'] / 3600 . ' hour break', $value);
						} else {
							$value = str_replace('{break}', '', $value);
						}

						#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);

						if ($template['target'] == 'myob') {
							$value = str_replace(',',' ', $value); # Replace comma for myob
						}

						if ($i < 26)
						{
							$letter = chr(97 + $i) . $row;
						}
						else
						{
							$letter = 'A' . chr(97 + ($i-26)) . $row;
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);

						$i++;
					}
					$i=0;
				}
			}
			else if ($template['level'] == 'shift') {
				$row++;
				foreach($fields as $field) {
					$value = $field['value']; # Convert $field, $timesheet

					$client = modules::run('client/get_client', $timesheet['client_id']);

					$value = str_replace('{client_company_name}', $client['company_name'], $value);
					$value = str_replace('{external_client_id}', $client['external_client_id'], $value);
					$value = str_replace('{internal_client_id}', $client['user_id'], $value);

					$value = str_replace('{staff_last_name}', $timesheet['last_name'], $value);
					$value = str_replace('{staff_first_name}', $timesheet['first_name'], $value);
					$value = str_replace('{staff_name}', $timesheet['first_name'] . ' ' . $timesheet['last_name'], $value);
					$value = str_replace('{internal_staff_id}', $timesheet['user_id'], $value);
					$value = str_replace('{external_staff_id}', $timesheet['external_staff_id'], $value);
					$value = str_replace('{ex_tax_amount}', money_format('%i', $timesheet['total_amount_staff']), $value);
					$value = str_replace('{job_name}', $timesheet['job_name'], $value);
					$value = str_replace('{pay_rate}', $timesheet['payrate'], $value);
					$value = str_replace('{job_id}', $timesheet['job_id'], $value);
					$value = str_replace('{pay_run_date_from}', date($date_format, strtotime($timesheet['date_from'])), $value);
					$value = str_replace('{pay_run_date_to}', date($date_format, strtotime($timesheet['date_to'])), $value);
					$value = str_replace('{payable_date}', date($date_format, strtotime($timesheet['payable_date'])), $value);
					$value = str_replace('{pay_run_date}', date($date_format, strtotime($timesheet['created_on'])), $value);
					$value = str_replace('{start_time}', date('H:ia', $timesheet['start_time']), $value);
					$value = str_replace('{finish_time}', date('H:ia', $timesheet['finish_time']), $value);

					$value = str_replace('{hours}', $timesheet['total_minutes'] / 60, $value);
					$value = str_replace('{job_date}', date($date_format, $timesheet['start_time']), $value);
					
					# check {taxable}
					if($value == '{taxable}'){
						# check if staff requires gst or not
						$cur_staff = modules::run('staff/staff/get_staff',$timesheet['staff_id']);
						if($cur_staff['f_require_gst']){
							$value = str_replace('{taxable}', 'GST on Expenses', $value);	
						}else{
							$value = str_replace('{taxable}', 'GST Free Expenses', $value);	
						}
					}

					$breaks = json_decode($timesheet['break_time']);
					$total = 0;
					if (count($breaks) > 0)
					{
						foreach($breaks as $break)
						{
							$total += $break->length;
						}
					}

					if ($total > 0) {
						$value = str_replace('{break}', ' w/ ' . $total / 3600 . ' hour break', $value);
					} else {
						$value = str_replace('{break}', '', $value);
					}

					#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);

					if ($template['target'] == 'myob') {
						$value = str_replace(',',' ', $value); # Replace comma for myob
					}


					if ($i < 26)
					{
						$letter = chr(97 + $i) . $row;
					}
					else
					{
						$letter = 'A' . chr(97 + ($i-26)) . $row;
					}
					$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);

					$i++;
				}
				$i=0;
			}
			else if ($template['level'] == 'staff') {
				$row++;
				foreach($fields as $field) {
					$value = $field['value']; # Convert $field, $timesheet


					$value = str_replace('{staff_name}', $timesheet['first_name'] . ' ' . $timesheet['last_name'], $value);
					$value = str_replace('{internal_staff_id}', $timesheet['user_id'], $value);
					$value = str_replace('{external_staff_id}', $timesheet['external_staff_id'], $value);
					$value = str_replace('{pay_rate}', $timesheet['payrate'], $value);
					$value = str_replace('{pay_run_date_from}', date($date_format, strtotime($timesheet['date_from'])), $value);
					$value = str_replace('{pay_run_date_to}', date($date_format, strtotime($timesheet['date_to'])), $value);
					$value = str_replace('{payable_date}', date($date_format, strtotime($timesheet['payable_date'])), $value);
					$value = str_replace('{hours}', $timesheet['total_minutes'] / 60, $value);
					$value = str_replace('{total_amount}', $timesheet['total_amount'], $value);
					$value = str_replace('{taxable}', 'EXEMPTEXPENSES', $value);	
					

					#$objPHPExcel->getActiveSheet()->SetCellValue(chr(97 + $i) . $row, $value);
					if ($template['target'] == 'myob') {
						$value = str_replace(',',' ', $value); # Replace comma for myob
					}
					if ($i < 26)
					{
						$letter = chr(97 + $i) . $row;
					}
					else
					{
						$letter = 'A' . chr(97 + ($i-26)) . $row;
					}
					$objPHPExcel->getActiveSheet()->SetCellValue($letter, $value);

					$i++;
				}
				$i=0;
			}

		}

		$objPHPExcel->getActiveSheet()->setTitle('payrun');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "CSV");
		$file_name = 'staff_payrun_' . $payrun_id . "_" . time() . ".csv";
		$objWriter->save(EXPORTS_PATH . "/payrun/" . $file_name);
		return $file_name;
	}

	function search_payruns() {
		$params = $this->input->post();
		$data['payruns'] = $this->payrun_model->search_payruns($params);
		$data['total_payruns'] = $this->payrun_model->search_payruns($params,true);
		$data['current_page'] = $this->input->post('current_page',true);
		$this->load->view('search_payrun/results_list_view', isset($data) ? $data : NULL);
	}

	function delete_payruns() {
		$payrun_ids = $this->input->post('payruns');
		foreach($payrun_ids as $payrun_id) {
			$this->payrun_model->delete_payrun($payrun_id);
		}
	}

	function search_payslips() {
		$params = $this->input->post();
		$data['payslips'] = $this->payrun_model->search_timesheets($params);
		$this->load->view('search_payslip/results_list_view', isset($data) ? $data : NULL);
	}

	function delete_payslips() {
		$timesheet_ids = $this->input->post('timesheets');
		foreach($timesheet_ids as $timesheet_id) {
			$this->payrun_model->delete_timesheet($timesheet_id);
		}
	}
}
