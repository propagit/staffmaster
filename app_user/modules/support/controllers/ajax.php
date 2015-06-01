<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends MX_Controller {
	/**
	*	@class_desc Support Module Ajax Controller
	*
	*
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->model('support_model');
	}


	/**
	*	@name: reload_supports
	*	@desc: This function reloads support tickets. Mostly after a new support ticket has been lodged etc.
	*	@access: public
	*	@param: (null)
	*	@return: returns most recent support tickets
	*/
	function reload_supports()
	{
		echo modules::run('support/load_support_tickets');
	}

	/**
	*	@name: lodge_admin_support
	*	@desc: Sends support ticket from admin to SM support staff
	*	@access: public
	*	@param: ([via post], Ticket title, message, support type)
	*	@return: success or failed status for sending email
	*/
	function lodge_admin_support()
	{
		$this->load->model('setting/setting_model');
		$company = $this->setting_model->get_profile();
		$ticket_title = $this->input->post('ticket_title');
		$support_type = $this->input->post('support_type');
		$support_message = $this->input->post('support_message');
		$user = $this->session->userdata('user_data');


		$client_company = $company['company_name'];
		$from = $user['email_address'];
		$from_text = 'Support Ticket - '.$client_company;
		$subject = $support_type.' - '.$client_company.' - '.$ticket_title;
		$data = array(
					'email_message' => $support_message,
					'client_name' => $client_company,
					'lodged_by' => $user['first_name'].' '.$user['last_name'].' - '.date('d F, Y, h:i a'),
					'support_type' => $support_type
					);

		$email_data = array(
						'to' => SMTEAM_EMAIL,
						'from' => $from,
						'from_text' => $from_text,
						'subject' => $subject,
						'message' => modules::run('support/load_admin_support_email_body',$data)
							);
		echo modules::run('email/send_email',$email_data);

	}

}
