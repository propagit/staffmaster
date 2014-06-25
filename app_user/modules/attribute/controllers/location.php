<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Location extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
					$this->add_location();
				break;
			case 'edit':
					$this->edit_location();
				break;
			case 'delete':
					$this->delete_location($param);
				break;
			case 'sort':
					$this->sort_locations($param);
				break;
			default:
					$this->list_locations();
				break;
		}
	}
	
	function list_locations()
	{
		$sort_location_state = (bool) $this->session->userdata('sort_location_state');
		$sort_location_name = (bool) $this->session->userdata('sort_location_name');
		$data['locations'] = $this->location_model->get_locations($sort_location_state, $sort_location_name);
		$this->load->view('list_locations', isset($data) ? $data : NULL);
	}
	
	function sort_locations($param)
	{
		if (!$this->session->userdata('sort_location_' . $param))
		{
			$this->session->set_userdata('sort_location_' . $param, 1);
		}
		else
		{
			$this->session->unset_userdata('sort_location_' . $param);
		}
		redirect('attribute/location');
	}
	
	function add_location()
	{
		$data = $this->input->post();
		$this->location_model->insert_location($data);
		redirect('attribute/location');
	}
	
	function edit_location()
	{
		$data = $this->input->post();
		$this->location_model->update_location($data['location_id'], array('name' => $data['name'], 'state' => $data['state_edit']));
		redirect('attribute/location');
	}
	
	function delete_location($location_id)
	{
		$this->location_model->delete_location($location_id);
		redirect('attribute/location');
	}
	
	function display_location($location_id)
	{
		(string) $output = null;
		$location = $this->location_model->get_location($location_id);
		if (!$location) {
			return 'Not available';
		}
		$output = $location['name'];
		
		if ($location['parent_id'] != 0)
		{
			$parent = $this->location_model->get_location($location['parent_id']);
			if(trim($parent['name']) != 'Major Cities' &&  trim($parent['name']) != 'Regional'){
				$output .= ' - ' . $parent['name'];
			}
		}
		
		return $output;
	}
	
	function get_location($location_id)
	{
		return $this->location_model->get_location($location_id);
	}
	
	function get_locations($parent_id=null)
	{
		return $this->location_model->get_locations($parent_id);
	}
	
	function get_location_by_name($name)
	{
		return $this->location_model->get_location_by_name($name);
	}
	
	function get_child_location_by_name($parent_id, $name)
	{
		return $this->location_model->get_child_location_by_name($parent_id, $name);
	}
	
	function field_select($field_name, $field_value=null,$child_value=null, $size=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['child_value'] = $child_value;
		$data['size'] = $size;
		$data['parents'] = $this->location_model->get_locations(0);
		$this->load->view('location/field_select', isset($data) ? $data : NULL);
	}
	
	# Improve field input for location
	function field_input($field_name, $field_value=null,$size=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['size'] = $size;
		$data['child_value'] = '';
		$data['parents'] = $this->location_model->get_locations(0);
		$this->load->view('location/field_input', isset($data) ? $data : NULL);
	}
}