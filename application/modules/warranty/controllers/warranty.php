<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Warranty extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('warranty_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'search':
					$this->warranties_search();
				break;
			default:
					$this->warranties_list($method);
				break;
		}
		
	}
	
	function warranties_list()
	{
		$user = $this->session->userdata('user_data');
		
		$keywords = $this->session->userdata('warranty_keywords');
		$status = $this->session->userdata('warranty_status');
		$date_from = strtotime($this->session->userdata('warranty_date_from'));
		$date_to = strtotime($this->session->userdata('warranty_date_from'));
		
		$warranty_sort_key = $this->session->userdata('warranty_sort_key');
		$warranty_sort_value = $this->session->userdata('warranty_sort_value');
		
		$data['warranties'] = $this->warranty_model->get_warranties($user['company_name'], $keywords, $status, $date_from, $date_to, $warranty_sort_key, $warranty_sort_value);
		
		if ($this->input->post('req_no'))
		{
			$this->session->unset_userdata('warranty_searched');
			
			$this->session->set_userdata('req_no', $this->input->post('req_no'));
			$warranty = $this->warranty_model->get_warranty($this->input->post('req_no'));
			if (!$warranty)
			{
				$data['req_no_not_found'] = true;
			}
			else
			{
				if (!$warranty['warranty_start_date'])
				{
					$warranty['warranty_start_date'] = now();
					$warranty['warranty_finish_date'] = now() + 365*24*3600;
					$this->warranty_model->update_warranty($warranty['order_id'], $warranty);
				}
				else
				{
					$data['warranty_activated'] = true;
				}
				$data['warranty'] = $warranty;
			}
		}
		
		$this->load->view('warranty_active', isset($data) ? $data : NULL);
	}
	
	function warranties_search()
	{
		$this->session->set_userdata('warranty_searched', true);
		$this->session->set_userdata('warranty_keywords', $this->input->post('keywords'));
		$this->session->set_userdata('warranty_status', $this->input->post('status'));
		$this->session->set_userdata('warranty_date_from', $this->input->post('date_from'));
		$this->session->set_userdata('warranty_date_from', $this->input->post('date_to'));
		
		redirect('warranty');
	}
}