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
			case 'update_payrate':
					$this->update_payrate();
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
	
	/**
	*    @desc This is a function to update a specific payrate based on the payrate ID
	*    @name update_payrate
	*    @access public
	*    @param null
	*    @return none
	*    
	*/
	
	
	function update_payrate()
	{
		//print_r($_POST);
		$id = $_POST['id'];
		$hp = array();
		for($i=0;$i<24;$i++)
		{
			$hp['monday-'.$i.'-staff'] = $_POST['monday-'.$i.'-staff'];
			$hp['tuesday-'.$i.'-staff'] = $_POST['tuesday-'.$i.'-staff'];
			$hp['wednesday-'.$i.'-staff'] = $_POST['wednesday-'.$i.'-staff'];
			$hp['thursday-'.$i.'-staff'] = $_POST['thursday-'.$i.'-staff'];
			$hp['friday-'.$i.'-staff'] = $_POST['friday-'.$i.'-staff'];
			$hp['saturday-'.$i.'-staff'] = $_POST['saturday-'.$i.'-staff'];
			$hp['sunday-'.$i.'-staff'] = $_POST['sunday-'.$i.'-staff'];
			
			$hp['monday-'.$i.'-client'] = $_POST['monday-'.$i.'-client'];
			$hp['tuesday-'.$i.'-client'] = $_POST['tuesday-'.$i.'-client'];
			$hp['wednesday-'.$i.'-client'] = $_POST['wednesday-'.$i.'-client'];
			$hp['thursday-'.$i.'-client'] = $_POST['thursday-'.$i.'-client'];
			$hp['friday-'.$i.'-client'] = $_POST['friday-'.$i.'-client'];
			$hp['saturday-'.$i.'-client'] = $_POST['saturday-'.$i.'-client'];
			$hp['sunday-'.$i.'-client'] = $_POST['sunday-'.$i.'-client'];
		}
		$data['hour_payrate'] = json_encode($hp);
		$this->payrate_model->update_payrate($id, $data);
		$this->session->set_flashdata('payrate_just_updated',$id);
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