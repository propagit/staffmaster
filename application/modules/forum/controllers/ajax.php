<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Ajax
 * @author: namnd86@gmail.com
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('forum_model');
	}
	
	/**
	*	@name: reload_conversation
	*	@desc: This function reloads conversations. Mostly after a new conversation has been created etc.
	*	@access: public
	*	@param: (null)
	*	@return: returns 10 most recent conversation
	*/
	function reload_conversation()
	{
		echo modules::run('forum/load_converation');	
	}
	/**
	*	@name: create_topic_form
	*	@desc: Provides user with a UI to start fresh conversation topic. This is generally provided in a modal window.
	*	@access: public
	*	@param: (null)
	*	@return: loads the UI to create conversations (forum topics)
	*/
	function create_topic_form() {
		$this->load->view('create_topic_form', isset($data) ? $data : NULL);
	}
	/**
	*	@name: start_conversation
	*	@desc: Adds new conversation topic
	*	@access: public
	*	@param: (via post) conversation title, conversation message, documents 
	*	@return: status of the initiation process i.e. successful or not.
	*/
	function start_conversation()
	{
		$title = $this->input->post('conversation_title',true);
		$message = $this->input->post('conversation_message',true);
		$group_id = $this->input->post('conversation_groups',true);
		$send_by_email = $this->input->post('send_by_email',true);
		
		
		$user_info = $this->session->userdata('user_data');
		//insert data
		$data = array(
					'title' => $title,
					'message' => $message,
					'group_id' => $group_id,
					'created_by' => $user_info['user_id']
					);
		$insert_id = $this->forum_model->add_topic($data);
		
		//if a file has been uploaded
		if($_FILES['userfile']['name']){			
			$path = $_FILES['userfile']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$img_ext_chk = array('jpg','png','gif','jpeg');
			$doc_ext_chk = array('pdf','doc','docx');
			
			$main_path = './uploads/conversation/';
			$this->load->library('upload');
			
			if (in_array($ext,$img_ext_chk)){
				//image
				$subfolders = array('thumb');
				$salt = 'forum'.$insert_id;
				//create folders
				$folder_name = $this->_create_folders('./uploads/conversation/img',$salt,$subfolders);
				$file_path = $main_path.'img/';
				$config['upload_path'] = $file_path.$folder_name;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_width']  = '2000';
				$config['max_height']  = '2000';
				$document_type = 'image';
					
			}elseif (in_array($ext,$doc_ext_chk)){
				//documents
				$salt = 'forum'.$insert_id;
				//create folders
				$folder_name = $this->_create_folders('./uploads/conversation/docs',$salt);
				$file_path = $main_path.'docs/';
				$config['upload_path'] = $file_path.$folder_name;
				$config['allowed_types'] = 'pdf|doc|docx';
				$document_type = 'file';
			}

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
					'document_type' => $document_type,
					'document_name' => $file_name									
				);
				$this->forum_model->update_topic($insert_id,$file_data);
				//create thumbnail if file type is image
				if (in_array($ext,$img_ext_chk)){
					$thumb_path = $main_path.'img/'.$folder_name;
					$this->_resize_photo($file_name,$thumb_path,"thumb",450,338);
				}
			}
		}
		
		echo 'success';
	}
	
	/**
	*	@name: _create_folders
	*	@desc: Creates folder for documents
	*	@access: private
	*	@param: (string) path of the folder, (string) salt, (array) array of subfolders if applicable
	*	@return: returns the folder name to the control that called this function
	*/
	function _create_folders($path,$salt,$subfolders = null)
	{	
		//create staff specific folders
		if($path && $salt){
			$newfolder = md5($salt);
			$dir = $path."/".$newfolder;
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			
			$sub_dir = '';
			if($subfolders){
				foreach($subfolders as $folder){
					$sub_dir = $dir.'/'.$folder;	
					if(!is_dir($sub_dir))
					{
					  mkdir($sub_dir);
					  chmod($sub_dir,0777);
					  $fp = fopen($sub_dir.'/index.html', 'w');
					  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
					  fclose($fp);
					}		
				}
			}
			return $newfolder;
		}
		
	}
	/**
	*	@name: _resize_photo
	*	@desc: Create thumbnails for images
	*	@access: private
	*	@param: (string) path of the folder, (string) salt, (array) array of subfolders if applicable
	*	@return: returns the folder name to the control that called this function
	*/
	function _resize_photo($name,$directory,$sub,$width,$height,$maintain_ratio = TRUE) 
	{
		$config = array();
		$config['source_image'] = $directory."/".$name;
		$config['create_thumb'] = FALSE;
		$config['new_image'] = $directory."/".$sub."/".$name;
		$config['maintain_ratio'] = $maintain_ratio;
		$config['quality'] = 100;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();		
		$this->image_lib->clear();	
	}
	
	
}