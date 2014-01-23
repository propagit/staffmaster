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
			case 'add':
					$this->add_venue();
				break;
			case 'edit':
					$this->edit_venue();
				break;
			case 'delete':
					$this->delete_venue($param);
				break;
			case 'sort':
					$this->sort_venues();
				break;
			default:
					$this->list_venues();
				break;
		}
	}
	
	function list_venues()
	{
		$sort_venue = (bool) $this->session->userdata('sort_venue');
		$data['venues'] = $this->venue_model->get_venues($sort_venue);
		$this->load->view('list_venues', isset($data) ? $data : NULL);
	}
	
	function sort_venues()
	{
		if (!$this->session->userdata('sort_venue'))
		{
			$this->session->set_userdata('sort_venue', 1);
		}
		else
		{
			$this->session->unset_userdata('sort_venue');
		}
		redirect('attribute/venue');
	}
	
	function add_venue()
	{
		$data = $this->input->post();
		$this->venue_model->insert_venue(array(
				'location_id' => $data['location_id'],
				'name' => $data['name'], 
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'postcode' => $data['postcode']
			));
		redirect('attribute/venue');
	}
	
	function edit_venue()
	{
		$data = $this->input->post();
		$this->venue_model->update_venue($data['venue_id'], array(
				'location_id' => $data['location_id_edit'],
				'name' => $data['name'], 
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'postcode' => $data['postcode']
			));
		redirect('attribute/venue');
	}
	
	function delete_venue($venue_id)
	{
		$this->venue_model->delete_venue($venue_id);
		redirect('attribute/venue');
	}
	
	function display_venue($venue_id)
	{
		$venue = $this->get_venue($venue_id);
		echo ($venue) ? $venue['name'] : 'Not Specified';
	}
	function get_venue($venue_id)
	{
		return $this->venue_model->get_venue($venue_id);
	}
	function get_venue_by_name($name)
	{
		return $this->venue_model->get_venue_by_name($name);
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
	
}