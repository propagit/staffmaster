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
	}
		
	function add_payrate()
	{
		$payrate_id = $this->payrate_model->insert_payrate(array('name' => $this->input->post('name')));
		$rate = array();
		$rate[0] = $this->input->post('staff_rate');
		$rate[1] = $this->input->post('client_rate');
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
		echo $payrate_id;
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
	
	function delete_role()
	{
		$role_id = $this->input->post('role_id',true);
		$this->role_model->delete_role($role_id);
		echo 'success';
	}
	 
	
	
}