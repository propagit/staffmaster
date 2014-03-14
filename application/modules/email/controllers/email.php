<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc: apply controller for staff
*/

class Email extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('email_template_model');
		$this->load->model('user/user_model');
	}
	
	public function index($method = '', $param1 = '',$param2 = '')
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
	*	@name: get_email_obj
	*	@desc: Create the object needed for a particular template
	*	@access: public
	*	@param: ([int] template id, [int] user id)
	*	@return: returns object for a particular email template
	*/
	function get_email_obj($template_id,$user_id,$company,$password = '')
	{
		$obj = array();
		if($template_id && $user_id && $company){
			$user = $this->user_model->get_user($user_id);
			switch($template_id){
				case 1:
				//welcome
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'company_name' => $company['company_name'],
							'system_url' => base_url(),
							'username' => $user['username'],
							'password' => $password,
							);
				
				break;
				
				case 2:
				//roster update
				break;
				
				case 3:
				//apply for shifts
				break;
				
				case 4:
				//shift reminder
				break;
				
				case 5:
				//work confirmation
				break;
				
				case 6:
				//forgot password
				break;
				
				case 7:
				//client invoice
				break;
				
				case 8:
				//client quote
				break;
			}
		}
		return $obj;
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
	function format_template_body($email,$obj = NULL)
	{
		if($obj){
				$email = str_replace('{FirstName}',$obj['first_name'],$email);
				$email = str_replace('{FamilyName}',$obj['last_name'],$email);
				$email = str_replace('{CompanyName}',$obj['company_name'],$email);
				$email = str_replace('{SystemURL}',$obj['system_url'],$email);
				$email = str_replace('{UserName}',$obj['username'],$email);
				$email = str_replace('{Password}',$obj['password'],$email);
				$email = str_replace('{Roster}',$obj['roster'],$email);
				$email = str_replace('{SelectedShifts}',$obj['selected_shifts'],$email);
		}
		return $email;
		
	}
	/**
	*	@name: description_merge_fields
	*	@desc: 
	*	@access: public
	*	@param: 
	*/
	function description_merge_fields($text_area_id,$template_id = '')
	{
		$data['text_area_id'] = $text_area_id;
		if(!$template_id){
			$template_id = 1;	
		}
		$data['merge_fields'] = $this->email_template_model->get_email_merge_fields_by_template_id($template_id);
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