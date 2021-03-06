<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: job
*	@controller: calendar
*/

class Calendar extends MX_Controller {

	var $user = null;
	var $is_client = false;
	function __construct()
	{
		parent::__construct();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		$this->user = $this->session->userdata('user_data');
		$this->is_client = modules::run('auth/is_client');
	}

	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{
			case 'get_company_calendar_data':
				$this->get_company_calendar_data($param1,$param2,$param3);
			break;
			case 'main':
					$this->main_view();
				break;
			default:
				$this->main_view();
				#$this->home();
			break;
		}
	}

	function main_view()
	{
		if ($this->is_client)
		{
			$this->session->set_userdata('company_calendar_filter_client_id', $this->user['user_id']);
		}
		$data['clients'] = modules::run('client/get_clients');
		$data['states'] = modules::run('common/get_states');
		$data['user_id'] = $this->user['user_id'];
		$this->load->view('calendar/main_view', isset($data) ? $data : NULL);
	}

	/**
	*	@desc Loads company calendar which contains all the shift count for a month based on their status
	*
	*   @name home
	*	@access public
	*	@param (post) date
	*	@return loads view file which shows the shift data in a monthly calendar
	*
	*/
	function home()
	{
		$selected_client_user_id = 0;
		$this->session->unset_userdata('company_calendar_filter_client_id');

		$selected_state_code = 'all';
		$this->session->unset_userdata('company_calendar_filter_state_code');

		$data['selected_client_user_id'] = $selected_client_user_id;
		$data['selected_state_code'] = $selected_state_code;
		$data['clients'] = modules::run('client/get_clients');
		$data['states'] = modules::run('common/get_states');
		$this->load->view('calendar/home', isset($data) ? $data : NULL);
	}
	/**
	*	@desc Formats company calendar data for each calendar day
	*
	*   @name get_company_calendar_data
	*	@access public
	*	@param (string / int) month , (string / int) year
	*	@return json encoded array of events for the calendar
	*
	*/
	function get_company_calendar_data($month = '',$year = '',$timezone='')
	{
		if(!$month){
			$month = date('m');
		}
		if(!$year){
			$year = date('Y');
		}
		$new_date = $month.' '.$year;
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
		if ($this->is_client)
		{
			$filters['client_user_id'] = $this->user['user_id'];
		}
		$job_campaign = $this->job_shift_model->get_job_campaing_count_by_year_and_month($month,$year,$filters);
		$unassigned = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned',$filters);//status 0
		$unassigned_alert = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned',$filters, false, true);//status 0
		$unconfirmed = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unconfirmed',$filters);//status 1
		$rejected = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'rejected',$filters);//status -1
		$confirmed = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'confirmed',$filters);//status 2
		$completed = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'completed',$filters);//status 3


		//merge the records in one array
		//this is so that the its easier to display.
		$merged_array = array();

		foreach($job_campaign as $jc){
			$merged_array[$jc->job_date]['job_campaign']['count'] = $jc->total_jobs;
		}
		if (!$this->is_client)
		{
			foreach($unassigned_alert as $ua){
				$merged_array[$ua->job_date]['unassigned_alert']['count'] = $ua->total_shifts;
			}
		}
		foreach($unassigned as $ua){
			$merged_array[$ua->job_date]['unassigned']['count'] = $ua->total_shifts;
		}
		foreach($unconfirmed as $uc){
			$merged_array[$uc->job_date]['unconfirmed']['count'] = $uc->total_shifts;
		}
		foreach($rejected as $rs){
			$merged_array[$rs->job_date]['rejected']['count'] = $rs->total_shifts;
		}
		foreach($confirmed as $cs){
			$merged_array[$cs->job_date]['confirmed']['count'] = $cs->total_shifts;
		}
		foreach($completed as $cmps){
			$merged_array[$cmps->job_date]['completed']['count'] = $cmps->total_shifts;
		}

		foreach($merged_array as $key => $val){

			$key = strtotime($key);
			if (date('I', $key))
			{
				$key += 3600;
			}
			if ($timezone != '') {
				$offset = $this->get_timezone_offset('Australia/Melbourne', $timezone);
				$key = $key - $offset;
			}


			$out[] = array(
							'active_job_campaigns' => isset($val['job_campaign']['count']) ? $val['job_campaign']['count'] : '',
							'unfilled_shifts' => isset($val['unassigned']['count']) ? $val['unassigned']['count'] : '',
							'alert_shifts' => isset($val['unassigned_alert']['count']) ? $val['unassigned_alert']['count'] : '',
							'unconfirmed_shift' => isset($val['unconfirmed']['count']) ? $val['unconfirmed']['count'] : '',
							'rejected_shift' => isset($val['rejected']['count']) ? $val['rejected']['count'] : '',
							'confirmed_shift' => isset($val['confirmed']['count']) ? $val['confirmed']['count'] : '',
							'completed_shift' => isset($val['completed']['count']) ? $val['completed']['count'] : '',
							'url' => 'test',
							'start' => $key.'000',
							'end' => $key.'000'
						);
		}
		if(!$out){
			$new_date = strtotime($new_date);

			if ($timezone != '') {
				$offset = $this->get_timezone_offset('Australia/Melbourne', $timezone);
				$new_date = $new_date - $offset;
			}
			if (date('I', $new_date))
			{
				$new_date += 3600;
			}
			$out[] = array(
				'active_job_campaigns' => '-',
				'unfilled_shifts' => '-',
				'unconfirmed_shift' => '-',
				'rejected_shift' => '-',
				'confirmed_shift' => '-',
				'completed_shift' => '-',
				'url' => 'test',
				'start' => $new_date.'000',
				'end' => $new_date.'000'
				);
		}

		return json_encode($out);
	}

	function get_timezone_offset($remote_tz, $origin_tz = null) {
	    if($origin_tz === null) {
	        if(!is_string($origin_tz = date_default_timezone_get())) {
	            return false; // A UTC timestamp was returned -- bail out!
	        }
	    }
	    $origin_dtz = new DateTimeZone($origin_tz);
	    $remote_dtz = new DateTimeZone($remote_tz);
	    $origin_dt = new DateTime("now", $origin_dtz);
	    $remote_dt = new DateTime("now", $remote_dtz);
	    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
	    return $offset;
	}
}
