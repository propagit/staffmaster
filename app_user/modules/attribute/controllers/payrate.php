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
	
	function extract_payrate($object) {
		$payrate_id = $object['payrate_id'];
		$start_time = $object['start_time'];
		$finish_time = $object['finish_time'];
		$rates = array();
		for($i=$start_time; $i < $finish_time; $i = $i + 60*15) { # Every 15 minutes
			$day = date('N', $i); # Get day of the week	(1: monday - 7: sunday)
			$hour = date('G', $i); # Get hour of the day (0-23)
			$staff_rate = $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour);
			if (!in_array($staff_rate, $rates)) {
				$rates[] = $staff_rate;
			}
		}
		$hours = array();
		foreach($rates as $rate) {
			$hours[$rate] = 0;
			for($i=$start_time; $i < $finish_time; $i = $i + 60*15) { # Every 15 minutes
				$day = date('N', $i); # Get day of the week	(1: monday - 7: sunday)
				$hour = date('G', $i); # Get hour of the day (0-23)
				$staff_rate = $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour);
				if ($staff_rate == $rate) {
					$hours[$rate] += 15; 
				}
			}
		}
		$breaks = json_decode($object['break_time']);
		if (count($breaks) > 0) {
			foreach($breaks as $break)
			{
				$length = $break->length;
				$start_at = $break->start_at;
				foreach($rates as $rate) {
					for($i=0; $i < $length; $i = $i + 60*15) { # Every 15 minute
						$start_at = $start_at + $i;
						$day = date('N', $i);
						$hour = date('G', $i);
						$staff_rate = $this->payrate_model->get_payrate_data($payrate_id, 0, $day, $hour);
						if ($staff_rate == $rate) {
							$hours[$rate] -= 15;
						}
					}
				}
				
			}
		}
		return $hours;
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
	
	function get_minimum_payrate($payrate_id,$payrate_type = 0)
	{
		return $this->payrate_model->get_minimum_payrate($payrate_id,$payrate_type);	
	}
}