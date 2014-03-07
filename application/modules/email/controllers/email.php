<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: apply controller for staff
*/

class Email extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('email_template_model');
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
	/**
	*	@name: main_view
	*	@desc: Load the landing page for email template. This is where the user will be able to modify email templates.
	*	@access: public
	*	@param: none
	*	@return: Loads the UI to update email template
	*/
	function main_view(){
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	/**
	*	@name: email_templates_dropdown
	*	@desc: 
	*	@access: public
	*	@param: 
	*/
	function email_templates_dropdown($field_name, $field_value=null, $size=null)
	{
		$templates = $this->email_template_model->get_all_templates();
		$count = 0;
		if($templates){
			foreach($templates as $template){
				  $array[$count] = array('value' => $template->email_template_id, 'label' => $template->template_name);
				  $count++;
			}
		}
		
		return modules::run('common/field_select', $array, $field_name, $field_value, $size);
	}
	/**
	*	@name: format_template_body
	*	@desc: 
	*	@access: public
	*	@param: 
	*/
	function format_template_body($email)
	{
		preg_match_all('/{[^}]*}/', $email, $merge_fields);
		$formatted_email = $email;
		if($merge_fields[0]){
			foreach($merge_fields[0] as $field){
				
				switch(trim($field)){
					case '{FirstName}':
						$formatted_email = str_replace($field,'Kaushtuv',$formatted_email);
					break;
					case '{CompanyName}':
						$formatted_email = str_replace($field,'Propagate',$formatted_email);
					break;	
					case '{SystemURL}':
						$formatted_email = str_replace($field,base_url(),$formatted_email);
					break;	
					case '{UserName}':
						$formatted_email = str_replace($field,'kaushtuv@propagate.com.au',$formatted_email);
					break;	
					case '{Password}':
						$formatted_email = str_replace($field,'admin1234',$formatted_email);
					break;	
				}
				
				/*  $rule = $this->email_template_model->get_merge_field_by_merge_field($field);
				switch($rule->merge_rule){
					case 'field_name':
						$temp_email = str_replace($field,$object[$rule->table_field],$temp_email);
					break;
					case 'replace_text':
					
					break;
					case 'custom_rule':
					
					break;	
				}  */
			}
		}
		return $formatted_email;
		
	}
	/**
	*	@name: description_merge_fields
	*	@desc: 
	*	@access: public
	*	@param: 
	*/
	function description_merge_fields($text_area_id = '')
	{
		$data['text_area_id'] = $text_area_id;
		$this->load->view('description_merge_fields', isset($data) ? $data : NULL);
	}
	/**
	*	@name: send_email
	*	@desc: A central function to send email
	*	@access: public
	*	@param: (array) email data
	*/
	function send_email($data)
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
		
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($from,$from_text);		
			$this->email->to($to);
			$this->email->cc($cc);
			$this->email->bcc($bcc);
			$company_logo = modules::run('setting/company_logo');
			$email_signature = modules::run('setting/ajax/get_template_footer');
			$this->email->subject($subject);
			$this->email->message($company_logo . '<br />'.$message . $email_signature);
			//$this->email->attach($attachment);
			$this->email->send();
			$this->email->clear(true);	
			return true;
					
		}else{
			return false;	
		}
		

	}
	
	/**
	*	@desc Test function to send email from localhost
	*
	*   @name send_email
	*	@access public
	*	
	*/
	function send_email_localhost($data)
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
		$company_logo = modules::run('setting/company_logo');
		$email_signature = modules::run('setting/get_email_footer');
		$this->email->message($company_logo . '<br />'.$message . $email_signature);
		
		if($this->email->send()){
		  	echo 'Email sent.';
		}else{
			show_error($this->email->print_debugger());
		} 
	}
	
	
	
}