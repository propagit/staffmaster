<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Admin extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('page_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'edit':
					$this->edit_page($param);
				break;
			default:
					$this->pages_list();
				break;
		}
	}
	
	function pages_list()
	{
		$data['pages'] = $this->page_model->get_pages();
		$this->load->view('admin_pages_list', isset($data) ? $data : NULL);
	}
	
	function edit_page($page_id)
	{
		$page = $this->page_model->get_page($page_id);
		if (!$page)
		{
			redirect('admin/page');
		}
		if ($this->input->post())
		{
			$data = $this->input->post();
			if ($this->page_model->update_page($page_id, $data))
			{
				$page = array_merge($page, $data);
				$data['updated'] = true;
				
			}
		}
		$data['page'] = $page;
		$this->load->view('admin_edit_page', isset($data) ? $data : NULL);
	}
	
}