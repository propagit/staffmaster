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
	
	function list_staffs()
	{
		$staffs = $this->staff_model->search_staffs();
		$out = array();
		
		foreach($staffs as $staff)
		{
			$out[] = json_encode(array(
				'name' => $staff['first_name'] . ' ' . $staff['last_name'],
				'img' => 'test'));
		}
		echo json_encode($out);
	}
	
}