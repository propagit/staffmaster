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
		$this->load->model('payrate_model');
		$this->load->model('venue_model');
		$this->load->model('uniform_model');
		$this->load->model('group_model');
	}
		
	function add_payrate() {
		$input = $this->input->post();
		if (!$input['name']) {
			echo json_encode(array('ok' => false, 'error_id' => 'name'));
			return;
		}
		if (!$input['staff_rate'] || !is_numeric($input['staff_rate'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'staff_rate'));
			return;
		}
		if (!$input['client_rate'] || !is_numeric($input['client_rate'])) {
			echo json_encode(array('ok' => false, 'error_id' => 'client_rate'));
			return;
		}
		
		$payrate_id = $this->payrate_model->insert_payrate(array('name' => $input['name']));
		$rate = array();
		$rate[0] = $input['staff_rate'];
		$rate[1] = $input['client_rate'];
		for($type=0; $type <=1; $type++) {
			for($day=1; $day <=7; $day++) {
				for($hour=0; $hour <=23; $hour++) {
					$data = array(
						'payrate_id' => $payrate_id,
						'type' => $type,
						'day' => $day,
						'hour' => $hour,
						'value' => $rate[$type]
					);
					$this->payrate_model->insert_payrate_data($payrate_id, $data);
				}
			}
		}
		$count = count($this->payrate_model->get_payrates());
		if ($count == 1)
		{
			echo json_encode(array('ok' => true, 'reload' => true));
			return;
		}
		echo json_encode(array('ok' => true, 'reload' => false, 'payrate_id' => $payrate_id));
	}
	
	function load_nav_payrates() {
		$data['payrates'] = $this->payrate_model->get_payrates();
		$data['payrate_id'] = $this->input->post('payrate_id');
		$this->load->view('payrate/nav', isset($data) ? $data : NULL);
	}
	
	function load_payrates()
	{
		$data['payrate_id'] = $this->input->post('payrate_id');
		$this->load->view('payrate/data_table_view', isset($data) ? $data : NULL);
	}
	
	function update_payrates()
	{
		$payrate_id = $this->input->post('payrate_id');
		$this->payrate_model->clean_payrate_data($payrate_id);
		for($type=0; $type <=1; $type++) {
			for($day=1; $day <=7; $day++) {
				for($hour=0; $hour <=23; $hour++) {
					$data = array(
						'payrate_id' => $payrate_id,
						'type' => $type,
						'day' => $day,
						'hour' => $hour,
						'value' => $this->input->post('pr-' . $type . '-' . $day . '-' . $hour)
					);
					$this->payrate_model->insert_payrate_data($payrate_id, $data);
				}
			}
		}		
	}
	
	function update_payrate()
	{
		$value = $this->input->post('value');
		$name = $this->input->post('name');
		$fields = explode('-', $name);
		$type = $fields[1];
		$day = $fields[2];
		$hour = $fields[3];
		$this->payrate_model->update_payrate_data($this->input->post('payrate_id'), $type, $day, $hour, $value);
		echo number_format($value, 2, '.', '');
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
	
	
	// begin roles
	
	/**
	*	@desc Displayes all the available roles in the system. The user can then sort the data based on Name or Frequency.
	*
	*   @name get_roles
	*	@access public
	*	@param Post data - gets sort paramater
	*	@return Lists all roles
	*	
	*/
	function get_roles()
	{
		$params = $this->input->post('params',true);
		$data['roles'] = $this->role_model->get_roles($params);
		$data['params'] = $params;
		$this->load->view('roles/ajax_list_roles', isset($data) ? $data : NULL);
	}
	
	/**
	*	@desc Adds new role
	*
	*   @name add_role
	*	@access public
	*	@param Post data - name of the new role
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
	*	@param Post data - updated name of the role
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
	
	/**
	*	@desc Delete roles
	*	@comments Removes roles assigned to staff as well.
	*   @name delete_role
	*	@access public
	*	@param null
	*	@return 
	*	@action_required Create staff and role relationship table
	*	
	*/
	function delete_role()
	{
		$role_id = $this->input->post('role_id',true);
		$this->role_model->delete_role($role_id);
		echo 'success';
	}
	
	// end roles 
	
	// begin venues
	
	/**
	*	@desc Displayes all the available venues in the system. The user can then sort the data based on Name or Frequency.
	*
	*   @name get_roles
	*	@access public
	*	@param Post data - gets sort paramater
	*	@return Lists all roles
	*	
	*/
	function get_venues()
	{
		$params = $this->input->post('params',true);
		$data['venues'] = $this->venue_model->get_venues($params);
		$data['total_venues'] = $this->venue_model->get_venues($params,true);
		$page = json_decode($params);
		$data['current_page'] = $page->current_page;
		$this->load->view('venues/ajax_list_venues', isset($data) ? $data : NULL);
	}
	/**
	*	@desc Adds new venue
	*
	*   @name add_role
	*	@access public
	*	@param Post data - venue data, this includes name, address, suburb, postcode, location details
	*	@return 
	*	
	*/
	function add_venue()
	{		
		$input = $this->input->post();
		if (!$input['name']) {
			echo json_encode(array('ok' => false, 'error_id' => 'name'));
			return;
		}
		if (!$input['address']) {
			echo json_encode(array('ok' => false, 'error_id' => 'address'));
			return;
		}
		if (!$input['suburb']) {
			echo json_encode(array('ok' => false, 'error_id' => 'suburb'));
			return;
		}
		
		if (!$input['parent_location_id']) {
			echo json_encode(array('ok' => false, 'error_id' => 'parent_location_id'));
			return;
		}
		
		
		if(isset($input['location_id'])){
			if($input['location_id'] != ''){
				$location_id = $input['location_id'];	
			}else{
				$location_id = $input['parent_location_id'];	
			}
		}else{
			$location_id = $input['parent_location_id'];	
		}
		# get location info to know state
		$location = modules::run('attribute/location/get_location', $location_id);
		$venue_id = $this->venue_model->insert_venue(array(
				'location_id' => $location_id,
				'name' => $input['name'], 
				'address' => $input['address'],
				'suburb' => $input['suburb'],
				'postcode' => $input['postcode'],
				'state' => $location['state']
			));
		$clients = $this->venue_model->get_clients();
		foreach($clients as $client) {
			$this->venue_model->restrict_client(array(
				'user_id' => $client['user_id'],
				'venue_id' => $venue_id
			));
		}
		echo json_encode(array('ok' => true));
	}
	/**
	*	@desc Edit Venue
	*
	*   @name edit_role
	*	@access public
	*	@param Post data - updated name of the role
	*	@return 
	*	
	*/
	function edit_venue()
	{
		$data = $this->input->post();
		if(isset($data['location_id'])){
			if($data['location_id'] != ''){
				$location_id = $data['location_id'];	
			}else{
				$location_id = $data['parent_location_id_editing'];	
			}
		}else{
			$location_id = $data['parent_location_id_editing'];	
		}
		//get location info to know state
		$location = modules::run('attribute/location/get_location',$location_id);
		$this->venue_model->update_venue($data['venue_id'], array(
				'location_id' => $location_id,
				'name' => $data['name'], 
				'address' => $data['address'],
				'suburb' => $data['suburb'],
				'postcode' => $data['postcode'],
				'state' => $location['state']
			)); 
		echo 'success';
	}
	
	/**
	*	@desc Delete roles
	*	@comments Removes roles assigned to staff as well.
	*   @name delete_role
	*	@access public
	*	@param null
	*	@return 
	*	@action_required Create staff and role relationship table
	*	
	*/
	function delete_venue()
	{
		$venue_id = $this->input->post('venue_id',true);
		$this->venue_model->delete_venue($venue_id);
		echo 'success';
	}
	/**
	*	@desc Load current locations while editing venues
	*   @name load_current_locations
	*	@access public
	*	@param null
	*	@return 
	*	
	*/
	function load_current_locations()
	{
		$location_parent_id = $this->input->post('location_parent_id',true);
		$location_id = $this->input->post('location_id',true);
		if($location_parent_id == 1 || $location_parent_id == 2){
			$parent_selected = $location_id;
			$child_selected = 0;
		}else{
			$parent_selected = $location_parent_id;	
			$child_selected = $location_id;
		}
		echo modules::run('attribute/location/field_select','parent_location_id_editing',$parent_selected,$child_selected);	
	}
	
	// end venue
	
	// begin uniform
	/**
	*	@desc Displayes all the available uniform in the system. The user can then sort the data based on Name.
	*
	*   @name get_uniforms
	*	@access public
	*	@param Post data - gets sort paramater
	*	@return Lists all uniforms
	*	
	*/
	function get_uniforms()
	{
		$params = $this->input->post('params',true);
		$data['uniforms'] = $this->uniform_model->get_uniforms($params);
		$this->load->view('uniform/ajax_list_uniforms', isset($data) ? $data : NULL);
	}
	/**
	*	@desc Adds new uniform
	*
	*   @name add_uniform
	*	@access public
	*	@param Post data - New uniform details
	*	@return 
	*	
	*/
	function add_uniform()
	{
		$data = $this->input->post();
		$this->uniform_model->insert_uniform($data);
		echo 'success';
	}
	/**
	*	@desc Edit Uniform
	*
	*   @name edit_uniform
	*	@access public
	*	@param Post data - updated uniform data
	*	@return 
	*	
	*/
	function edit_uniform()
	{
		$data = $this->input->post();
		$this->uniform_model->update_uniform($data['uniform_id'], $data);
		echo 'success';
	}
	/**
	*	@desc Delete Uniform
	*	@comments Removes uniform 
	*   @name delete_uniform
	*	@access public
	*	@param null
	*	@return 
	*	
	*/
	function delete_uniform()
	{
		$uniform_id = $this->input->post('delete_id',true);
		$this->uniform_model->delete_uniform($uniform_id);
		echo 'success';
	}
	
	//end uniform
	
	
	//begin groups
	
	/**
	*	@desc Displayes all the available groups in the system. The user can then sort the data based on Name or Frequency.
	*
	*   @name get_roles
	*	@access public
	*	@param Post data - gets sort paramater
	*	@return Lists all roles
	*	
	*/
	function get_groups()
	{
		$params = $this->input->post('params',true);
		$data['groups'] = $this->group_model->get_groups($params);
		$data['params'] = $params;
		$this->load->view('groups/ajax_list_groups', isset($data) ? $data : NULL);
	}
	/**
	*	@desc Adds new group
	*
	*   @name add_role
	*	@access public
	*	@param Post data - name of the new group
	*	@return 
	*	
	*/
	function add_group()
	{
		$data = $this->input->post();
		$this->group_model->insert_group($data);
		echo 'success';
	}
	/**
	*	@desc Edit new group
	*
	*   @name add_role
	*	@access public
	*	@param Post data - name of the new group
	*	@return 
	*	
	*/
	function edit_group()
	{
		$data = $this->input->post();
		$this->group_model->update_group($data['group_id'], $data);
		echo 'success';
	}
	/**
	*	@desc Delete Group
	*	@comments Removes Group 
	*   @name delete_group
	*	@access public
	*	@param null
	*	@return 
	*	
	*/
	function delete_group()
	{
		$group_id = $this->input->post('delete_id',true);
		$this->group_model->delete_group($group_id);
		echo 'success';
	} 
	//end groups
	
	
}