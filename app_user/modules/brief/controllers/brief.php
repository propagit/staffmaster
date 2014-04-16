<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Brief extends MX_Controller {

	/**
	*	@class_desc Brief controller. 
	*	
	*
	*/
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('brief_model');
		$this->load->model('job/job_shift_model');
	}
	
	function index($method='', $param='',$param2='')
	{
		
		switch($method)
		{
			case 'edit':
				$this->edit($param);
			break;
			case 'create_brief':
				$this->create_brief();
			break;
			//loads in briev viewer template
			case 'view_brief':
				$this->view_brief($param,$param2);
			break;
			case 'view':
				$this->view($param);
			break;
			default:
				$this->list_view($param);
			break;
		}
		
	}
	/**
	*	@name: list_view
	*	@desc: This is the default view for brief builder module. This loads the list of existing brief and allows user to search existing brief and add new brief.
	*	@access: public
	*	@param: (null)
	*	@return: Loads list of existing brief
	*/
	function list_view()
	{
		$this->load->view('brief_list_view', isset($data) ? $data : NULL);
	}
	/**
	*	@name: edit
	*	@desc: Provides UI to add elements to a brief such as documents and instructions.
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: Loads UI which allows user to add new elements to a brief.
	*/
	function edit($brief_id)
	{
		$data['brief'] = $this->brief_model->get_brief($brief_id);
		$data['brief_id'] = $brief_id;
		$this->load->view('edit_brief', isset($data) ? $data : NULL);
	}
	/**
	*	@name: create_brief
	*	@desc: Creates new brief
	*	@access: public
	*	@param: ([via post] brief info such as brief name etc)
	*	@return: Redirects to edit page where user will be provided with tools to add elements to the brief.
	*/
	function create_brief()
	{
		$brief_name = $this->input->post('brief_name');
		$data_brief = array(
				'name' => $brief_name
				);
		$insert_id = $this->brief_model->add_brief($data_brief);
		//add encoded url to this brief
		$this->brief_model->update_brief($insert_id,array('encoded_url' => md5('brief_url'.$insert_id)));
		
		redirect('brief/edit/'.$insert_id);
	}
	
	/**
	*	@name: brief_select_field
	*	@desc: Create brief field select field
	*	@access: public
	*	@param: ([string] field name, [varchar] field value)
	*	@return: Loads brief in field select 
	*/
	function brief_select_field($field_name, $field_value=null)
	{
		$briefs = $this->brief_model->get_all_brief();
		$array = array();
		foreach($briefs as $brief)
		{
			$array[] = array(
				'value' => $brief->brief_id,
				'label' => $brief->name
			);
		}
		return modules::run('common/field_select', $array, $field_name, $field_value);
	}
	
	/**
	*	@name: view_brief
	*	@desc: Shows brief view by shift id and brief id, the brief id can be null
	*	@access: public
	*	@param: ([int] shift id, [int] brief id)
	*	@return: Loads brief preview in the brief template
	*/
	function view_brief($shift_id,$brief_id = '')
	{
		$data['shift_info'] = $this->job_shift_model->get_shift_info($shift_id);
		$data['briefs'] = $this->job_shift_model->get_shift_brief_by_shif_id($shift_id);
		$data['brief_id'] = $brief_id;
		$data['referer'] = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url());
		
		$this->load->view('brief_viewer/view_brief', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: check_brief_status
	*	@desc: Check brief status - a brief is marked as active if any active shifts (shifts in the future) is using this brief
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: [bool] true or false
	*/
	function check_brief_status($brief_id)
	{
		return $this->brief_model->check_brief_status($brief_id);
	}
	
	/**
	*	@name: view
	*	@desc: Loads brief preview by encoded url. Mostly used when a user see it via link sent thru emails
	*	@access: public
	*	@param: ([via post] brief info such as brief name etc)
	*	@return: Loads brief preview in brief template
	*/
	function view($encoded_url)
	{
		$brief = $this->brief_model->get_brief_by_encoded_url($encoded_url);
		if($brief){
			$data['brief'] = $brief;
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief->brief_id);	
			$this->load->view('public_view/view', isset($data) ? $data : NULL);	
		}else{
			redirect(base_url().'login');
		}
	}
	



}