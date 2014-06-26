<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendemail extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('setting/setting_model');
		$this->load->model('common/common_model');
	}
	
	
	/**
	*	@name: test_email
	*	@desc: Send test email
	*	@access: private
	*	@param: (array) email data
	*/
	function test_email()
	{
		/*
		$a = $this->send_email(array(
			'to' => 'namnd86@gmail.com',
			'from_text' => 'StaffBooks Maintenance',
			'subject' => 'Test Email',
			'message' => 'This is a test message'
		));
		*/
	}
	
	/**
	*	@name: send_email
	*	@desc: A central function to send email
	*	@access: private
	*	@param: (array) email data
	*/
	function send_email($data)
	{
		if(LIVE_SERVER){
			$this->_send_email_live($data);
		}else{
			$this->_send_email_localhost($data);
		}
	}

	/**
	*	@name: send_email_live
	*	@desc: A central function to send all email in live server
	*	@access: private
	*	@param: (array) email data
	*/
	function _send_email_live($data)
	{
		$to = '';
		$from = '';
		$cc = '';
		$bcc = '';
		$from_text = '';
		$subject = ''; 
		$message = ''; 
		$attachment = ''; 
		$bcc = '';
		if($data){
			foreach($data as $key=>$val){
				switch($key){
					case 'to':
						$to = $val;
					break;
					
					case 'from':
						$from = $val;
					break;
					
					case 'cc':
						$cc = $val;
					break;
										
					case 'bcc':
						$bcc = $val;
					break;
					
					case 'from_text':
						$from_text = $val;
					break;
					
					case 'subject':
						$subject = $val;
					break;
					
					case 'message':
						$message = $val;
					break;
					
					case 'attachment':
						$attachment = $val;
					break;	
				}
				
				
			}
			
			if($from == ''){
				$from = 'noreply@staffbooks.systems';
				$company = $this->setting_model->get_profile();
				if($company){
					if($company['email_c_email']){
						$from = $company['email_c_email'];	
					}
				}
			}
		
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($from,$from_text);		
			$this->email->to($to);
			$this->email->cc($cc);
			$this->email->bcc($bcc);
			if (!isset($data['overwrite']))
			{
				$company_logo = $this->_company_logo();
				$email_signature = $this->_get_email_footer();
				$message = $company_logo . '<br /><br /><br />'.$message . $email_signature;
			}
			
			$this->email->subject($subject);
			$this->email->message($message);
			if($attachment){
				$this->email->attach($attachment);
			}
			$this->email->send();
			$this->email->clear(true);	
					
		}else{
			return false;	
		}
		

	}
	
		
	/**
	*	@desc Test function to send email from localhost
	*
	*   @name send_email
	*	@access private
	*	
	*/
	function _send_email_localhost($data)
	{
		$config = Array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
		  'smtp_pass' => 'morem0n3y', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		
		$to = '';
		$from = '';
		$cc = '';
		$bcc = '';
		$from_text = '';
		$subject = ''; 
		$message = ''; 
		$attachment = ''; 
		$bcc = '';
		
		if($data){
		foreach($data as $key=>$val){
				switch($key){
					case 'to':
						$to = $val;
					break;
					
					case 'from':
						$from = $val;
					break;
					
					case 'cc':
						$cc = $val;
					break;
										
					case 'bcc':
						$bcc = $val;
					break;
					
					case 'from_text':
						$from_text = $val;
					break;
					
					case 'subject':
						$subject = $val;
					break;
					
					case 'message':
						$message = $val;
					break;
					
					case 'attachment':
						$attachment = $val;
					break;	
				}
				
				
			}
		}
		

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com',$from_text); // change it to yours
		$this->email->to($to);// change it to yours
		$this->email->subject($subject);
		if (!isset($data['overwrite']))
		{
			$company_logo = $this->_company_logo();
			$email_signature = $this->_get_email_footer();
			$message = $company_logo . '<br /><br /><br />'.$message . $email_signature;
		}
		
		$this->email->subject($subject);
		$this->email->message($message);
			
			
		if($attachment){
			$this->email->attach($attachment);
		}
		if($this->email->send()){
		  	echo 'Email sent.';
		}else{
			show_error($this->email->print_debugger());
		} 
	}
	
	/**
	*	@name: company_logo
	*	@desc: ajax function to get company logo
	*	@access: private
	*	
	*	
	*/
	function _company_logo()
	{
		$data['company'] = $this->setting_model->get_profile();
		return $this->load->view('settings/company_logo', isset($data) ? $data : NULL, TRUE);
	}
	
	/**
	*	@name: get_template_footer
	*	@desc: Get Email Footer Template
	*	@access: private
	*	@param: (via POST) Background color and Font color
	*	
	*/
	function _get_email_footer()
	{
		$company = $this->setting_model->get_profile();
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
		if($company){
			if($company['email_background_colour']){
				$color = $company['email_background_colour'];
			}
			if($company['email_font_colour']){
				$font_color = $company['email_font_colour'];
			}
		}
		
		$data['color'] = $color;
		$data['font_color'] = $font_color;
		$data['company'] = $company;
		$data['country_full_name'] = '';
		if(isset($company['email_c_country']) && $company['email_c_country']!=''){
			$data['country_full_name'] = $this->_get_country_name_from_country_code($company['email_c_country']);
		}
		
		return $this->load->view('settings/email_footer_template', isset($data) ? $data : NULL, TRUE);	
	}
	
	function _get_country_name_from_country_code($country_code)
	{
		$country = $this->common_model->get_country_name_from_country_code($country_code);
		return $country->name;
	}
}

/* End of file sendemail.php */
/* Location: ./application/sendemail/controllers/sendemail.php */