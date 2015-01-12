<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Public_timesheet_dispatcher
 * Description: control main flow of the timesheet that can be accessed via an encrypted url
 * @author: kaushtuvgurung@gmail.com
 */

class Public_timesheet_dispatcher extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('timesheet/timesheet_model');
		$this->load->model('timesheet/timesheet_staff_model');
		$this->load->model('expense/expense_model');
	}
	
	public function index()
	{		
		
	}
	
	
	# timesheet public view
	function list_timesheet($key_type,$key)
	{
		# key_type: sp - supervisor, sf = staff
		
		$this->load->model('job/job_shift_model');
		$this->load->model('expense/expense_model');	
		
		$data['key'] = $key;
		$data['timesheets'] = $this->timesheet_model->get_timesheet_by_key($key_type,$key);
		$data['is_supervised'] = $key_type == 'sp' ? 1 : 0;
		$data['key_type'] = $key_type;		
		
		
		$content = $this->load->view('public/timesheet/timesheet_list_view', isset($data) ? $data : NULL, true);
		$this->template->set_template('public_timesheet');
		$this->template->add_css('custom_styles');
		$this->template->write('title', 'StaffBooks ');
		$this->template->write('content', $content);
		$this->template->render();
	}
	
	# approve timesheet
	function approve_timesheet()
	{
		# ts_k  : timesheet key
		# ts_id : timesheet id
		# us_tp : staff type i.e. is the approving user staff or supervisor [supervisor : 'sp', staff : 'sf']
		$input = $this->input->post();
		
		$key = $input['ts_k'];
		$timesheet_id = $input['ts_id'];
		$user_type = $input['us_tp'];
		
		# validate if the record 
			# since if a supervisor approves a timesheet it is marked as approved and 
				# if a staff approves it is marked as submitted
		$timesheet = $this->timesheet_model->get_timesheet($timesheet_id);
		
		# if supervisor is approving this timesheet
		if($user_type == TIMESHEET_SUPERVISOR_KEY_TYPE){
			# verify the key
			if($timesheet['supervisor_key'] == $key)	{
				# proceed with update - mark the timesheet as approved
				$this->timesheet_model->update_timesheet($timesheet_id,array('status' => TIMESHEET_APPROVED));
			}
		}else{
			# staff is approving their timesheet so update the status as submitted		
			$this->timesheet_model->update_timesheet($timesheet_id,array('status' => TIMESHEET_SUBMITTED));
		}
		echo 'ok';
	}
	
	# reject timesheet
	# leave the status as TIMESHEET_PENDING, fill in the reject note 
	# on the admin side if the reject note is filled in then show it as rejected
	function reject_timsheet()
	{
		$input = $this->input->post();
		$note = $input['reject_note'];
		$timesheet_id = $input['ts_id'];
		if(!$timesheet_id){
			echo 'Error rejecting this shift. Please reload the page and try again';
			return;		
		}
		if(!trim($note)){
			echo 'Please enter a reason for rejecting this timesheet';
			return;	
		}
		
		# insert the reject note
		$this->timesheet_model->update_timesheet($timesheet_id,array('reject_note' => $note));
		echo 'ok';
		return;
		
	}
	
	function update_timesheet_start_time() {
		echo modules::run('timesheet/ajax_staff/update_timesheet_start_time');
	}
	
	function update_timesheet_finish_time(){
		echo modules::run('timesheet/ajax_staff/update_timesheet_finish_time');	
	}
	
	function refresh_timesheet() {
		$data['timesheet_id'] = $this->input->post('timesheet_id');
		echo $this->load->view('public/timesheet/timesheet_row_view',$data,true);
	}
	
	function load_ts_breaks(){
		echo modules::run('timesheet/ajax/load_ts_breaks');	
	}
	
	function add_ts_break(){
		echo modules::run('timesheet/ajax/add_ts_break');	
	}
	
	function update_ts_breaks(){
		echo modules::run('timesheet/ajax/update_ts_breaks');	
	}
	
	function load_expenses_modal($timesheet_id) {
		$data['timesheet_id'] = $timesheet_id;
		$this->load->view('public/timesheet/expense/modal_view', isset($data) ? $data : NULL);
	}
	
	function list_expenses(){
		$timesheet_id = $this->input->post('timesheet_id');
		$timesheet = $this->timesheet_staff_model->get_timesheet($timesheet_id);
		if($timesheet) {
			$data['expenses'] = unserialize($timesheet['expenses']);
		}
		$data['timesheet_id'] = $timesheet_id;
		$data['paid_expenses'] = $this->expense_model->get_timesheet_expenses($timesheet_id);
		$this->load->view('public/timesheet/expense/table_list_view', isset($data) ? $data : NULL);
	}
	
	function add_expense(){
		echo modules::run('timesheet/ajax_staff/add_expense');
	}
	
	function delete_expense(){
		modules::run('timesheet/ajax/delete_expense');	
	}
	
	function details($timesheet_id){
		echo modules::run('timesheet/ajax/details',$timesheet_id);	
	}
}