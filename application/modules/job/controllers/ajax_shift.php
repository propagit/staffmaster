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
	
	function search_staffs() {
		$params = $this->input->post();
		$data['staffs'] = $this->staff_model->search_staffs($params);
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
		$value = $input['value'];
		
		$data = array();
		
		if ($field_id == 'venue_id') {
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
		}
		else if ($field_id == 'expenses')
		{
			
		}
		else {
			$data[$field_id] = $value;
		}
		
		foreach($shift_ids as $shift_id) {
			$this->job_shift_model->update_job_shift($shift_id, $data);
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
			foreach($shift_ids_arr as $shift_id){
				if($shift_id && $brief_id){
					$shift_brief_exist = $this->job_shift_model->get_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
					if($shift_brief_exist){
						$this->job_shift_model->delete_shift_brief_by_shift_and_brief_id($shift_id,$brief_id);
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
	
}