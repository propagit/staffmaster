<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Common ajax controller
*	@class_comments
*
*
*/

class Ajax extends MX_Controller {

	function load_venue_map($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('venue_map', isset($data) ? $data : NULL);
	}

	function map($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('map', isset($data) ? $data : NULL);
	}

	function get_states()
	{
		$states = modules::run('common/get_states');
		echo json_encode($states);
	}

	function get_roles()
	{
		$roles = modules::run('attribute/role/get_roles');
		echo json_encode($roles);
	}

	function get_groups()
	{
		$groups = modules::run('attribute/group/get_groups');
		echo json_encode($groups);
	}

}
