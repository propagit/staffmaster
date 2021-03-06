<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Work/Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('work_model');
	}
	
	/**
	*	@name: load_works
	*	@desc: ajax function to load list of works group by date
	*	@access: public
	*	@param: (void)
	*	@return: (html) list view of works group by date
	*/
	function load_works() {
		$active_month = $this->session->userdata('active_month_work');
		$data['work_days'] = $this->work_model->get_work_days(date('Y-m', $active_month));
		$this->load->view('staff/days_list_view', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: load_month_works
	*	@desc: ajax function to set the active month and then reload works
	*	@access: public
	*	@param: (POST) ts (timestamp)
	*	@return: (void)
	*/
	function load_month_works() {
		$this->session->set_userdata('active_month_work', $this->input->post('ts'));
	}
	
		
	function load_day_shifts() {
		$date = $this->input->post('date');
		
		$open_days = $this->session->userdata('open_days');
		$open_days[] = $date;
		$this->session->set_userdata('open_days', $open_days);
		
		$data['shifts'] = $this->work_model->get_day_shifts($date);
		$data['date'] = $date;
		$this->load->view('staff/day_shifts_table_view', isset($data) ? $data : NULL);
	}
	
	
	function hide_day_shifts() {
		$open_days = $this->session->userdata('open_days');
		
		foreach (array_keys($open_days, $this->input->post('date')) as $key) {
			unset($open_days[$key]);
		}

		$this->session->set_userdata('open_days', $open_days);
	}
	
	function apply_shifts()
	{
		$shifts = $this->input->post('shifts');
		foreach($shifts as $shift_id)
		{
			$this->work_model->insert_shift_staff_apply($shift_id);
		}
	}
	
	function unapply_shift()
	{
		$shift_id = $this->input->post('shift_id');
		$this->work_model->delete_shift_staff($shift_id);
	}
	
	function is_shift_applied($shift_id)
	{
		return $this->work_model->is_shift_staff_applied($shift_id);
	}
	
	
	
	function load_roster_brief()
	{
		$this->load->view('staff/work_brief', isset($data) ? $data : NULL);
	}
}