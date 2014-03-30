<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: upload
*	@controller: upload
*/

class Upload extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('upload/upload_model');
	}
	
	
	
}