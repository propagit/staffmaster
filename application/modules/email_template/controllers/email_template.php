<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: apply controller for staff
*/

class Email_template extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		
	}
	
	function email_templates_dropdown($field_name, $field_value=null, $size=null)
	{
		$array = array(
			array('value' => 'Roster Update', 'label' => 'Roster Update Email Template'),
		);
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	
	
}