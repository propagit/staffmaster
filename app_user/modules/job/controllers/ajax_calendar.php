<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@desc: Ajax controller for calenadar
 *
 */

class Ajax_calendar extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
	}

	function load_calendar()
	{
		$month = $this->input->post('month');
		$timezone = $this->input->post('timezone');
		$data['custom_date'] = date('Y-m-d', strtotime($month));
		$data['events_source'] = modules::run('job/calendar/get_company_calendar_data', date('m', strtotime($month)), date('Y', strtotime($month)), $timezone);
		$this->load->view('calendar/calendar_view', isset($data) ? $data : NULL);
	}

	function load_month_summary()
	{
		$new_date = $this->input->post('month');
		$month = date('m',strtotime($new_date));
		$year = date('Y',strtotime($new_date));
		$client_user_id = 0;
		$state_code = 0;
		if($this->session->userdata('company_calendar_filter_client_id')){
			$client_user_id = $this->session->userdata('company_calendar_filter_client_id');
		}
		if($this->session->userdata('company_calendar_filter_state_code')){
			$state_code = $this->session->userdata('company_calendar_filter_state_code');
		}
		$filters = array(
						'client_user_id' => $client_user_id,
						'state_code' => $state_code
						);
		$data['job_campaign'] = $this->job_shift_model->get_job_campaing_count_by_year_and_month($month,$year,$filters,true);
		$data['client'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned',$filters,true, true);
		$data['unassigned'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned',$filters,true); //status 0
		$data['unconfirmed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unconfirmed',$filters,true);//status 1
		$data['rejected'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'rejected',$filters,true);//status -1
		$data['confirmed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'confirmed',$filters,true);//status 2
		$data['completed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'completed',$filters,true);//status 3
		echo json_encode($data);
	}

	/**
	*	@desc Loads company calendar which contains all the shift count for a month based on their status
	*
	*   @name get_calendar_data
	*	@access public
	*	@param (post) date
	*	@return loads view file which shows the shift data in a monthly calendar
	*
	*/
	function get_calendar_data()
	{
		$new_date = $this->input->post('new_date',true);
		$month = date('m',strtotime($new_date));
		$year = date('Y',strtotime($new_date));
		$data['custom_date'] = $new_date;
		$data['events_source'] = modules::run('job/calendar/get_company_calendar_data',$month,$year);
		echo $this->load->view('calendar/company_calendar', isset($data) ? $data : NULL);

	}
	/**
	*	@desc Loads shift total counts for a month based on their status
	*
	*   @name get_calendar_data_summary
	*	@access public
	*	@param (post) date
	*/
	function get_calendar_data_summary()
	{
		$new_date = $this->input->post('new_date',true);
		$month = date('m',strtotime($new_date));
		$year = date('Y',strtotime($new_date));
		$client_user_id = 0;
		$state_code = 0;
		if($this->session->userdata('company_calendar_filter_client_id')){
			$client_user_id = $this->session->userdata('company_calendar_filter_client_id');
		}
		if($this->session->userdata('company_calendar_filter_state_code')){
			$state_code = $this->session->userdata('company_calendar_filter_state_code');
		}
		$filters = array(
						'client_user_id' => $client_user_id,
						'state_code' => $state_code
						);
		$data['job_campaign'] = $this->job_shift_model->get_job_campaing_count_by_year_and_month($month,$year,$filters,true);
		$data['unassigned'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned',$filters,true); //status 0
		$data['unconfirmed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unconfirmed',$filters,true);//status 1
		$data['rejected'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'rejected',$filters,true);//status -1
		$data['confirmed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'confirmed',$filters,true);//status 2
		$data['completed'] = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'completed',$filters,true);//status 3
		echo json_encode($data);
	}
	/**
	*	@desc This sets the filter data for company calendar. The current filters are filter by client and filter by state
	*
	*   @name set_company_calendar_filter
	*	@access public
	*	@param (via post) user id of client and state id
	*
	*/
	function set_company_calendar_filter()
	{
		$client_user_id = $this->input->post('client_user_id',true);
		$state_code =  $this->input->post('state_code',true);
		if($client_user_id){
			$this->session->set_userdata('company_calendar_filter_client_id',$client_user_id);
		}
		if($state_code){
			$this->session->set_userdata('company_calendar_filter_state_code',$state_code);
		}
		echo 'filter set';
	}

	function set_filter()
	{
		$filter = $this->input->post();
		$this->session->set_userdata('company_calendar_filter_' . $filter['name'], $filter['value']);
	}


	function redirect_to_shift_search()
	{
		$client_user_id = $this->input->post('client_user_id',true);
		$shift_date = $this->input->post('shift_date',true);
		$shift_status = $this->input->post('shift_status',true);
		$search_job_or_shift = 'shift';
		$client = '';
		if($client_user_id){
			$client = modules::run('client/get_client',$client_user_id);
		}

		$constant_shift_status = 'all';
		if($shift_status != 'all'){
			switch(trim($shift_status)){
				case -2:
					$constant_shift_status = SHIFT_DELETED;
				break;

				case -1:
					$constant_shift_status = SHIFT_REJECTED;
				break;

				case 0:
					$constant_shift_status = SHIFT_UNASSIGNED;
				break;

				case 1:
					$constant_shift_status = SHIFT_UNCONFIRMED;
				break;

				case 2:
					$constant_shift_status = SHIFT_CONFIRMED;
				break;

				case 3:
					$constant_shift_status = SHIFT_FINISHED;
				break;

			}
		}

		$data = array(
						'client_user_id' => $client_user_id,
						'client_client_id' => ($client ? $client['client_id'] : ''),
						'shift_date' => date('d-m-Y',strtotime($shift_date)),
						'search_shift_date_to' => date('d-m-Y',strtotime($shift_date)),
						'shift_status' => $constant_shift_status,
						'staff_name' => '',
						'search_job_or_campaign' => $search_job_or_shift
					);
		$this->session->set_flashdata('search_shift_filters',$data);
		echo 'var sets';
	}

}
