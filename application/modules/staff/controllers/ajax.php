<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
	}
	
	function search_staffs()
	{
		$data['staffs'] = $this->staff_model->search_staffs($this->input->post());
		$this->load->view('search_results', isset($data) ? $data : NULL);		
	}
	
	function add_staff()
	{
		
	}
	
	function list_staffs($query='')
	{
		$staffs = $this->staff_model->search_staffs(array('keyword' => $query));
		$out = array();
		
		foreach($staffs as $staff)
		{
			$out[] = array(
				'id' => $staff['user_id'],
				'name' => $staff['first_name'] . ' ' . $staff['last_name'],
				'username' => $staff['username']
			);
		}
		//$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

}