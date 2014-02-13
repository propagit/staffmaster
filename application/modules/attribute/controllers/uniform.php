<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Uniform extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('uniform_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->list_uniforms();
				break;
		}
	}
	
	function list_uniforms()
	{
		$sort_uniform = (bool) $this->session->userdata('sort_uniform');
		$data['uniforms'] = $this->uniform_model->get_uniforms($sort_uniform);
		$this->load->view('uniform/list_uniforms', isset($data) ? $data : NULL);
	}

	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['uniforms'] = $this->uniform_model->get_uniforms(true);
		$this->load->view('dropdown_uniforms', isset($data) ? $data : NULL);
	}
}