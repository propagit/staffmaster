<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Payrate extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('payrate_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_payrate();
				break;
			case 'edit':
					$this->edit_payrate();
				break;
			case 'delete':
					$this->delete_payrate($param);
				break;
			case 'sort':
					$this->sort_payrates();
				break;
			default:
					$this->list_payrates();
				break;
		}
	}
	
	function list_payrates()
	{
		$sort_payrate = (bool) $this->session->userdata('sort_payrate');
		$data['payrates'] = $this->payrate_model->get_payrates($sort_payrate);
		$this->load->view('list_payrates', isset($data) ? $data : NULL);
	}
	
	function sort_payrates()
	{
		if (!$this->session->userdata('sort_payrate'))
		{
			$this->session->set_userdata('sort_payrate', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_payrate');
		}
		redirect('attribute/payrate');
	}
	
	function add_payrate()
	{
		$data = $this->input->post();
		$this->payrate_model->insert_payrate($data);
		redirect('attribute/payrate');
	}
	
	function edit_payrate()
	{
		$data = $this->input->post();
		$this->payrate_model->update_payrate($data['payrate_id'], $data);
		redirect('attribute/payrate');
	}
	
	function delete_payrate($payrate_id)
	{
		$this->payrate_model->delete_payrate($payrate_id);
		redirect('attribute/payrate');
	}
	
	function get_payrates()
	{
		return $this->payrate_model->get_payrates();
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['payrates'] = $this->payrate_model->get_payrates();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_payrates', isset($data) ? $data : NULL);
	}
	
}