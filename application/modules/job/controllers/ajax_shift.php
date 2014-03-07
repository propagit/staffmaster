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
		$data['expenses'] = unserialize($shift['expenses']);
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
}