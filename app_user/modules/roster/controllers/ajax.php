<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Dashboard_staff
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('roster_model');
	}
	
	
	public function load_rosters() {
		$active_month = $this->session->userdata('active_month_roster');
		$data['rosters'] = $this->roster_model->get_rosters(date('Y-m', $active_month));
		$this->load->view('staff/rosters_table_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: load_month_rosters
	*	@desc: ajax function to set active month to the session
	*	@access: public
	*	@param: (POST) ts (timestamp)
	*	@return: (void)
	*/
	function load_month_rosters() {
		$this->session->set_userdata('active_month_roster', $this->input->post('ts'));
	}
	
	
	function confirm_rosters()
	{
		$rosters = $this->input->post('rosters');
		foreach($rosters as $roster)
		{
			$this->roster_model->update_roster($roster, array('status' => SHIFT_CONFIRMED));
		}
	}
	function reject_rosters()
	{
		$rosters = $this->input->post('rosters');
		foreach($rosters as $roster)
		{
			$this->roster_model->update_roster($roster, array('status' => SHIFT_REJECTED));
		}
	}
	
	function load_roster_venue($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('staff/roster_map', isset($data) ? $data : NULL);
	}
	
	function map($venue_id)
	{
		$data['venue'] = modules::run('attribute/venue/get_venue', $venue_id);
		$this->load->view('staff/map', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: send_email
	*	@desc: Send roster to self. This function is invoked by the staff themselves 
	*	@access: public
	*	@param: (none)
	*	
	*/
	function email_roster()
	{
		$this->load->model('setting/setting_model');
		$this->load->model('email/email_template_model');
		$this->load->model('user/user_model');
		//get company profile
		$company = $this->setting_model->get_profile();	
		//get post data
		$email_template_id = ROSTER_UPDATE_EMAIL_TEMPLATE_ID;

		$template_info = $this->email_template_model->get_template($email_template_id);
		$email_subject = $template_info->email_subject;

		$user = $this->session->userdata('user_data');
		$user_id = $user['user_id'];

		$send_email = true;
		$active_month = date('Y-m');
		$rosters = $this->roster_model->get_user_rosters_by_month($user_id,$active_month);
		if(!count($rosters)){
			$send_email = false;
		}
		
		if($send_email){
			$email = $this->user_model->get_user_email_from_user_id($user_id);
			//get receiver obj
			$email_obj_params = array(
							'template_id' => $email_template_id,
							'user_id' => $user_id,
							'company' => $company
						);
			$obj = modules::run('email/get_email_obj',$email_obj_params);
			if($email){
				$email_data = array(
							'to' => $email,
							'from' => $company['email_c_email'],
							'from_text' => $company['email_c_name'],
							'subject' => modules::run('email/format_template_body',$template_info->email_subject,$obj),
							'message' => modules::run('email/format_template_body',$template_info->template_content,$obj)
						);
				modules::run('email/send_email',$email_data);
			}
		}
		echo 'Done';
	}

}