<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Custom extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('custom_field_model');
	}

	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
	}

	function main_view()
	{
		$this->load->view('custom/main_view', isset($data) ? $data : NULL);
	}
	
	function get_custom_field($field_id)
	{
		return $this->custom_field_model->get_field($field_id);		
	}
}
