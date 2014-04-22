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
		$this->load->model('client/client_model');
		$this->load->model('invoice/invoice_model');
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
	*	@param: (array) email params
	*	@return: returns object for a particular email template
	*/
	function get_email_obj($params)
	{
		$template_id = $params['template_id'];
		$user_id = $params['user_id'];
		$company = $params['company'];
		$password = isset($params['password']) ? $params['password'] : '';
		$obj = array();
		
		if($template_id && $user_id && $company){
			$user = $this->user_model->get_user($user_id);
			switch($template_id){
				case 1:
				//welcome
				if(!$password){
					$password = modules::run('user/reset_password',$user_id);
				}
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'company_name' => $company['company_name'],
							'system_url' => base_url(),
							'username' => $user['username'],
							'password' => $password
							);
				
				break;
				
				case 2:
				//roster update
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'roster' => modules::run('roster/get_roster_email',$user_id)
							);
				break;
				
				case 3:
				//apply for shifts
				break;
				
				case 4:
				//shift reminder
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'company_name' => $company['company_name'],
							'system_url' => base_url(),
							'shift_info' => '[Shift information will be inserted here such as Propagate World Wide at 12:30 PM]'
							);
				break;
				
				case 5:
				//work confirmation
				break;
				
				case 6:
				//forgot password
				$obj = array(
							'first_name' => $user['first_name'],
							'last_name' => $user['last_name'],
							'company_name' => $company['company_name'],
							'system_url' => base_url(),
							'username' => $user['username'],
							'password' => modules::run('user/reset_password',$user_id)
							);
				break;
				
				case 7:
				//client invoice
				$client = $this->client_model->get_client($user_id);
				$invoice = $this->invoice_model->get_invoice($params['invoice_id']);
				$obj = array(
							'company_name' => $company['company_name'],
							'client_contact_name' => $user['full_name'],
							'client_company_name' => $client['company_name'],
							'system_url' => base_url(),
							'invoice_number' => $invoice['invoice_id'],
							'issue_date' => date('dS F, Y',strtotime($invoice['issued_date'])),
							'amount_due' => $invoice['total_amount'],
							'due_date' => date('dS F, Y',strtotime($invoice['due_date']))
							);
				break;
				
				case 8:
				//client quote
				break;
				
				case 9:
				//brief
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
				$email = str_replace('{ShiftInfo}',$obj['shift_info'],$email);
				$email = str_replace('{ClientContactName}',$obj['client_contact_name'],$email);
				$email = str_replace('{ClientCompanyName}',$obj['client_company_name'],$email);
				$email = str_replace('{InvoiceNumber}',$obj['invoice_number'],$email);
				$email = str_replace('{IssueDate}',$obj['issue_date'],$email);
				$email = str_replace('{AmountDue}',$obj['amount_due'],$email);
				$email = str_replace('{DueDate}',$obj['due_date'],$email);
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
			$template_id = WELCOME_EMAIL_TEMPLATE_ID;	
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
		if(LIVE_SERVER){
			$this->send_email_live($data);
		}else{
			$this->send_email_localhost($data);
		}
	}

	/**
	*	@name: send_email_live
	*	@desc: A central function to send all email in live server
	*	@access: public
	*	@param: (array) email data
	*/
	function send_email_live($data)
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
			if($attachment){
				$this->email->attach($attachment);
			}
			$this->email->send();
			$this->email->clear(true);	
			return 'Email Sent';
					
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
		if($attachment){
			$this->email->attach($attachment);
		}
		if($this->email->send()){
		  	echo 'Email sent.';
		}else{
			show_error($this->email->print_debugger());
		} 
	}
	
	
	
}