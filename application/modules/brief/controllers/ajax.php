<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	/**
	*	@class_desc Ajax controller for brief module
	*	
	*
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->model('brief_model');
	}
	
	/**
	*	@name: add_brief_elements
	*	@desc: Ajax function to add brief elements to a brief
	*	@access: public
	*	@param: (POST) mostly contains the element type such as header, description, file and the content.
	*	@return: brief id
	*	@comments: To be extended in V2 which will allow html elements and more powerful functions such as surveys 
	*/
	function add_brief_elements()
	{
		$element_type = $this->input->post('element_type');
		$brief_id = $this->input->post('brief_id');
		$brief_content = $this->input->post('brief_content');

		$data_brief_elements = array(
								'brief_id' => $brief_id,
								'element_type' => $element_type,
								'element_content' => $brief_content,
								'element_order' => $this->brief_model->get_brief_elements_next_order($brief_id)
								);
		$brief_element_id = $this->brief_model->add_brief_elements($data_brief_elements);	
	
		
		//for document uploads
		//if a file has been uploaded
		//this ignores previous files that has been uploaded as the system is cleaned every six month
		if(isset($_FILES['userfile']['name'])){
			//create main folders
			modules::run('upload/create_upload_folders','./uploads/brief/');
			$path = $_FILES['userfile']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$img_ext_chk = array('jpg','png','gif','jpeg');
			$doc_ext_chk = array('pdf','doc','docx','csv');
			
			$main_path = './uploads/brief/';
			$this->load->library('upload');
			
		   	if (in_array($ext,$img_ext_chk)){
				$document_type = 'image';  
		    }elseif (in_array($ext,$doc_ext_chk)){
				$document_type = 'document';
		    }
			$salt = 'brief'.$brief_id;
			//create folders
			$folder_name = modules::run('upload/create_folders','./uploads/brief',$salt);
			$config['upload_path'] = $main_path.$folder_name;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|csv';
			$config['max_width']  = '2000';
			$config['max_height']  = '2000';

			$config['max_size']	= '4096'; // 4 MB
			$config['overwrite'] = FALSE;
			$config['remove_space'] = TRUE;
			
			$this->upload->initialize($config);
			
			if (!$this->upload->do_upload()){
				$this->session->set_flashdata('error_with_fileupload',$this->upload->display_errors());			
			}else{
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
				$document_name = $this->input->post('document_name');
				$file_data = array(
					'element_type' => $document_type,
					'element_content' => $file_name,
					'document_name' => $document_name									
				);
				$this->brief_model->update_brief_elements($brief_element_id,$file_data);
			}
		}
		
		echo $brief_id;
	}
	/**
	*	@name: load_brief_preview
	*	@desc: Ajax function to load the preview of the brief.
	*	@access: public
	*	@param: ([via post] brief id)
	*	@return: Loads a preview of brief
	*/
	function load_brief_preview()
	{
		$brief_id = $this->input->post('brief_id');
		if($brief_id){
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief_id);	
		}
		$this->load->view('brief_preview', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: load_create_brief_modal
	*	@desc: This loads the preview of the brief.
	*	@access: public
	*	@param: ([int] brief id)
	*	@return: Loads a preview of brief
	*/
	function load_create_brief_modal()
	{
		$this->load->view('create_brief_modal', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: edit_brief_name
	*	@desc: Ajax function for inline editing the brief header
	*	@access: public
	*	@param: ([vai post] brief id and new name)
	*	@return: Loads a preview of brief
	*/
	function edit_brief_name()
	{
		$brief_id = $this->input->post('pk');
		$name = $this->input->post('value');
		//remove the "encoded_url" on production
		//as "encoded_url" was put later to avoide db re import this is added so that it can be quickly updated
		$data = array(
					'name' => $name,
					'encoded_url' => md5('brief_url'.$brief_id),
					'modified' => date('Y-m-d H:i:s')
					);
		# Update brief
		$this->brief_model->update_brief($brief_id, $data);
	}
	/**
	*	@name: search_brief
	*	@desc: Searches brief by keyword and sort parameters
	*	@access: public
	*	@param: ([via post] keywords and sort parameters)
	*	@return: Returns search results
	*/
	function search_brief()
	{
		$params = $this->input->post();
		$data['briefs'] = $this->brief_model->search_brief($params);
		$this->load->view('ajax-brief-lists', isset($data) ? $data : NULL);		
	}
	/**
	*	@name: delete_brief
	*	@desc: Deletes brief and all its elements and documents.
	*	@access: public
	*	@param: ([via post] brief id)
	*	@return: success or failed status
	*/
	function delete_brief()
	{
		$brief_id = $this->input->post('brief_id');
		//delete files
		$path = './uploads/brief/'.md5('brief'.$brief_id);
		modules::run('upload/delete_dir_and_contents',$path);
		//delete brief
		$this->brief_model->delete_brief($brief_id);
		//delete brief elements
		$this->brief_model->delete_brief_elements_by_brief_id($brief_id);
		//delete shift brief
		$this->brief_model->delete_shift_brief_by_brief_id($brief_id);
		echo 'success';
	}
	/**
	*	@name: edit_brief_element
	*	@desc: Ajax function for inline editing the brief element
	*	@access: public
	*	@param: ([vai post] brief element id and new content)
	*	@return: Loads a preview of brief
	*/
	function edit_brief_element()
	{
		$brief_element_id = $this->input->post('pk');
		$content = $this->input->post('value');
		$data = array(
					'element_content' => $content,
					'modified' => date('Y-m-d H:i:s')
					);
		# Update brief element
		$this->brief_model->update_brief_elements($brief_element_id, $data);
	}
	/**
	*	@name: delete_brief
	*	@desc: Deletes brief and all its elements and documents.
	*	@access: public
	*	@param: ([via post] brief id)
	*	@return: success or failed status
	*/
	function delete_brief_element()
	{
		$brief_element_id = $this->input->post('brief_element_id');
		$brief_element_info = $this->brief_model->get_brief_elements_by_brief_element_id($brief_element_id);

		if($brief_element_info->element_type == 'document' || $brief_element_info->element_type == 'image'){
			//delete files
			$path = './uploads/brief/'.md5('brief'.$brief_element_info->brief_id).'/'.$brief_element_info->element_content;
			if(file_exists($path)){
				unlink($path);
			}
		}

		//delete brief element
		$this->brief_model->delete_brief_elements_by_brief_element_id($brief_element_id);
		echo 'success';
	}
	/**
	*	@name: load_brief_for_brief_viewer
	*	@desc: Ajax function to load the preview of the brief in brief viewer templage.
	*	@access: public
	*	@param: ([via post] brief id)
	*	@return: Loads a preview of brief
	*/
	function load_brief_for_brief_viewer()
	{
		$brief_id = $this->input->post('brief_id');
		if($brief_id){
			$data['brief'] = $this->brief_model->get_brief($brief_id);
			$data['brief_elements'] = $this->brief_model->get_brief_elements($brief_id);	
		}
		$this->load->view('brief_viewer/brief_preview_brief_viewer', isset($data) ? $data : NULL);	
	}
	
}