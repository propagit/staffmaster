<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax Dashboard
 * @author: kaushtuvgurung@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_notes_model');
		$this->user = $this->session->userdata('user_data');
	}
	
	
	# get daily stats
	function get_users()
	{
		echo $this->load->view('add_view', isset($data) ? $data : NULL, true);
	}
	
	function add_note()
	{
		$input = $this->input->post();
		if (!$input['user_id']) {
			echo json_encode(array('ok' => false, 'error_id' => 'user_id', 'msg' => 'Please Select a Client/Staff'));
			return;
		}
		if (!$input['note']) {
			echo json_encode(array('ok' => false, 'error_id' => 'note', 'msg' => 'Note is required'));
			return;
		}
		
		$data = array(
					'user_id' => $input['user_id'],
					'added_by' => $this->user['user_id'],
					'note' => $input['note'],
					'created_date' => date('Y-m-d')
				);


		$user_id = $this->user_notes_model->insert_note($data);
		
		if($user_id){
			echo json_encode(array('ok' => true));
			return; 	
		}
		
	}
}