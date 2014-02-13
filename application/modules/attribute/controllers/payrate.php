<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Attribute Pay Rate
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
			case 'edit':
					$this->edit_payrate();
				break;
			case 'delete':
					$this->delete_payrate($param);
				break;
			default:
					$this->list_payrates();
				break;
		}
	}
	
	/**
	*    @desc This is a function to build the payrate table, to tune the speed of page loading
	*    @name build_payrate
	*    @access public
	*    @param id
	*    @return built table
	*    
	*/
	
	function list_payrates()
	{
		$data['payrates'] = $this->payrate_model->get_payrates();
		$this->load->view('payrate/main_view', isset($data) ? $data : NULL);
	}
	
	function get_payrate_data($payrate_id, $type, $day, $hour)
	{
		return $this->payrate_model->get_payrate_data($payrate_id, $type, $day, $hour);
	}
	

	function get_payrates($format=null)
	{
		$payrates = $this->payrate_model->get_payrates();
		if (!$format) {
			return $payrates;
		}
		if ($format == 'data_source')
		{
			$data_source = array();
			foreach($payrates as $payrate)
			{
				$data_source[] = '{value:' . $payrate['payrate_id'] . ', text: \'' . $payrate['name'] . '\'}';
			}
			$data_source = implode(",", $data_source);
			return $data_source;
		}	
	}
	
	function field_select($field_name, $field_value=null)
	{
		$payrates = $this->payrate_model->get_payrates();
		$array = array();
		foreach($payrates as $payrate) {
			$array[] = array(
				'value' => $payrate['payrate_id'],
				'label' => $payrate['name']
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	function display_payrate($payrate_id)
	{
		$payrate = $this->get_payrate($payrate_id);
		echo ($payrate) ? $payrate['name'] : 'Not Specified';
	}
	
	function get_payrate($payrate_id)
	{
		return $this->payrate_model->get_payrate($payrate_id);
	}
}