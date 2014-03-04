<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();		
	}
	
	/**
	*	@name: load_email_template
	*	@desc: ajax function to load (abstract) view of an email template
	*	@access: public
	*	@param: (string) $object
	*	@return: (html) view of email template configuration based on tab
	*/
	function load_email_template($tab='roster_update') {		
		$this->load->view('roster_update', isset($data) ? $data : NULL);
	}
	
	function description_merge_fields()
	{
		$this->load->view('description_merge_fields', isset($data) ? $data : NULL);
	}
	
}