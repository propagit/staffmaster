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
		$this->load->model('user/user_model');
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
	
	function update_personal()
	{
		$data = $this->input->post();
		$user_data = array(
			'password' => $data['password'],
			'title' => $data['title'],
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'address' => $data['address'],
			'suburb' => $data['suburb'],
			'city' => $data['city'],
			'state' => $data['state'],
			'postcode' => $data['postcode'],
			'country' => $data['country'],
			'phone' => $data['phone'],
			'modified_on' => date('Y-m-d H:i:s')
		);
		$this->user_model->update_user($data['user_id'], $user_data);
		$staff_data = array(
			'rating' => $data['rating'],
			'external_staff_id' => $data['external_staff_id'],
			'gender' => $data['gender'],
			#'dob' => $data['dob_day'] . '-' . $data['dob_month'] . '-' . $data['dob_year'],
			'group_id' => $data['group_id'],
			'emergency_contact' => $data['emergency_contact'],
			'emergency_phone' => $data['emergency_phone'],
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
		echo modules::run('common/field_rating', 'rating', $data['rating']);
	}
	
	function update_financial()
	{
		$data = $this->input->post();
		$staff_data = array(
			'f_aus_resident' => isset($data['f_aus_resident']) ? $data['f_aus_resident'] : 0,
			'f_tax_free_threshold' => isset($data['f_tax_free_threshold']) ? $data['f_tax_free_threshold'] : 0,
			'f_tax_offset' => isset($data['f_tax_offset']) ? $data['f_tax_offset'] : 0,
			'f_senior_status' => isset($data['f_senior_status']) ? $data['f_senior_status'] : '',
			'f_help_debt' => isset($data['f_help_debt']) ? $data['f_help_debt'] : 0,
			'f_help_variation' => isset($data['f_help_variation']) ? $data['f_help_variation'] : '',
			'f_acc_name' => $data['f_acc_name'],
			'f_bsb' => $data['f_bsb'],
			'f_acc_number' => $data['f_acc_number'],
			'f_tfn' => $data['f_tfn'],
			'f_employed' => $data['f_employed'],
			'f_abn' => $data['f_abn']
		);
		$this->staff_model->update_staff($data['user_id'], $staff_data);
	}
	
	function update_roles()
	{
		$user_id = $this->input->post('user_id');
		$roles = $this->input->post('roles');
		$this->staff_model->update_staff($user_id, array('roles' => json_encode($roles)));
	}
	
	/**
	*	@name: add_location
	*	@desc: ajax function to add location of staff
	*	@access: public
	*	@param: (via POST) 
	*			- (int) location_parent_id
	*			- (int) location_id
	*			- (int) user_id
	*	@return: json encode array {ok: (true/false)}
	*/
	function add_location() {		
		$parent_id = $this->input->post('location_parent_id');
		if (!$parent_id) {
			echo json_encode(array('ok' => false));
			return;
		}
		$location_id = $this->input->post('location_id');
		
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
		
		
		# Now merging with current locations data
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$locations = json_decode($staff['locations']);
		
		if (count($locations) > 0) foreach($locations as $o_parent_id => $o_childrens)
		{
			if ($o_parent_id != $parent_id) # Adding old parent locations
			{
				$data[$o_parent_id] = $o_childrens;
			}
			else
			{
				if (!$location_id)
				{
					$data[$parent_id] = $location;
				}
				else if (!in_array($location_id, $o_childrens))
				{
					$data[$parent_id] = array_merge($o_childrens, $location);
				}
				else
				{
					$data[$parent_id] = $o_childrens;
				}
			}
		}
		
		$this->staff_model->update_staff($staff['user_id'], array('locations' => json_encode($data)));
		echo json_encode(array('ok' => true));
	}
	
	/**
	*	@name: remove_location
	*	@desc: ajax function to remove location of staff
	*	@access: public
	*	@param: (via POST)
	*			- (int) parent_id
	*			- (int) location_id
	*			- (int) user_id
	*	@return: (void)
	*/
	function remove_location() {
		var_dump($this->input->post());
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$parent_id = $this->input->post('parent_id');
		$location_id = $this->input->post('location_id');
		$locations = json_decode($staff['locations']);
		
		$data = array();
		if (!$location_id)
		{
			foreach($locations as $o_parent_id => $childrens)
			{
				if ($o_parent_id != $parent_id)
				{
					$data[$o_parent_id] = $childrens;
				}
			}
		}
		else
		{
			foreach($locations as $o_parent_id => $childrens)
			{
				$new_locations = array();
				foreach($childrens as $child)
				{
					if ($child != $location_id) {
						$new_locations[] = $child;
					}
				}
				$data[$o_parent_id] = $new_locations;
			}
			
		}
		$this->staff_model->update_staff($staff['user_id'], array('locations' => json_encode($data)));
	}
	
	/**
	*	@name: load_locations
	*	@desc: ajax function to load staff locations view
	*	@access: public
	*	@param: (via POST) (int) user_id
	*	@return: (view) staff locations
	*/
	function load_locations()
	{
		$staff = $this->staff_model->get_staff($this->input->post('user_id'));
		$data['staff'] = $staff;
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