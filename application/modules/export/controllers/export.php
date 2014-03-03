<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Export
 * @author: namnd86@gmail.com
 */

class Export extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('export_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function field_select_type($type, $field_name, $field_value) {
		$templates = $this->export_model->get_templates($type);
		$data = array();
		foreach($templates as $template) {
			$data[] = array(
				'value' => $template['export_id'],
				'label' => $template['name']
			);
		}
		
		return modules::run('common/field_select', $data, $field_name, $field_value);
	}	
	
	
}