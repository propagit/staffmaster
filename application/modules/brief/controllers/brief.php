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
	}
	
	function index($method='', $param='')
	{
		
		switch($method)
		{
			case 'edit':
				$this->edit($param);
			break;
			case 'create_brief':
				$this->create_brief();
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
	*	@name: load_brief_preview
	*	@desc: This loads the preview of the brief.
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: Loads a preview of brief
	*/
	function load_brief_preview($brief_id = NULL)
	{
		if($brief_id){
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief_id);	
		}
		$this->load->view('brief_preview', isset($data) ? $data : NULL);
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
		redirect('brief/edit/'.$insert_id);
	}
	
	/**
	*	@name: select_brief
	*	@desc: Creates new brief
	*	@access: public
	*	@param: ([via post] brief info such as brief name etc)
	*	@return: Redirects to edit page where user will be provided with tools to add elements to the brief.
	*/
	function brief_select_field($field_name, $field_value=null)
	{
		$briefs = $this->brief_model->get_all_brief(true);
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
	



}