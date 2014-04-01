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
	
	function add_brief()
	{
		$element_type = $this->input->post('element_type');
		$brief_id = $this->input->post('brief_id');
		$brief_content = $this->input->post('brief_content');
		$return_brief_id = 0;
		if($brief_id == 0){
			//add to brief element only	
			$data_brief = array(
					'name' => 'NA'
					);
			$insert_id = $this->brief_model->add_brief($data_brief);
			$data_brief_elements = array(
									'brief_id' => $insert_id,
									'element_type' => $element_type,
									'element_content' => $brief_content,
									'element_order' => 0
									);
			$this->brief_model->add_brief_elements($data_brief_elements);
			$return_brief_id = $insert_id;
		}else{
			//create new brief and brief element
			$data_brief_elements = array(
									'brief_id' => $brief_id,
									'element_type' => $element_type,
									'element_content' => $brief_content,
									'element_order' => $this->brief_model->get_brief_elements_next_order($brief_id)
									);
			$brief_element_id = $this->brief_model->add_brief_elements($data_brief_elements);	
			$return_brief_id = $brief_id;
		}
		
		//for document uploads
		//if a file has been uploaded
		//this ignores previous files that has been uploaded as the system is cleaned every six month
		if(isset($_FILES['userfile']['name'])){

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
			$salt = 'brief'.$return_brief_id;
			//create folders
			$folder_name = modules::run('common/create_folders','./uploads/brief',$salt);
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
				$file_data = array(
					'element_type' => $document_type,
					'element_content' => $file_name									
				);
				$this->brief_model->update_brief_elements($brief_element_id,$file_data);
			}
		}
		
		echo $return_brief_id;
	}
	
	function load_brief_preview()
	{
		$brief_id = $this->input->post('brief_id');
		echo modules::run('brief/load_brief_preview',$brief_id); 	
	}
	
	
	
}