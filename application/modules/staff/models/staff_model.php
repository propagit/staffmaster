<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_model extends CI_Model {
	
	var $module = 'staff';
	var $object = 'staff';
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('log/log_model');
	}
	
	function prepare_staff_data($data)
	{
				
		return $data;
	}
	
	/**
	*	@name: insert_staff
	*	@desc: create a new staff
	*	@access: public
	*	@param: $data = array()
	*	@return: $staff_id
	*/
	function insert_staff($data)
	{
		$data = $this->prepare_staff_data($data);
		$this->db->insert('user_staffs', $data);
		$staff_id = $this->db->insert_id();
		if (isset($data['user_id']))
		{
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $data['user_id'],
				'action' => 'create'
			);
			$this->log_model->insert_log($log_data);
		}		
		return $staff_id;
	}
	
	/**
	*	@name: update_staff
	*	@desc: update staff information
	*	@access: public
	*	@param: $user_id, $data = array()
	*	@return: (boolean)
	*/
	function update_staff($user_id, $data = array())
	{
		$data = $this->prepare_staff_data($data);
		if (count($data) > 0)
		{
			$description = '';
			if (isset($data['update_description'])) 
			{
				$description = $data['update_description'];
				unset($data['update_description']);
			}
			$log_data = array(
				'module' => $this->module,
				'object' => $this->object,
				'object_id' => $user_id,
				'action' => 'update',
				'description' => $description
			);
			$this->log_model->insert_log($log_data);
		}
		$this->db->where('user_id', $user_id);
		return $this->db->update('user_staffs', $data);
	}
	
	/**
	*	@name: delete_staff
	*	@desc: delete a staff account (update user status to 'Deleted')
	*	@access: public
	*	@param: $user_id
	*	@return: (boolean)
	*/
	function delete_staff($user_id)
	{
		$log_data = array(
			'module' => $this->module,
			'object' => $this->object,
			'object_id' => $user_id,
			'action' => 'delete'
		);
		$this->log_model->insert_log($log_data);
		$this->user_model->delete_user($user_id);
	}
	
	
	function search_staff_by_name($keyword='') 
	{
		$sql = "SELECT * FROM users 
				WHERE status = " . STAFF_ACTIVE . " 
				AND  is_staff=1";
		if ($keyword != '') {
			$sql .= " AND CONCAT(first_name, ' ', last_name) LIKE '%" . $keyword . "%'";
		}
		$sql .= " ORDER BY first_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	*	@name: check_staff_time_collision
	*	@desc: check staff double booking at the same time
	*	@access: public
	*	@param: (int) $staff_id, (array) $shift
	*	@return: (boolean) true if collide, false if not collide
	*/
	function check_staff_time_collision($staff_id, $shift)
	{
		$start_time = $shift['start_time'];
		$finish_time = $shift['finish_time'];
		$sql = "SELECT * FROM job_shifts
							WHERE shift_id != " . $shift['shift_id'] . "
							AND status != " . SHIFT_DELETED . "
							AND staff_id = $staff_id 
							AND job_date = '" . $shift['job_date'] . "'
							AND ((start_time >= $start_time AND start_time < $finish_time) 
									OR (finish_time > $start_time AND finish_time <= $finish_time)
									OR (start_time <= $start_time AND finish_time >= $finish_time))";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}
	
	/**
	*	@name: check_staff_time_availability
	*	@desc: check if staff available to work for a particular shift
	*	@access: public
	*	@param: (int) $staff_id, (array) $shift
	*	@return: (boolean) true if available, false if not available
	*/
	function check_staff_time_availability($staff_id, $shift)
	{
		$day = date('N', $shift['start_time']);
		$start_hour = date('G', $shift['start_time']);
		$finish_hour = date('G', $shift['finish_time']);
		$sql = "SELECT * FROM user_staff_availability
						WHERE user_id = $staff_id 
						AND day = $day
						AND value = 0";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		if ($finish_hour <= $start_hour)
		{
			$finish_hour = 23;
		}
		foreach($results as $result)
		{
			if ($result['hour'] >= $start_hour && $result['hour'] <= $finish_hour)
			{
				return false;
			}
		}
		return true;
	}
		
	function search_staffs($params = array(),$total=false)
	{
		$records_per_page = STAFF_PER_PAGE;
		$sql = "SELECT s.*, u.* 
				FROM user_staffs s 
				LEFT JOIN users u ON s.user_id = u.user_id WHERE u.status > " . USER_DELETED;
		
		if (isset($params['keyword']) && $params['keyword'] != '') 
		{ 
			$sql .= " AND (u.first_name LIKE '%" . $params['keyword'] . "%' 
							OR u.last_name LIKE '%" . $params['keyword'] . "%' 
							OR CONCAT(u.first_name,' ', u.last_name) LIKE '%" . $params['keyword'] . "%')"; 
		}
		if (isset($params['rating']) && $params['rating'] != '')
		{ 
			$sql .= " AND s.rating >= " . $params['rating'];
		}
		if (isset($params['status']) && $params['status'] != '')
		{ 
			$sql .= " AND u.status = " . $params['status'];
		}
		if (isset($params['gender']) && $params['gender'] != '')
		{ 
			$sql .= " AND s.gender = '" . $params['gender'] . "'";
		}
		if (isset($params['state']) && $params['state'] != '')
		{ 
			$sql .= " AND u.state = '" . $params['state'] . "'";
		}
		
		# Group
		if (isset($params['group_id']) && $params['group_id'] != '')
		{ 
			$sql .= " AND s.user_id IN 
						(SELECT staff_groups.user_id as sg_uid 
							FROM attribute_groups, staff_groups 
							WHERE  attribute_groups.group_id = staff_groups.attribute_group_id 
							AND group_id = " . $params['group_id'] . ")";
		}
		
		# Role
		if (isset($params['role_id']) && $params['role_id'] != '')
		{ 
			$sql .= " AND s.user_id IN 
						(SELECT staff_roles.user_id as sr_uid 
							FROM attribute_roles, staff_roles 
							WHERE attribute_roles.role_id = staff_roles.attribute_role_id 
							AND role_id = " . $params['role_id'] . ")";
		}	
		
		# Location (if location id is set use this to filter the search)
		if (isset($params['location_id']) && $params['location_id'] != '')
		{ 
			$sql .= " AND s.locations LIKE '%" . $params['location_id'] . "%'";
		}
		else
		{
			# If location id is not set use parent location id from posted data to filter the search
			if(isset($params['location_parent_id']) && $params['location_parent_id'] != '')
			{
				$sql .= " AND s.locations LIKE '%" . $params['location_parent_id'] . "%'";
			}
		}
		
		# Availability
		if (isset($params['availability']) && $params['availability'] != '')
		{ 
			$sql .= " AND s.user_id IN 
						(SELECT user_staff_availability.user_id as usa_uid 
							FROM user_staff_availability 
							WHERE day = " . $params['availability'] . "
							AND value = 1 
							GROUP BY user_id)";
		}
		
		# Age
		if(isset($params['age_groups']) && $params['age_groups'] != ''){ 
			$cur_date = date('Y-m-d');
			switch($params['age_groups']){
				case '0-17':
					$sql .= " AND s.dob > '".date('Y-m-d',strtotime('-18 years',strtotime($cur_date)))."'";
				break;	
				case '18-25':
					$sql .= " AND s.dob BETWEEN '".date('Y-m-d',strtotime('-25 years',strtotime($cur_date)))."' AND '".date('Y-m-d',strtotime('-18 years',strtotime($cur_date)))."'";
				break;	
				case '26-35':
					$sql .= " AND s.dob BETWEEN '".date('Y-m-d',strtotime('-35 years',strtotime($cur_date)))."' AND '".date('Y-m-d',strtotime('-26 years',strtotime($cur_date)))."'";
				break;	
				case '36-100':
					$sql .= " AND s.dob BETWEEN '".date('Y-m-d',strtotime('-100 years',strtotime($cur_date)))."' AND '".date('Y-m-d',strtotime('-36 years',strtotime($cur_date)))."'";
				break;	
			}
		}
		
		if (isset($params['date_from']) && $params['date_from'] != '') {
			$sql .= " AND u.modified_on >= '" . date('Y-m-d', strtotime($params['date_from'])) . "'";
		}
		if (isset($params['date_to']) && $params['date_to'] != '') {
			$sql .= " AND u.modified_on <= '" . date('Y-m-d', strtotime($params['date_to'])) . "'";
		}
		
		//Custom Attributes
		//normal elements
		$custom_attrs = modules::run('staff/get_custom_attrs',$params);
		if(isset($custom_attrs) && $custom_attrs != ''){
			
			if(isset($custom_attrs['normal_elements']) && $custom_attrs['normal_elements'] != ''){
				foreach($custom_attrs['normal_elements'] as $key => $val){
					if(is_array($val)){
						foreach($val as $v){
							$sql .= " AND s.user_id IN (SELECT user_id from staff_custom_attributes WHERE (attribute_name = '".$key."' AND attributes like '%".$v."%'))";	
						}
					}else{
						$sql .= " AND s.user_id IN (SELECT user_id from staff_custom_attributes WHERE (attribute_name = '".$key."' AND attributes = '".$val."'))";
					}
				}
			}
			//file uploads
			if(isset($custom_attrs['file_uploads']) && $custom_attrs['file_uploads'] != ''){
				foreach($custom_attrs['file_uploads'] as $key => $val){
					$match = ($val == 'yes' ? '!=' : '=');
					if($val == 'yes'){
						$sql .= " AND s.user_id IN (SELECT user_id from staff_custom_attributes WHERE (attribute_name = '".$key."' AND attributes ".$match." ''))";
					}
				}
			}
		}
		
		if(isset($params['sort_by'])){ $sql .= " ORDER BY ".$params['sort_by']." ".$params['sort_order'];}				
		if(isset($params['limit'])){ 
			//if limit is not set it will default start the pagination
			$sql .= " LIMIT " . $params['limit']; 
		}else{
			if(!$total && isset($params['current_page'])){
				$sql .= " LIMIT ".(($params['current_page']-1)*$records_per_page)." ,".$records_per_page;
			}
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
	
	function get_staff($user_id)
	{
		$sql = "SELECT s.*, u.*
				FROM user_staffs s
				LEFT JOIN users u ON s.user_id = u.user_id WHERE s.user_id = '" . $user_id . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function get_export_staff($user_id)
	{
		$sql = "SELECT u.*, s.*
				FROM users u
				LEFT JOIN user_staffs s ON s.user_id = u.user_id
				WHERE u.user_id = " . $user_id;
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	function get_staff_by_name($name) {
		$sql = "SELECT * FROM users 
				WHERE status = " . STAFF_ACTIVE . " 
				AND is_staff = 1 AND CONCAT(first_name, ' ', last_name) = '" . $name . "'";
		$query = $this->db->query($sql);
		return $query->first_row('array');
	}
	
	
	
	
	function insert_availability_data($user_id,$data)
	{
		$this->db->insert('user_staff_availability', $data);
		return $this->db->insert_id();
	}
	
	function get_availability($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_staff_availability');
		return $query->result_array();
	}
	
	function get_availability_data($user_id,$day,$hour)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		$query = $this->db->get('user_staff_availability');
		$result =$query->first_row('array');
		return $result['value'];
	}
	
	function update_available_data($user_id,$day,$hour,$value)
	{
		$this->db->where('user_id', $user_id);		
		$this->db->where('day', $day);
		$this->db->where('hour', $hour);
		return $this->db->update('user_staff_availability', array('value' => $value));
	}
	
	
	function get_all_photos($user_id)
	{
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_staff_picture');		
		return $query->result_array();
	}
	function get_hero($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('hero', 1);
		$query = $this->db->get('user_staff_picture');
		return $query->first_row('array');
	}
	function has_hero_image($user_id)
	{
		$hero = $this->get_hero($user_id);
		if($hero){
			return true;	
		}
		return false;
	}
	function get_user_staff_photo_by_photo_id($photo_id)
	{
		$this->db->where('id',$photo_id);
		$query = $this->db->get('user_staff_picture');
		return $query->row();
	}
	function delete_photo($photo_id)
	{
		$this->db->where('id',$photo_id);
		return $this->db->delete('user_staff_picture');
	}
	/**
	*	@name: get_total_staffs_count
	*	@desc: Returns total staff based on status. If status is not passed it returns the total staffs
	*	@access: public
	*	@param: string, int status
	*	@return: (int) total staff count
	*/
	function get_total_staffs_count($status='')
	{
		$sql = 'select count(staff_id) as total from user_staffs';
		if($status){
			$sql .= '';	
		}
		$total = $this->db->query($sql)->row();
		if($total){
			return $total->total;	
		}
		return 0;
	}
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name staff_has_role
	*	@access public
	*	@param null
	*	@return Returns true if this role has been assigned to staff and vice versa
	*	
	*/
	function staff_has_role($staff_user_id,$role_id)
	{
		$query = $this->db->where('user_id',$staff_user_id)->where('attribute_role_id',$role_id)->get('staff_roles')->row();
		if($query){
			return true;	
		}
		return false;
		
	}

	/**
	*	@desc This function returns the frequency of the role. It returns the number of times this role has been assigned to staffs.
	*
	*   @name get_role_frequency
	*	@access public
	*	@param null
	*	@return Return the number of times this roles has been assigned to staffs.
	*	
	*/
	
	function get_role_frequency($role_id)
	{
		$sql = "SELECT count(staff_roles_id) as total FROM `staff_roles` WHERE `attribute_role_id` = ".$role_id;
		$total = $this->db->query($sql)->row_array();
		if($total){
			return $total['total'];	
		}
		return 0;
	}
	/**
	*	@name: update_staff_role
	*	@desc: Update staff role. Adds or deletes role based on user input
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function update_staff_role($user_staff_id,$role_id)
	{
		$staff_has_role = $this->staff_has_role($user_staff_id,$role_id);
		if($staff_has_role){
			return $this->delete_staff_role($user_staff_id,$role_id);
		}else{
			return $this->add_staff_role($user_staff_id,$role_id);
		}
	}
	/**
	*	@name: add_staff_role
	*	@desc: Assign role to a staff
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function add_staff_role($user_staff_id,$role_id)
	{
		$data = array(
					'user_id' => $user_staff_id,
					'attribute_role_id' => $role_id
				);
		$this->db->insert('staff_roles', $data);
		return $this->db->insert_id();
	}
	/**
	*	@name: delete_staff_role
	*	@desc: Delete role from the staff
	*	@access: public
	*	@param: (int) role_id, (int) user_staff_id
	*	@return: null
	*/
	function delete_staff_role($user_staff_id,$role_id)
	{
		$sql = "delete from staff_roles where user_id = ".$user_staff_id." and attribute_role_id = ".$role_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name staff_has_role
	*	@access public
	*	@param null
	*	@return Returns true if this role has been assigned to staff and vice versa
	*	
	*/
	function staff_has_group($staff_user_id,$group_id)
	{
		$query = $this->db->where('user_id',$staff_user_id)->where('attribute_group_id',$group_id)->get('staff_groups')->row();
		if($query){
			return true;	
		}
		return false;
		
	}
	/**
	*	@name: update_staff_group
	*	@desc: Update staff group. Adds or deletes group based on user input
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function update_staff_group($user_staff_id,$group_id)
	{
		$staff_has_group = $this->staff_has_group($user_staff_id,$group_id);
		if($staff_has_group){
			return $this->delete_staff_group($user_staff_id,$group_id);
		}else{
			return $this->add_staff_group($user_staff_id,$group_id);
		}
	}
	/**
	*	@name: add_staff_group
	*	@desc: Assign group to a staff
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function add_staff_group($user_staff_id,$group_id)
	{
		$data = array(
					'user_id' => $user_staff_id,
					'attribute_group_id' => $group_id
				);
		$this->db->insert('staff_groups', $data);
		return $this->db->insert_id();
	}
	/**
	*	@name: delete_staff_group
	*	@desc: Delete group from the staff
	*	@access: public
	*	@param: (int) group_id, (int) user_staff_id
	*	@return: null
	*/
	function delete_staff_group($user_staff_id,$group_id)
	{
		$sql = "delete from staff_groups where user_id = ".$user_staff_id." and attribute_group_id = ".$group_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@name: delete_staff_custom_attributes
	*	@desc: Delete custom attributes of a staff
	*	@access: public
	*	@param: (int) user id of staff
	*	@return: null
	*/
	function delete_staff_custom_attributes($user_staff_id)
	{
		$sql = "delete from staff_custom_attributes where file_upload = 'no' and user_id = ".$user_staff_id;
		return $this->db->query($sql);
	}
	
	/**
	*	@name: insert_staff_custom_attributes
	*	@desc: Add custom attributes of staff.
	*	@access: public
	*	@param: (int) user id of staff
	*	@return: null
	*/
	function insert_staff_custom_attributes($data)
	{
		$this->db->insert('staff_custom_attributes',$data);
	}
	/**
	*	@name: get_staff_custom_attribute
	*	@desc: Get staff customa attribute from user id and attribute name
	*	@access: public
	*	@param: int(user id), (string) attribute name
	*	@return: null
	*/
	function get_staff_custom_attribute($user_id,$attribute_name)
	{
		return $this->db->where('user_id',$user_id)->where('attribute_name',$attribute_name)->get('staff_custom_attributes')->row();
	}
	
	function get_staff_custom_attribute_by_id($staff_custom_attributes_id)
	{
		return $this->db->where('staff_custom_attributes_id',$staff_custom_attributes_id)->get('staff_custom_attributes')->row();
	}
	/**
	*	@name: delete_staff_custom_attributes_by_id
	*	@desc: Delete custom attributes of a staff by delete_staff_custom_attributes_by_id
	*	@access: public
	*	@param: (int) delete_staff_custom_attributes_by_id
	*	@return: null
	*/
	function delete_staff_custom_attributes_by_id($staff_custom_attributes_id)
	{
		$sql = "delete from staff_custom_attributes where staff_custom_attributes_id = ".$staff_custom_attributes_id;
		return $this->db->query($sql);
	}
	
	function add_picture($data)
	{
		$this->db->insert('user_staff_picture', $data);
		return $this->db->insert_id();
	}
	
	
	function update_user_staff_picture($user_staff_picture_id,$data)
	{
		return $this->db->where('id',$user_staff_picture_id)->update('user_staff_picture',$data);	
	}
	/**
	*	@name: uset_hero
	*	@desc: Unset hero image
	*	@access: public
	*	@param: (int) user id
	*/
	function uset_hero($user_id)
	{
		$this->db->where('user_id',$user_id)->update('user_staff_picture',array('hero' => 0));
	}
	/**
	*	@name: update_rating_multi_staffs
	*	@desc: Update rating of multiple staff at once
	*	@access: public
	*	@param: (int) user ids of staff and new rating
	*/
	function update_rating_multi_staffs($user_ids,$new_rating)
	{
		$sql = "UPDATE user_staffs SET rating = ".$new_rating." WHERE user_id IN (".$user_ids.")";
		return $this->db->query($sql);
	}
	/**
	*	@desc Checks if a staff has been assigned this role.
	*
	*   @name staff_has_role
	*	@access public
	*	@param null
	*	@return Returns true if this role has been assigned to staff and vice versa
	*	
	*/
	function get_staff_groups($user_id)
	{
		$sql = "select attribute_group_id as group_id from staff_groups where user_id = ".$user_id;
		$staff_groups = $this->db->query($sql)->result();
		if($staff_groups){
			return $staff_groups;	
		}
		return false;
		
	}
}