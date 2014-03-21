<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*    @class_desc: controller to handle common module such as field_select and can be used in any views/modules
*    
*/

class Common extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('setting/setting_model');
		$this->load->model('staff/staff_model');
	}
	
	/**
	*	@name: field_select
	*	@desc: custom select input field
	*	@access: public
	*	@param: - $array: an array of field value/label pairs
	*			- $field_name: string of field name
	*			- $field_value (optional): selected value of field
	*			- $size (optional): size 
	*	@return: custom view of select input field
	*/
	function field_select($array, $field_name, $field_value=null, $size=null, $title = true) {
		$data = array(
			'data' => $array,
			'field_name' => $field_name,
			'field_value' => $field_value,
			'size' => $size,
			'title' => $title
		);
		$this->load->view('field_select', isset($data) ? $data : NULL);
	}
	
	function field_select_gst($field_name, $field_value=null, $size=null, $title = false) {
		$array = array(
			array('value' => GST_NO, 'label' => 'No GST'),
			array('value' => GST_YES, 'label' => 'Inc GST'),
			array('value' => GST_ADD, 'label' => 'Add GST'),
			array('value' => TAX_FREE, 'label' => 'Tax Free')
		);
		return $this->field_select($array, $field_name, $field_value, $size, $title);
	}
	
	function reverse_field_gst($value, $edit = false) {
		$add_gst = 'Add GST';
		if (!$edit) {
			$add_gst = 'Inc GST';
		}
		switch($value) {
			case GST_NO: return 'No GST';
			case GST_YES: return 'Inc GST';
			case GST_ADD: return $add_gst;
			case TAX_FREE: return 'Tax Free';
		}
	}
	
	/**
	*	@name: field_select_states
	*	@desc: custom select states field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected state code
	*			- $size (optional): size 
	*	@return: custom view of select states field
	*/
	function field_select_states($field_name, $field_value=null, $size=null) {
		$states = $this->common_model->get_states();
		$array = array();
		foreach($states as $state)
		{
			$array[] = array(
				'value' => $state['code'],
				'label' => $state['name']
			);
		}
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: field_select_countries
	*	@desc: custom select countries field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected country code
	*			- $size (optional): size 
	*	@return: custom view of select states field
	*/
	function field_select_countries($field_name, $field_value=null, $size=null) {
		$countries = $this->common_model->get_countries();
		if ($field_value == null || $field_value=='')
		{
			$field_value = 'AU';
		}
		$array = array();
		foreach($countries as $country)
		{
			$array[] = array(
				'value' => $country['code'],
				'label' => $country['name']
			);
		}
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*	@name: field_select_genders
	*	@desc: custom select genders field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected gender value
	*			- $size (optional): size
	*	@return: custom select gender field
	*/
	function field_select_genders($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => GENDER_MALE, 'label' => 'Male'),
			array('value' => GENDER_FEMALE, 'label' => 'Female')
		);
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	
	function field_select_dob($field_name, $field_value=null, $size=null) {
		$day_array = array();
		$month_array = array();
		$year_array = array();
		for($i=1; $i<=30; $i++) {
			$x = sprintf('%02d',$i);
			$day_array[] = array('value' => $x, 'label' => $x);
		}
		for($i=1; $i<=12; $i++) {
			$x = sprintf('%02d',$i);
			$month_array[] = array('value' => $x, 'label' => $x);
		}
		for($i=2012; $i>=1990;$i--) {
			$year_array[] = array('value' => $i, 'label' => $i);
		}
		$field_day = null;
		$field_month = null;
		$field_year = null;
		if ($field_value) {
			$fields = explode('-', $field_value);
			if (isset($fields[0])) { $field_day = $fields[0]; }
			if (isset($fields[1])) { $field_month = $fields[1]; }
			if (isset($fields[2])) { $field_year = $fields[2]; }
		}
		$output = $this->field_select($day_array, $field_name . '-day', $field_day);
		return $output;
		$output .= $this->field_select($month_array, $field_name . '-mth', $field_month);
		$output .= $this->field_select($year_array, $field_name . '-year', $field_year);
		return $output;
	}
	
	/**
	*	@name: field_select_title
	*	@desc: custom select title field
	*	@access: public
	*	@param: - $field_name: string of field name
	*			- $field_value (optional): selected gender value
	*			- $size (optional): size
	*	@return: custom select title field
	*/
	function field_select_title($field_name, $field_value=null, $size=null) {
		$array = array(
			array('value' => 'Mr', 'label' => 'Mr'),
			array('value' => 'Miss', 'label' => 'Miss'),
			array('value' => 'Mrs', 'label' => 'Mrs')
		);
		return $this->field_select($array, $field_name, $field_value, $size);
	}
	
	/**
	*    @name: field_rating
	*    @desc: custom input field for rating
	*    @access public
	*    @param: - $field_name
	*			- $field_value (optional) 
	*    @return: custom input field for rating 
	*/
	function field_rating($field_name,$field_value=null,$selector='basic',$ajax_reload_container = 'wp-rating',$user_id = 0,$ajax_update = false,$disabled=false) {
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['disabled'] = $disabled;
		$data['selector'] = $selector;
		$data['ajax_reload_container'] = $ajax_reload_container;
		$data['ajax_update'] = $ajax_update;
		$data['user_id'] = $user_id;
		$this->load->view('field_rating', isset($data) ? $data : NULL);
	}
	
	
	function menu_dropdown($array, $id, $label) {
		$data = array(
			'data' => $array,
			'id' => $id,
			'label' => $label
		);
		$this->load->view('menu_dropdown', isset($data) ? $data : NULL);
	}
	
	function menu_dropdown_states($id, $label) {
		$states = $this->common_model->get_states();
		$array = array();
		$array[] = array('value' => '', 'label' => 'Any');
		foreach($states as $state)
		{
			$array[] = array(
				'value' => $state['code'],
				'label' => $state['name']
			);
		}
		return $this->menu_dropdown($array, $id, $label);
	}
	
	
	function dropdown_actions($target, $actions)
	{
		$data['target'] = $target;
		$data['actions'] = $actions;
		$this->load->view('dropdown_actions', isset($data) ? $data : NULL);
	}
	
	function dropdown_status($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$this->load->view('dropdown_status', isset($data) ? $data : NULL);
	}
	
	
	
	function dropdown_supers($field_name, $field_value=null)
	{
		$data['field_name'] = $field_name;
		$data['field_value'] = $field_value;
		$data['supers'] = $this->common_model->get_supers(true);
		$this->load->view('dropdown_super', isset($data) ? $data : NULL);
	}
	
		
	function list_supers()
	{
		$supers = $this->common_model->get_supers();
		foreach($supers as $super) { echo '"' . $super['name'] . '",'; } 
	}
	
	function check_super()
	{
		
		$name = $this->input->post('super_value');
		$supers = $this->common_model->get_supers();
		$found = 1;
		foreach($supers as $super)
		{
			if ($super['name'] == $name)
			{
				$found = 0;
			}
		}
		echo $found;
		//return $found;
		
	}
	
		
	function dropdown_dob($day=null, $month=null, $year=null)
	{
		$data['day'] = $day;
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('dropdown_dob', isset($data) ? $data : NULL);
	}
	
	function break_time($string)
	{
		$a = json_decode($string);
		
		if (count($a) > 0) 
		{
			$total = 0;
			foreach($a as $break)
			{
				$total += $break->length;
			}
			echo $total/60 . ' mins';
		}
		else
		{
			echo 0;
		}
	}
	
	function calculate_expenses($expenses)
	{
		$total = 0;
		$expenses = unserialize($expenses);
		foreach($expenses as $e)
		{
			$total += $e['staff_cost'];
		}
		return $total;
	}
		
	function define_area()
	{
		$loc='';
		$suburb = $this->input->post('suburb');
		$suburb = str_replace('&amp;','&',$suburb);

		$detail = $this->common_model->get_locations_byname($loc,$suburb);
		
		echo $detail['location_id'].'#';
		
	}
	
	
	
	function create_pagination($total_records,$records_per_page = 6,$current_page = 1)
	{
		$data['total_records'] = $total_records;
		$data['records_per_page'] = $records_per_page;
		$data['current_page'] = $current_page;
		$this->load->view('pagination',isset($data) ? $data : NULL);
	}
	
	function generate_password($password_length = 6)
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); 
		$alpha_length = strlen($alphabet) - 1; 
		for ($i = 0; $i < $password_length; $i++) {
			$n = rand(0, $alpha_length);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); 
	}

}