<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('resource_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'create':
					$this->create_resource();
				break;
			case 'edit':
					$this->edit_resource($param);
				break;
			case 'activate':
					$this->activate_resource($param);
				break;
			case 'delete':
					$this->delete_resource($param);
				break;
			case 'upload':
					$this->upload_file($param);
				break;
			case 'update_file':
					$this->update_file($param);
				break;
			case 'remove_file':
					$this->remove_file($param);
				break;
			default:
					$this->resources_list();
				break;
		}
	}
	
	function resources_list()
	{
		if ($this->input->post())
		{
			$this->session->set_userdata('keywords_resource', $this->input->post('keywords'));
		}
		$keywords = $this->session->userdata('keywords_resource');
		
		$data['resources'] = $this->resource_model->search_resources($keywords);
		$this->load->view('admin_resources_list', isset($data) ? $data : NULL);
	}
	
	function create_resource()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules(array(
			array('field' => 'resource_title', 'label' => 'Resource Title', 'rules' => 'required'),
			array('field' => 'resource_description', 'label' => 'Resource Description', 'rules' => ''),
			array('field' => 'survey_link', 'label' => 'Survey Link', 'rules' => ''),
			array('field' => 'youtube_link', 'label' => 'Embed Video', 'rules' => '')
		));
		if ($this->form_validation->run($this) == FALSE)
		{				
		}
		else
		{
			$data = $this->input->post();
			$resource_id = $this->resource_model->insert_resource($data);
			redirect('admin/resource/edit/' . $resource_id);
		}
		
		#$data['states'] = $this->user_model->get_states();
		$this->load->view('admin_create_resource', isset($data) ? $data : NULL);
	}
	
	function edit_resource($resource_id)
	{
		$resource = $this->resource_model->get_resource($resource_id);
		if (!$resource)
		{
			redirect('admin/resource');
		}
		if ($this->input->post())
		{
			$data = $this->input->post();
			if ($this->resource_model->update_resource($resource_id, $data))
			{
				$resource = array_merge($resource, $data);
				$data['updated'] = true;
				
			}
		}
		$data['resource'] = $resource;
		$data['files'] = $this->resource_model->get_resource_files($resource_id);
		$this->load->view('admin_edit_resource', isset($data) ? $data : NULL);
	}
	
	function activate_resource($resource_id)
	{
		$resource = $this->resource_model->get_resource($resource_id);
		if (!$resource)
		{
			redirect('admin/resource');
		}
		if ($resource['active'])
		{
			$data = array('active' => 0);
		}
		else
		{
			$data = array('active' => 1);
		}
		$this->resource_model->update_resource($resource_id, $data);
		redirect('admin/resource');
	}
	
	function delete_resource($resource_id)
	{
		$files = $this->resource_model->get_resource_files($resource_id);
		foreach($files as $file)
		{
			if (file_exists('./uploads/resources/' . $file['file_name']))
			{
				unlink('./uploads/resources/' . $file['file_name']);
				$this->resource_model->delete_resource_file($file_id);
			}
		}
		$this->resource_model->delete_resource($resource_id);
		redirect('admin/resource');
	}
	
	function upload_file($resource_id)
	{
		$config['upload_path'] = './uploads/resources/';
		$config['allowed_types'] = '*';
		
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			#$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$upload_data = $this->upload->data();
			$data = array(
				'resource_id' => $resource_id,
				'orig_name' => $upload_data['orig_name'],
				'file_name' => $upload_data['file_name']
			);
			$this->resource_model->insert_resource_file($data);
			redirect('admin/resource/edit/' . $resource_id);			
		}
	}
	
	function update_file($resource_id)
	{
		$this->resource_model->update_resource_file($this->input->post('file_id'), array('orig_name' => $this->input->post('file_title')));
		redirect('admin/resource/edit/' . $resource_id);
	}
	
	function remove_file($file_id)
	{
		$file = $this->resource_model->get_resource_file($file_id);
		if (!$file)
		{
			redirect('admin/resource');
		}
		if (file_exists('./uploads/resources/' . $file['file_name']))
		{
			unlink('./uploads/resources/' . $file['file_name']);
			$this->resource_model->delete_resource_file($file_id);
		}
		redirect('admin/resource/edit/' . $file['resource_id']);
	}
}