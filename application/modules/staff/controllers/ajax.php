<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('staff_model');
	}
	
	function search_staffs()
	{
		$data['staffs'] = $this->staff_model->search_staffs($this->input->post());
		$this->load->view('search_results', isset($data) ? $data : NULL);		
	}
	
	function add_staff()
	{
		
	}
	
	/**
	*	@name: update_staff
	*	@desc: abstract function to update staff profile
	*	@access: public
	*	@param: (int) $user_id, (string) $tab
	*	@return: (view) of different update form depends on selected tab
	*/
	function update_staff($user_id, $tab)
	{
		$data['staff'] = $this->staff_model->get_staff($user_id);
		$this->load->view('edit_' . $tab, isset($data) ? $data : NULL);
	}
	
	/**
	*
	*
	*
	*
	*
	*/
	function add_location() {		
		$parent_id = $this->input->post('location_parent_id');
		if (!$parent_id) {
			echo json_encode(array('ok' => false));
			return;
		}
		$location_id = $this->input->post('location_id');
		
		
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$locations = json_decode($staff['locations']);
		
		foreach($locations as $parent_id => $children)
		{
			
		}
		
		$data = array();
		$location = array();
		
		if (!$location_id) { # Select all locations within location_parent_id
			$all = modules::run('attribute/location/get_locations', $parent_id);
			foreach($all as $a) {
				$location[] = $a['location_id'];
			}
		}
		else
		{
			$location[] = $location_id;
		}
		$data[$parent_id] = $location;
		$this->staff_model->update_staff($staff['user_id'], array('locations' => json_encode($data)));
	}
	
	function load_locations()
	{
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$data['locations'] = json_decode($staff['locations']);
		$this->load->view('staff_locations', isset($data) ? $data : NULL);
	}
	
	
	function list_staffs($query='')
	{
		$staffs = $this->staff_model->search_staffs(array('keyword' => $query));
		$out = array();
		
		foreach($staffs as $staff)
		{
			$out[] = array(
				'id' => $staff['user_id'],
				'name' => $staff['first_name'] . ' ' . $staff['last_name'],
				'username' => $staff['username']
			);
		}
		//$this->output->set_content_type('application/json');
		echo json_encode($out);
	}

}