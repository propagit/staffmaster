<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@desc: Ajax controller for job_shift
 *	
 */

class Ajax_shift extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('job_shift_model');
		$this->load->model('staff/staff_model');
	}
	
	/**
	*	@name: load_staff_hours
	*	@desc: calculate total hours the staff is working in this week and this month
	*	@acces: public
	*	@param: (POST) staff_id
	*	@return: (HTML) view
	*/
	function load_staff_hours()
	{
		$staff_id = $this->input->post('staff_id');
		$one_hour = 60 * 60;
		$this_month = date('Y-m');
		$params_month = array(
			'staff_id' => $staff_id,
			'date_from' => '01-' . date('m-Y'),
			'date_to' => date('t-m-Y')
		);
		$shifts = $this->job_shift_model->search_shifts($params_month);
		$month_hours = 0;
		foreach($shifts as $shift)
		{
			$month_hours += modules::run('job/shift/get_shift_second', $shift) / $one_hour;
		}
		
		$today = date('Y-m-d');
		$this_week = modules::run('common/the_week', $today);
		$params_week = array(
			'staff_id' => $staff_id,
			'date_from' => date('d-m-Y', $this_week['start']),
			'date_to' => date('d-m-Y', $this_week['end'])
		);
		$shifts = $this->job_shift_model->search_shifts($params_week);
		$week_hours = 0;
		foreach($shifts as $shift)
		{
			$week_hours += modules::run('job/shift/get_shift_second', $shift) / $one_hour;
		}
		$data['month_hours'] = $month_hours;
		$data['week_hours'] = $week_hours;
		$data['params_month'] = urlencode(implode(',',$params_month));
		$data['params_week'] = urlencode(implode(',', $params_week));
		$this->load->view('shift/staff_hours_view', isset($data) ? $data : NULL);
	}
	
	function search_staffs() 
	{
		$params = $this->input->post();
		$staffs = $this->staff_model->search_staffs($params);
		
		$filter_staffs = array();
		if (isset($params['is_available']) && $params['is_available'] == 1)
		{
			$shift = $this->job_shift_model->get_job_shift($params['shift_id']);
			foreach($staffs as $staff)
			{
				if (!$this->staff_model->check_staff_time_collision($staff['user_id'], $shift)
						&& $this->staff_model->check_staff_time_availability($staff['user_id'], $shift)) 
				{
					$filter_staffs[] = $staff;
				}
			}
		}
		else
		{
			$filter_staffs = $staffs;
		}
		$data['staffs'] = $filter_staffs;
		$this->load->view('shift/search_staff/results_table_view', isset($data) ? $data : NULL);
	}
	
	
	function add_staff() {
		$shift_id = $this->input->post('shift_id');
		$staff_id = $this->input->post('user_id');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$this->job_shift_model->update_job_shift($shift_id, array(
			'staff_id' => $staff_id,
			'status' => SHIFT_UNCONFIRMED
		));
		echo json_encode(array(
			'job_id' => $shift['job_id'],
			'job_date' => $shift['job_date']
		));
	}
	
	function set_status_filter() {
		$this->session->set_userdata('shift_status_filter', $this->input->post('value'));
	}
	
	
	function load_expenses_modal($shift_id) {
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/expense/modal_view', isset($data) ? $data : NULL);
	}
	
	function add_expense() {
		$data = $this->input->post();
		if ($data['description'] == '') {
			echo json_encode(array('ok' => false, 'error_id' => 'description'));
			return;
		}
		if (!is_numeric($data['staff_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'staff_cost'));
			return;
		}
		if (!is_numeric($data['client_cost'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'client_cost'));
			return;
		}
		$shift = $this->job_shift_model->get_job_shift($data['shift_id']);
		$expenses = $shift['expenses'];
		if ($expenses == '') {
			$expenses = array();
		} else {
			$expenses = unserialize($expenses);
		}
		array_push( $expenses, array(
			'description' => $data['description'],
			'staff_cost' => $data['staff_cost'],
			'client_cost' => $data['client_cost'],
			'tax' => $data['tax']
		));
		$updated = $this->job_shift_model->update_job_shift($data['shift_id'], array(
			'expenses' => serialize($expenses)
		));
		if ($updated) {
			echo json_encode(array('ok' => true));
		}
	}
	
	function list_expenses() {
		$shift_id = $this->input->post('shift_id');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		if($shift) {
			$data['expenses'] = unserialize($shift['expenses']);
		}
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/expense/table_list_view', isset($data) ? $data : NULL);
	}
	
	function delete_expense() {
		$shift_id = $this->input->post('shift_id');
		$index = $this->input->post('i');
		$shift = $this->job_shift_model->get_job_shift($shift_id);
		$expenses = unserialize($shift['expenses']);
		$array = array();
		if ($expenses) {
			$i = 0;
			foreach($expenses as $expense) {
				if ($i!=$index) {
					$array[] = $expense;
				}
				$i++;
			}
		}
		$this->job_shift_model->update_job_shift($shift_id, array(
			'expenses' => serialize($array)
		));
	}

	function load_update_modal($shift_ids) 
	{
		$data['shift_ids'] = $shift_ids;
		$this->load->view('shift/edit/modal_view', isset($data) ? $data : NULL);
	}
	
	function load_field_inputs()
	{
		$field_id = $this->input->post('field_id');
		$this->load->view('shift/edit/field/' . $field_id . '_view');
	}
	
	function update_shifts()
	{
		$input = $this->input->post();
		$shift_ids = explode('~', $input['shift_ids']);
		$field_id = $input['field_id'];
		$value = isset($input['value']) ? $input['value'] : '';
		$shift_time_mode = 'start_time';
		
		$data = array();
		
		switch($field_id){
			//venue
			case 'venue_id':
				$venue = modules::run('attribute/venue/get_venue_by_name', $value);
				if (!$venue)
				{
					echo json_encode(array('ok' => false, 'error_id' => 'venue'));
					return;
				}
				else
				{
					$data['venue_id'] = $venue['venue_id'];
				}
			break;
			//expenses
			case 'expenses':
			
			break;
			//start time
			case 'start_time':
				$time_hour = $this->input->post('start_time_hour');
				$time_minutes = $this->input->post('start_time_minutes');
			break;
			
			//finish time
			case 'finish_time':
				$time_hour = $this->input->post('finish_time_hour');
				$time_minutes = $this->input->post('finish_time_minutes');
				$shift_time_mode = 'finish_time';
			break;
			
			default:
				$data[$field_id] = $value;
			break;
				
		}
		
		if($field_id == 'start_time' || $field_id == 'finish_time'){
			$params_change_shift_time = array(
											'shift_ids' => $shift_ids,
											'time_hour' => $time_hour,
											'time_minutes' => $time_minutes,
											'shift_time_mode' => $shift_time_mode	
											);
			modules::run('job/shift/update_shift_time',$params_change_shift_time);
		}else{
			foreach($shift_ids as $shift_id) {
				$this->job_shift_model->update_job_shift($shift_id, $data);
			}
		}
		$this->session->set_flashdata('selected_shifts', $shift_ids);
		$shift = $this->job_shift_model->get_job_shift($shift_ids[0]);
		echo json_encode(array('ok' => true, 'job_id' => $shift['job_id']));
	}
	
	#begin brief add to shift
	
	/**
	*	@name: load_add_brief_single_shift
	*	@desc: This loads the UI to add brief to a single shift
	*	@access: public
	*	@param: ([int] shift_id)
	*	@return: Loads a preview of brief
	*/
	function load_add_brief_single_shift($shift_id)
	{
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/brief/add_brief_single_shift_modal', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: load_add_brief_multi_shift
	*	@desc: This loads the UI to add brief to a multiple shift
	*	@access: public
	*	@param: ([int] shift_id)
	*	@return: Loads a preview of brief
	*/
	function load_add_brief_multi_shift($shift_ids)
	{
		$data['shift_ids'] = $shift_ids;
		$this->load->view('shift/brief/add_brief_multi_shift_modal', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: load_shift_briefs
	*	@desc: Ajax function to load the shift's existing briefs
	*	@access: public
	*	@param: ([via post] shift id)
	*	@return: Loads existing briefs of a shift
	*/
	function load_shift_briefs()
	{
		$shift_id = $this->input->post('shift_id');	
		$data['briefs'] = $this->job_shift_model->get_shift_briefs($shift_id);
		$data['shift_info'] = $this->job_shift_model->get_job_shift($shift_id);
		echo $this->load->view('shift/brief/ajax_existing_shift_brief_list', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: load_shift_briefs
	*	@desc: Ajax function to add a brief to a single shift
	*	@access: public
	*	@param: ([via post] shift id)
	*	@return: Loads existing briefs of a shift
	*/
	function add_brief()
	{
		$shift_id = $this->input->post('shift_id');
		$brief_id = $this->input->post('existing_brief');
		if($brief_id == 'information_sheet'){
			//add information sheet to this to this shift
			$params = array(
					'shift_id' => $shift_id,
					'status' => 1
					);
			modules::run('job/shift/toggle_shift_information_sheet_status',$params);
			$msg = 'success';	
		}else{
		$msg = '';
			if($shift_id && $brief_id){
				$shift_brief_exist = $this->job_shift_model->get_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
				if(!$shift_brief_exist){
					$data = array(
								'shift_id' => $shift_id,
								'brief_id' => $brief_id
								);	
					$this->job_shift_model->add_brief($data);
					$msg = 'success';
				}else{
					$msg = 'duplicate';	
				}
			}else{
				$msg = 'failed';	
			}
		}
		echo $msg;
		
	}
	/**
	*	@name: add_brief_multi_shift
	*	@desc: Ajax function to add a brief to a multiple shift
	*	@access: public
	*	@param: ([via post] shift ids, brief id)
	*	@return: Status of the operation
	*/
	function add_brief_multi_shift()
	{
		$shift_ids = $this->input->post('shift_ids');
		$brief_id = $this->input->post('existing_brief');
		$msg = '';
		$shift_ids_arr = explode('~',$shift_ids);
		if($shift_ids_arr){
			if($brief_id == 'information_sheet'){
				//add information sheet to this to these shift
				foreach($shift_ids_arr as $shift_id){
					$params = array(
							'shift_id' => $shift_id,
							'status' => 1
							);
					modules::run('job/shift/toggle_shift_information_sheet_status',$params);
				}
			}else{
				foreach($shift_ids_arr as $shift_id){
					if($shift_id && $brief_id){
						$shift_brief_exist = $this->job_shift_model->get_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
						if(!$shift_brief_exist){
							$data = array(
										'shift_id' => $shift_id,
										'brief_id' => $brief_id
										);	
							$this->job_shift_model->add_brief($data);
						}
					}
				}
			}
		}
		echo 'success';
		
	}
	/**
	*	@name: remove_brief_multi_shift
	*	@desc: Ajax function to add remove a brief from multiple shift
	*	@access: public
	*	@param: ([via post] shift ids, brief id)
	*	@return: Status of the operation
	*/
	function remove_brief_multi_shift()
	{
		$shift_ids = $this->input->post('shift_ids');
		$brief_id = $this->input->post('existing_brief');
		$msg = '';
		$shift_ids_arr = explode('~',$shift_ids);
		if($shift_ids_arr){
			if($brief_id == 'information_sheet'){
				//remove information sheet to from these shift
				foreach($shift_ids_arr as $shift_id){
					$params = array(
							'shift_id' => $shift_id,
							'status' => 0
							);
					modules::run('job/shift/toggle_shift_information_sheet_status',$params);
				}
			}else{
				foreach($shift_ids_arr as $shift_id){
					if($shift_id && $brief_id){
						$shift_brief_exist = $this->job_shift_model->get_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
						if($shift_brief_exist){
							$this->job_shift_model->delete_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
						}
					}
				}
			}
		}
		echo 'success';
		
	}
	
	/**
	*	@name: delete_brief
	*	@desc: Deletes brief and all its elements and documents.
	*	@access: public
	*	@param: ([via post] brief id)
	*	@return: success or failed status
	*/
	function delete_shift_brief()
	{
		$shift_brief_id = $this->input->post('shift_brief_id');

		//delete brief element
		$this->job_shift_model->delete_shift_brief($shift_brief_id);
		echo 'success';
	}
	/**
	*	@name: delete_shift_information_sheet
	*	@desc: Remove information sheet from a shift. It is done by changing the information_sheet status to 0 'zero' in job_shifts table
	*	@access: public
	*	@param: ([via post] shift id, information sheet status)
	*	@return: success or failed status
	*/
	function delete_shift_information_sheet()
	{
		$params = array(
					'shift_id' => $this->input->post('shift_id'),
					'status' => $this->input->post('status')
					);
		modules::run('job/shift/toggle_shift_information_sheet_status',$params);
	}
	
	function request_staff()
	{
		$data = $this->input->post();
		$request_staff_data = array();
		if ($data['shift_staff'])
		{
			$staff = modules::run('staff/get_staff', $data['shift_staff_id']);
			
			if ($staff)
			{
				$request_staff_data = array(
					'shift_id' => $data['shift_id'],
					'staff_id' => $data['shift_staff_id']
				);
				if ($this->job_shift_model->check_request_staff_shift($data['shift_id'],$data['shift_staff_id']))
				{
					echo json_encode(array('ok' => false, 'msg' => 'Staff already requested'));
					return;
				}
			}
			else 
			{
				echo json_encode(array('ok' => false, 'msg' => 'Staff not found'));
				return;
			}
		}
		$this->job_shift_model->add_request_staff($request_staff_data);
		echo json_encode(array(
			'ok' => true
		));
	}
	
	function get_request_staffs()
	{
		$shift_id = $this->input->post('shift_id');
		$data['staffs'] = $this->job_shift_model->get_request_staffs($shift_id);
		$this->load->view('client/shift/request_staff/list_requests', isset($data) ? $data : NULL);
	}
	
	function remove_request()
	{
		$shift_id = $this->input->post('shift_id');
		$staff_id = $this->input->post('staff_id');
		$this->job_shift_model->remove_request($shift_id, $staff_id);
	}
	
	/**
	*	@name: load_add_shift_note_modal
	*	@desc: This loads the UI to add note to a shift
	*	@access: public
	*	@param: ([int] shift_id)
	*	@return: Loads Modal window to add note to a shift
	*/
	function load_add_shift_note_modal($shift_id)
	{
		$data['shift_id'] = $shift_id;
		$this->load->view('shift/notes/add_note_modal', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: add_note
	*	@desc: Add note to a shift
	*	@access: public
	*	@param: ([via post] shift_id, note)
	*	@return: null
	*/
	function add_note()
	{
		$shift_id = $this->input->post('shift_id');
		$note = $this->input->post('note');
		$user = $this->session->userdata('user_data');
		$data = array(
					'shift_id' => $shift_id,
					'note' => $note,
					'added_by_user_id' => $user['user_id']
					);
		echo $this->job_shift_model->add_note($data);
	}
	
	/**
	*	@name: load_shift_notes
	*	@desc: Ajax function to load the shift's existing briefs
	*	@access: public
	*	@param: ([via post] shift id)
	*	@return: Loads existing briefs of a shift
	*/
	function load_shift_notes()
	{
		$shift_id = $this->input->post('shift_id');	
		$data['shift_notes'] = $this->job_shift_model->get_job_shift_notes($shift_id);
		echo $this->load->view('shift/notes/ajax_existing_shift_notes', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: delete_shift_note
	*	@desc: Ajax function to delete shift note
	*	@access: public
	*	@param: ([via post] job shift note id)
	*	@return: Affected rows
	*/
	function delete_shift_note()
	{
		$job_shift_note_id = $this->input->post('job_shift_note_id');
		echo $this->job_shift_model->delete_note($job_shift_note_id);
	}
	
	/**
	*	@name: load_add_note_multi_shift
	*	@desc: This loads the UI to add note to a multiple shift
	*	@access: public
	*	@param: ([int] shift_id)
	*	@return: Loads a preview of brief
	*/
	function load_add_note_multi_shift($shift_ids)
	{
		$data['shift_ids'] = $shift_ids;
		$this->load->view('shift/notes/add_note_multi_shift_modal', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: add_note_multi_shift
	*	@desc: Ajax function to add a note to a multiple shift
	*	@access: public
	*	@param: ([via post] shift ids, note)
	*	@return: Status of the operation
	*/
	function add_note_multi_shift()
	{
		$user = $this->session->userdata('user_data');
		$shift_ids = $this->input->post('shift_ids');
		$note = $this->input->post('note');
		$msg = '';
		$shift_ids_arr = explode('~',$shift_ids);
		if($shift_ids_arr && $note){
			foreach($shift_ids_arr as $shift_id){
				if($shift_id){
					  $data = array(
								'shift_id' => $shift_id,
								'note' => $note,
								'added_by_user_id' => $user['user_id']
								);
					 $this->job_shift_model->add_note($data);
				}
			}
		}
		echo 'success';
		
	}
}