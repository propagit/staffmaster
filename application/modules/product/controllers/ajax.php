<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Product
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}
	
	function select_category()
	{
		$reference_id = $_POST['reference_id'];
		$category = $this->product_model->get_category($reference_id);
		if ($category)
		{
			$this->session->set_userdata('selected_category_label', $category['title']);
			$this->session->set_userdata('selected_category_id', $category['reference_id']);
			echo $category['title'];
		}
		else
		{
			$this->session->set_userdata('selected_category_label', 'Any category');
			$this->session->set_userdata('selected_category_id', 0);
			echo 'Any category';
		}
		$this->session->unset_userdata('search_keywords');
		
	}
	
	function load_brands()
	{
		echo modules::run('common/dropdown_brands');
	}
	
	function select_brand()
	{
		$reference_id = $_POST['reference_id'];
		$brand = $this->product_model->get_brand($reference_id);
		if ($brand)
		{
			$this->session->set_userdata('selected_brand_label', $brand['name']);
			$this->session->set_userdata('selected_brand_id', $brand['reference_id']);
			echo $brand['name'];
		}
		else
		{
			$this->session->set_userdata('selected_brand_label', 'Any brand');
			$this->session->set_userdata('selected_brand_id', 0);
			echo 'Any brand';
		}
		$this->session->unset_userdata('search_keywords');
		
	}
	
	function sendmail()
	{
		if ($this->input->post())
    	{
    		$email = $this->input->post('email');
    		if (!valid_email($email))
    		{
	    		echo json_encode(array(
	    			'result' => false,
	    			'msg' => 'Invalid email address'
	    		));
    		}
    		else
    		{
	    		$product = $this->product_model->get_product($this->input->post('product_id'));
		    	# Sending email
				$config = array();
				$config['useragent']		= "CodeIgniter";
				$config['mailpath']			= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
				$config['protocol']			= "smtp";
				$config['smtp_host']		= "localhost";
				$config['smtp_port']		= "25";
				$config['mailtype'] 		= 'html';
				$config['charset']  		= 'utf-8';
				$config['newline']  		= "\r\n";
				$config['wordwrap'] 		= TRUE;
				#$config['send_multipart']	= FALSE;
				
				$this->load->library('email');
				
				$this->email->initialize($config);
				$user = $this->session->userdata('user_data');
				
				$this->email->from($user['company_email'], $user['company_name']);
				
				$this->email->subject($product['title']);
				$this->email->to($email); 
				$message = $this->load->view('email_friend', array('product' => $product), true);
		        $this->email->message($message);
		        
				if($this->email->send())
				{
					echo json_encode(array(
						'result' => true
					));	
				}
    		}
    		
    	}
	}
}