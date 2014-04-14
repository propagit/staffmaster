<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Availability extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('availability_model');
	}
	
	function get_availability()
	{
		return $this->availability_model->get_availability();
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['availability'] = $this->availability_model->get_availability();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_availability', isset($data) ? $data : NULL);
	}
	
}