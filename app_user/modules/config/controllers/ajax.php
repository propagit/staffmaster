<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('config_model');
	}
	
	function add()
	{
		$input = $this->input->post();
		foreach($input as $key => $value)
		{
			$this->config_model->add(array(
				'key' => $key,
				'value' => $value
			));
		}
	}
	
}