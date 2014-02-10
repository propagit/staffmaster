<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc Ajax controller for attributes. 
*	@class_comments The custom attributes is not included in this module. It is located under the module - formbuilder
*
*/

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('location_model');
		$this->load->model('role_model');
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
	
	
	/**
	*	@desc Get the roles in the system
	*
	*   @name get_roles
	*	@access public
	*	@param null
	*	@return list of roles
	*	
	*/
	function get_roles()
	{
		$params = $this->input->post('params',true);
		$data['roles'] = $this->role_model->get_roles($params);
		$this->load->view('roles/ajax_list_roles', isset($data) ? $data : NULL);
	}
	
	/**
	*	@desc Add new role
	*
	*   @name add_role
	*	@access public
	*	@param null
	*	@return 
	*	
	*/
	function add_role()
	{
		$data['name'] = $this->input->post('name',true);
		$this->role_model->insert_role($data);
		echo 'success';
	}
	
	/**
	*	@desc Edit role
	*
	*   @name edit_role
	*	@access public
	*	@param null
	*	@return 
	*	
	*/
	function edit_role()
	{
		$data['name'] = $this->input->post('new_name',true);
		$edit_id = $this->input->post('role_id',true);
		$this->role_model->update_role($edit_id, $data);
		echo 'success';
	}
	 
	
	
}