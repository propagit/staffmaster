<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Ajax controller for attributes. 
*	@class_comments The custom attributes is not included in this module. It is located under the module - formbuilder
*
*/

class Ajax_payrate extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrate_model');
	}
		
	function load_edit_name_modal($payrate_id) 
	{
		$data['payrate'] = $this->payrate_model->get_payrate($payrate_id);
		$this->load->view('attribute/payrate/edit_name_modal_view', isset($data) ? $data : NULL);
	}
	
	function update_name()
	{
		$input = $this->input->post();
		$this->payrate_model->update_payrate($input['payrate_id'], $input);
	}
	
	function load_delete_modal($payrate_id)
	{
		$data['payrate'] = $this->payrate_model->get_payrate($payrate_id);
		$data['shifts_count'] = $this->payrate_model->count_payrate_shifts($payrate_id);
		$data['timesheets_count'] = $this->payrate_model->count_payrate_timesheets($payrate_id);
		$this->load->view('attribute/payrate/delete_modal_view', isset($data) ? $data : NULL);
	}
	
	function delete_payrate()
	{
		$payrate_id = $this->input->post('payrate_id');
		$shifts_count = $this->payrate_model->count_payrate_shifts($payrate_id);
		$timesheets_count = $this->payrate_model->count_payrate_timesheets($payrate_id);
		if ($shifts_count + $timesheets_count > 0) {
			$this->payrate_model->update_payrate($payrate_id, array(
				'status' => PAYRATE_DELETED
			));
		} else {
			$this->payrate_model->clean_payrate_data($payrate_id);
			$this->payrate_model->delete_payrate($payrate_id);
		}
	}
	
	function delete_group()
	{
		$id = $this->input->post('id');
		$data = $this->payrate_model->get_payrate_single_data($id);
		$this->payrate_model->reset_payrate_data($data['payrate_id'], $data['group'], $data['color']);
	}
}