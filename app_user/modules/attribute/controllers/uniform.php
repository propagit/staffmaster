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
	
	function get_uniforms($format=null)
	{
		$uniforms = $this->uniform_model->get_uniforms();
		if (!$format) {
			return $uniforms;
		}
		if ($format == 'data_source')
		{
			$data_source = array();
			foreach($uniforms as $uniform)
			{
				$name = $uniform['name'];
				$name = str_replace("'","\'", $name);
				$data_source[] = '{value:' . $uniform['uniform_id'] . ', text: \'' . $name . '\'}';
			}
			$data_source = implode(",", $data_source);
			return $data_source;
		}	
	}
	
	function display_uniform($uniform_id)
	{
		$uniform = $this->get_uniform($uniform_id);
		echo ($uniform) ? $uniform['name'] : 'Not Specified';
	}
	function get_uniform($uniform_id)
	{
		return $this->uniform_model->get_uniform($uniform_id);
	}
	
	function list_uniforms()
	{
		$sort_uniform = (bool) $this->session->userdata('sort_uniform');
		$data['uniforms'] = $this->uniform_model->get_uniforms($sort_uniform);
		$this->load->view('uniform/list_uniforms', isset($data) ? $data : NULL);
	}
	 
	function field_select($field_name, $field_value=null)
	{
		$uniforms = $this->uniform_model->get_uniforms(false);
		$array = array();
		foreach($uniforms as $uniform) {
			$array[] = array(
				'value' => $uniform['uniform_id'],
				'label' => $uniform['name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}

	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['uniforms'] = $this->uniform_model->get_uniforms(true);
		$this->load->view('dropdown_uniforms', isset($data) ? $data : NULL);
	}
}