<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Resource
 * @author: namnd86@gmail.com
 */

class Resource extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('resource_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'resource_details':
					$this->resource_details($param);
				break;
			case 'search':
					$this->search();
				break;
			default:
					$this->resources_list();
				break;
		}
	}
	
	function resources_list()
	{
		
		$this->load->view('resource', isset($data) ? $data : NULL);
	}
	
	function resource_details($resource_id)
	{
		$this->session->unset_userdata('search_resources');
		$data['resources'] = $this->resource_model->get_resources(1);
		$data['resource'] = $this->resource_model->get_resource($resource_id);
		$data['files'] = $this->resource_model->get_resource_files($resource_id);
		$this->load->view('resource_details', isset($data) ? $data : NULL);
	}
	
	function search()
	{
		if ($this->input->post())
		{
			$this->session->set_userdata('search_resources', $this->input->post('search_resources'));
		}
		$keywords = $this->session->userdata('search_resources');
		$data['resources'] = $this->resource_model->get_resources(1);
		$data['results'] = $this->resource_model->search_resources($keywords);
		$data['keywords'] = $keywords;
		$this->load->view('resource_search', isset($data) ? $data : NULL);
	}
	
}