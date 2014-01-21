<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Common extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
	}
	
	function dropdown_actions($field_name, $field_value=null)
	{
		$this->load->view('dropdown_actions', isset($data) ? $data : NULL);
	}
	
	function dropdown_status($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_status', isset($data) ? $data : NULL);
	}
		
	function list_supers()
	{
		$supers = $this->common_model->get_supers();
		foreach($supers as $super) { echo '"' . $super['name'] . '",'; } 
	}
	
	function check_super($name)
	{
		$supers = $this->common_model->get_supers();
		$found = false;
		foreach($supers as $super)
		{
			if ($super['name'] == $name)
			{
				$found = true;
			}
		}
		return $found;
	}
	
	function dropdown_states($field_name, $field_value=null)
	{
		$data['states'] = $this->common_model->get_states();
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_states', isset($data) ? $data : NULL);
	}
	
	function dropdown_countries($field_name, $field_value=null)
	{
		$data['countries'] = $this->common_model->get_countries();
		$data['field_name'] = $field_name;
		if ($field_value == null || $field_value=='')
		{
			$field_value = 'AU';
		}
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_countries', isset($data) ? $data : NULL);
	}
	
	function dropdown_titles($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_titles', isset($data) ? $data : NULL);
	}
	
	function dropdown_genders($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_genders', isset($data) ? $data : NULL);
	}
	
	function dropdown_dob($day=null, $month=null, $year=null)
	{
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('dropdown_dob', isset($data) ? $data : NULL);
	}
	
	function break_time($string)
	{
		$a = unserialize($string);
		if ($a['length'] > 0) 
		{
			echo $a['length']/60 . ' mins';
		}
		else
		{
			echo 0;
		}
	}
	
}