<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Common
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
	}
	
	
	function get_locations()
	{
		$locations = $this->location_model->get_locations($this->input->post('location_id'));
		if ($this->input->post('location_id') && count($locations) > 0)
		{
			$array = array();
			foreach($locations as $location)
			{
				$array[] = array(
					'value' => $location['location_id'],
					'label' => $location['name']
				);
			}
			echo modules::run('common/field_select', $array, 'location_id');
		}
		
	}
	
}