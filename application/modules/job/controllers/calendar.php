<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	@desc: Calendar controller
 *	
 */

class Calendar extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler();
		$this->load->model('job_model');
		$this->load->model('job_shift_model');
		//$this->user = $this->session->userdata('user_data');
	}
	
	function index($method='', $param1='', $param2='', $param3='',$param4='')
	{
		switch($method)
		{
			case 'get_company_calendar_data':
				$this->get_company_calendar_data($param1,$param2);
			break;
			
			default:
				$this->home();
			break;
		}
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
		if($this->session->userdata('company_calendar_filter_client_id')){
			$selected_client_user_id = $this->session->userdata('company_calendar_filter_client_id');
		}
		$data['selected_client_user_id'] = $selected_client_user_id;
		$data['clients'] = modules::run('client/get_clients');
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
	function get_company_calendar_data($month = '',$year = '')
	{
		if(!$month){
			$month = date('m');
		}
		if(!$year){
			$year = date('Y');	
		}
		$new_date = $month.' '.$year;
		$active_jobs = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'active');
		$unassigned = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unassigned');//status 0
		$unconfirmed = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'unconfirmed');//status 1
		$confirmed = $this->job_shift_model->get_shift_by_year_and_month($month,$year,'confirmed');//status 2
		
		
		//merge the records in one array
		//this is so that the its easier to display. 
		$merged_array = array();
		
		foreach($active_jobs as $aj){
			$merged_array[$aj->job_date]['active_jobs']['count'] = $aj->total_shifts;
		}
		foreach($unassigned as $ua){
			$merged_array[$ua->job_date]['unassigned']['count'] = $ua->total_shifts;
		}
		foreach($unconfirmed as $uc){
			$merged_array[$uc->job_date]['unconfirmed']['count'] = $uc->total_shifts;
		}
		foreach($confirmed as $cs){
			$merged_array[$cs->job_date]['confirmed']['count'] = $cs->total_shifts;
		}
		
		foreach($merged_array as $key => $val){
			$out[] = array(
							'active_job_campaigns' => isset($val['active_jobs']['count']) ? $val['active_jobs']['count'] : 0,
							'unfilled_shifts' => isset($val['unassigned']['count']) ? $val['unassigned']['count'] : 0,
							'unconfirmed_shift' => isset($val['unconfirmed']['count']) ? $val['unconfirmed']['count'] : 0,
							'confirmed_shift' => isset($val['confirmed']['count']) ? $val['confirmed']['count'] : 0,
							'url' => 'test',
							'start' => strtotime($key).'000',
							'end' => strtotime($key).'000'
						);
		}
		if(!$out){
			$out[] = array(
				'active_job_campaigns' => '',
				'unfilled_shifts' => '',
				'unconfirmed_shift' => '',
				'confirmed_shift' => '',
				'url' => 'test',
				'start' => strtotime($new_date).'000',
				'end' => strtotime($new_date).'000'
				);
		}
		
		return json_encode($out);
	}
	
	
}