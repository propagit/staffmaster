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
}