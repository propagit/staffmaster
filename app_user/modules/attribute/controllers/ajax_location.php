<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Ajax controller for attributes. 
*	@class_comments The custom attributes is not included in this module. It is located under the module - formbuilder
*
*/

class Ajax_location extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
	}
	
	/**
	*	@name: get_locations
	*	@desc: ajax function to display custom location select field
	*	@access: public
	*	@param: (via POST) location_id
	*	@return: custom select field for location
	*/
	function get_locations()
	{
		$locations = $this->location_model->get_locations($this->input->post('location_id'));
		$location_id = $this->input->post('location_id');
		$child_selected = $this->input->post('child_selected');
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
			echo modules::run('common/field_select', $array, 'location_id', $child_selected);
		}
		
	}	
}