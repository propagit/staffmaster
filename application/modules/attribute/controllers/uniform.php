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
			case 'add':
					$this->add_uniform();
				break;
			case 'edit':
					$this->edit_uniform();
				break;
			case 'delete':
					$this->delete_uniform($param);
				break;
			case 'sort':
					$this->sort_uniforms();
				break;
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
	
	/* function add_uniform()
	{
		$data = $this->input->post();
		$this->uniform_model->insert_uniform($data);
		redirect('attribute/uniform');
	} */
	
	/* function edit_uniform()
	{
		$data = $this->input->post();
		$this->uniform_model->update_uniform($data['uniform_id'], $data);
		redirect('attribute/uniform');
	} */
	
	/* function delete_uniform($uniform_id)
	{
		$this->uniform_model->delete_uniform($uniform_id);
		redirect('attribute/uniform');
	}
	 */
	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['uniforms'] = $this->uniform_model->get_uniforms(true);
		$this->load->view('dropdown_uniforms', isset($data) ? $data : NULL);
	}
}