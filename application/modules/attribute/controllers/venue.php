<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Venue extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('venue_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'import':
					$this->import_view();
				break;
			default:
					$this->list_venues();
				break;
		}
	}
	
	function list_venues()
	{
		$this->load->view('venues/list_venues', isset($data) ? $data : NULL);
	}
	
	function import_view()
	{
		$this->load->view('venues/import_view', isset($data) ? $data : NULL);
	}

	function display_venue($venue_id)
	{
		$venue = $this->get_venue($venue_id);
		echo ($venue) ? $venue['name'] : 'Not Specified';
	}
	function display_map($venue_id)
	{
		$data['venue'] = $this->venue_model->get_venue($venue_id);
		$this->load->view('venue_map', isset($data) ? $data : NULL);
	}
	function get_venue($venue_id)
	{
		return $this->venue_model->get_venue($venue_id);
	}
	function get_venue_by_name($name)
	{
		return $this->venue_model->get_venue_by_name($name);
	}
	
	function field_input($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['venues'] = $this->venue_model->all_venues();
		if ($field_value) {
			$venue = $this->venue_model->get_venue($field_value);
			if ($venue) {
				$field_value = $venue['name'];
			}
		}
		$data['field_value'] = $field_value;
		$this->load->view('venues/field_input', isset($data) ? $data : NULL);
	}
	
	function dropdown($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['venues'] = $this->venue_model->get_venues(true);
		$this->load->view('dropdown_venues', isset($data) ? $data : NULL);
	}
	
	function get_venues($format=null)
	{
		$venues = $this->venue_model->get_venues();
		if (!$format) {
			return $venues;
		}
		if ($format == 'data_source')
		{
			$data_source = array();
			foreach($venues as $venue)
			{
				$data_source[] = '\'' . $venue['name'] . '\'';
			}
			$data_source = implode(",", $data_source);
			return $data_source;
		}		
	}
	
	function field_select_fields($field_name, $field_value=null)
	{
		$fields = array(
			array('value' => 'name', 'label' => 'Name'),
			array('value' => 'address', 'label' => 'Address'),
			array('value' => 'suburb', 'label' => 'Suburb'),
			array('value' => 'postcode', 'label' => 'Postcode'),
			array('value' => 'location', 'label' => 'Location'),
			array('value' => 'area', 'label' => 'Area')
		);
		echo modules::run('common/field_select', $fields, $field_name, $field_value);
	}
}