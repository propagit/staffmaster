<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('email_template_model');	
	}
	
	/**
	*	@name: load_email_template
	*	@desc: ajax function to load (abstract) view of an email template
	*	@access: public
	*	@param: (string) $object
	*	@return: (html) view of email template configuration based on tab
	*/
	function load_email_template($tab='welcome_staff') {
		switch($tab){
			case 'welcome_staff':
				$data['template'] = $this->email_template_model->get_template(1);
			break;	
			case 'roster_update':
				$data['template'] = $this->email_template_model->get_template(2);
			break;
			case 'apply_shift':
				$data['template'] = $this->email_template_model->get_template(3);
			break;
			case 'shift_reminder':
				$data['template'] = $this->email_template_model->get_template(4);
			break;
			case 'work_confirmation':
				$data['template'] = $this->email_template_model->get_template(5);
			break;
			case 'forgot_password':
				$data['template'] = $this->email_template_model->get_template(6);
			break;
			case 'client_invoice':
				$data['template'] = $this->email_template_model->get_template(7);
			break;
			case 'client_quote':
				$data['template'] = $this->email_template_model->get_template(8);
			break;
		}
		$this->load->view($tab, isset($data) ? $data : NULL);
	}
	
	function update_template()
	{
		$name_prefix = $this->input->post('form_name_prefix',true);
		$template_id = $this->input->post('template_update_id',true);
		$email_from = $this->input->post($name_prefix.'email_from',true);
		$email_subject = $this->input->post($name_prefix.'email_subject',true);
		$email = $this->input->post($name_prefix.'email',true);
		$data = array(
					'template_content' => $email,
					'email_from' => $email_from,
					'email_subject' => $email_subject,
					'modified' => date('Y-m-d H:i:s')
					);
		echo $this->email_template_model->update_template($template_id,$data);
	}
	
}