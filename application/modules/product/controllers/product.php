<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Product extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('customer_model');
		$this->load->model('resource/resource_model');
		$this->load->model('warranty/warranty_model');
	}
	
	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'all':
					$this->all_products($param);
				break;
			case 'product_details':
					$this->product_details($param);
				break;
			case 'product_category':
					$this->product_category($param);
				break;
			case 'product_repair':
					$this->product_repair($param);
				break;
			case 'product_exchange':
					$this->product_exchange($param);
				break;
			case 'product_3day':
					$this->product_3day($param);
				break;
			case 'start':
					$this->product_empty();
				break;
			default:
					$this->products_overview($method);
				break;
		}
	}
	
	function product_empty()
	{
		$this->session->unset_userdata('selected_category_label');
		$this->session->unset_userdata('selected_category_id');
		$this->session->unset_userdata('selected_brand_label');
		$this->session->unset_userdata('selected_brand_id');
		$this->session->unset_userdata('search_keywords');
		$this->load->view('products_start', isset($data) ? $data : NULL);
	}
	
	function all_products()
	{
		$this->session->unset_userdata('selected_category_label');
		$this->session->unset_userdata('selected_category_id');
		$this->session->unset_userdata('selected_brand_label');
		$this->session->unset_userdata('selected_brand_id');
		$this->session->unset_userdata('search_keywords');
		$this->products_overview();
	}
	
	function product_category($category_id)
	{
		$category = $this->product_model->get_category($category_id);
		$this->session->set_userdata('selected_category_label', $category['title']);
		$this->session->set_userdata('selected_category_id', $category['reference_id']);
		$this->products_overview();
	}
	
	function products_overview($offset=0)
	{
		if ($this->input->post())
		{
			$keywords = $this->input->post('search_keywords');
			$this->session->set_userdata('search_keywords', $keywords);
			
			$this->session->unset_userdata('selected_category_label');
			$this->session->unset_userdata('selected_category_id');
			$this->session->unset_userdata('selected_brand_label');
			$this->session->unset_userdata('selected_brand_id');
		}
		
		$products = $this->search_products();
		$data['search_results_count'] = count($products);
		$this->load->library('pagination');
		$config['base_url'] = base_url(). 'product/';
		$config['per_page'] = 16;
		$config['num_links'] = 2;
		$config['uri_segment'] = 2;
		$config['total_rows'] = count($products);
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['products'] = $this->search_products($config['per_page'], $offset);
		$this->load->view('products_overview', isset($data) ? $data : NULL);
	}
	
	function search_products($per_page = NULL, $offset = NULL)
	{		
		$category_id = $this->session->userdata('selected_category_id');
		$brand_id = $this->session->userdata('selected_brand_id');
		$keywords = $this->session->userdata('search_keywords');
		$products = $this->product_model->search_products($category_id, $brand_id, $keywords, $per_page, $offset);
		return $products;
	}
	
	function product_details($product_id)
	{
		$product = $this->product_model->get_product($product_id);
		if (!$product)
		{
			redirect('product');
		}
		$data['product'] = $product;
		$data['similar_products'] = $this->product_model->get_similar_products($product_id, $product['category_id']);
		$data['brand'] = $this->product_model->get_brand($product['brand_id']);
		$data['category'] = $this->product_model->get_category($product['category_id']);
		$this->load->view('product_details', $data);
	}	
	
	function product_repair($product_id)
	{
		$product = $this->product_model->get_product($product_id);
		if (!$product)
		{
			redirect('product');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('customer_phone', 'Contact Number', 'required');
		$this->form_validation->set_rules('customer_email', 'Email', 'valid_email');
		$this->form_validation->set_rules('ship_direction', 'Ship Direction', 'required');
		
		$this->form_validation->set_rules('customer_address', 'Address', '');
		$this->form_validation->set_rules('customer_suburb', 'Suburb', '');
		$this->form_validation->set_rules('customer_state', 'State', '');
		$this->form_validation->set_rules('customer_postcode', 'Postcode', '');
		$this->form_validation->set_rules('agree', 'Agree', 'required');
		
		$ship_direction = $this->input->post('ship_direction');
		if ($ship_direction == 'DIRECT')
		{
			$this->form_validation->set_rules('customer_address', 'Address', 'required');
			$this->form_validation->set_rules('customer_suburb', 'Suburb', 'required');
			$this->form_validation->set_rules('customer_state', 'State', 'required');
			$this->form_validation->set_rules('customer_postcode', 'Postcode', 'required');
		}
		
		$this->form_validation->set_rules('fault', 'Fault', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{	
		}
		else
		{
			$data = $this->input->post();
			
			$user = $this->session->userdata('user_data');
			
			$data['user_id'] = $user['user_id'];
			$data['distributor_company_name'] = $user['company_name'];
			$data['product_id'] = $product['product_id'];
			$data['product_part_no'] = $product['part_no'];
			$this->load->model('order/order_model');
			$data['sys_rma'] = $this->order_model->generate_sys_rma();
			$data['type'] = 'REP/RTN';
			$data['sale_date'] = now();
			$data['total'] = $this->retail_price($product['price']);
			unset($data['agree']);
			$order_id = $this->order_model->insert_order($data);
			
			$data['success'] = true;
			redirect('job/j-' . $order_id);
		}
		
		$data['product'] = $product;
		$data['states'] = $this->customer_model->get_states();
		$this->load->view('product_repair', isset($data) ? $data : NULL);
	}
		
	function product_exchange($product_id)
	{
		$product = $this->product_model->get_product($product_id);
		if (!$product)
		{
			redirect('product');
		}
		if ($this->stock($product['part_no']) == 0)
		{
			redirect('product');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('customer_phone', 'Contact Number', 'required');
		$this->form_validation->set_rules('customer_email', 'Email', 'valid_email');
		$this->form_validation->set_rules('customer_address', 'Address', '');
		$this->form_validation->set_rules('customer_suburb', 'Suburb', '');
		$this->form_validation->set_rules('customer_state', 'State', '');
		$this->form_validation->set_rules('customer_postcode', 'Postcode', '');
		$this->form_validation->set_rules('fault', 'Fault', 'required');
		$this->form_validation->set_rules('req_no', 'Registration Code', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{	
		}
		else
		{
			$data = $this->input->post();
			$user = $this->session->userdata('user_data');
			
			$data['user_id'] = $user['user_id'];
			$data['distributor_company_name'] = $user['company_name'];
			$data['product_id'] = $product['product_id'];
			$data['product_part_no'] = $product['part_no'];
			$data['type'] = 'EXCHANGE';
			$data['sale_date'] = now();
			$data['total'] = $this->retail_price($product['price']);
			$this->load->model('order/order_model');
			
			$order = $this->order_model->get_order_available($user['company_name'], $data['product_part_no'], $data['req_no']);
			if ($order)
			{
				unset($data['agree']);
				$this->order_model->update_order($order['order_id'], $data);
				$data['success'] = true;	
				
				# Activate warranty
				$warranty = $this->warranty_model->get_warranty($data['req_no']);
				if (!$warranty['warranty_start_date'])
				{
					$warranty['warranty_start_date'] = now();
					$warranty['warranty_finish_date'] = now() + 365*24*3600;
					$this->warranty_model->update_warranty($warranty['order_id'], $warranty);
				}		
				redirect('job/j-' . $order['order_id']);
			}
			else
			{
				$data['error'] = true;
			}			
		}
		$data['product'] = $product;
		$data['states'] = $this->customer_model->get_states();
		$this->load->view('product_exchange', $data);
	}
	
	function product_3day($product_id)
	{
		$product = $this->product_model->get_product($product_id);
		if (!$product)
		{
			redirect('product');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
		$this->form_validation->set_rules('customer_phone', 'Contact Number', 'required');
		$this->form_validation->set_rules('customer_email', 'Email', 'valid_email');
		$this->form_validation->set_rules('ship_direction', 'Ship Direction', 'required');
		
		$this->form_validation->set_rules('customer_address', 'Address', '');
		$this->form_validation->set_rules('customer_suburb', 'Suburb', '');
		$this->form_validation->set_rules('customer_state', 'State', '');
		$this->form_validation->set_rules('customer_postcode', 'Postcode', '');
		$this->form_validation->set_rules('agree', 'Agree', 'required');
		
		$ship_direction = $this->input->post('ship_direction');
		if ($ship_direction == 'DIRECT')
		{
			$this->form_validation->set_rules('customer_address', 'Address', 'required');
			$this->form_validation->set_rules('customer_suburb', 'Suburb', 'required');
			$this->form_validation->set_rules('customer_state', 'State', 'required');
			$this->form_validation->set_rules('customer_postcode', 'Postcode', 'required');
		}
		
		$this->form_validation->set_rules('fault', 'Fault', 'required');
		
		if ($this->form_validation->run($this) == FALSE)
		{	
		}
		else
		{
			$data = $this->input->post();
			$user = $this->session->userdata('user_data');
			
			$data['user_id'] = $user['user_id'];
			$data['distributor_company_name'] = $user['company_name'];
			$data['product_id'] = $product['product_id'];
			$data['product_part_no'] = $product['part_no'];
			$this->load->model('order/order_model');
			$data['sys_rma'] = $this->order_model->generate_sys_rma();
			$data['type'] = 'EXCHANGE';
			$data['sale_date'] = now();
			$data['total'] = $this->retail_price($product['price']);
			unset($data['agree']);
			$order_id = $this->order_model->insert_order($data);
			
			$data['success'] = true;
			redirect('job/j-' . $order_id);
		}
		$data['product'] = $product;
		$data['states'] = $this->customer_model->get_states();
		$this->load->view('product_3day', isset($data) ? $data : NULL);
	}
	
	function photo($pic_url)
	{
		if (file_exists('./uploads/products/' . $pic_url))
		{
			$pic_url = base_url() . 'uploads/products/' . $pic_url;
		}
		else
		{
			$pic_url = base_url() . 'assets/img/no_image.gif';
			#$pic_url = base_url() . 'uploads/products/product.jpg';
		}
		return '<img src="' . $pic_url . '" />';
	}
	
	function retail_price($price)
	{
		$user = $this->session->userdata('user_data'); 
		$trade_price = $price;
		if ($user['discount'] > 0)
		{
			$trade_price = (100 - $user['discount']) * $trade_price / 100;
		}
		$retail_price = $trade_price;
		if ($user['margin'] > 0)
		{
			$retail_price = (100 + $user['margin']) * $retail_price / 100;
		}
		return $retail_price;
	}
	
	function stock($part_no)
	{
		$user = $this->session->userdata('user_data');
		return $this->product_model->get_product_stock($part_no, $user['company_name']);
	}
}