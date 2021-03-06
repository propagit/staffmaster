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
	*	@name: load_edit_conversation_modal
	*	@desc: Loads the most recent conversations
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns 10 most recent conversation
	*/
	function load_edit_conversation_modal($topic_id)
	{
		$data['conversation'] = $this->forum_model->get_conversation_by_id($topic_id);
		$this->load->view('create_topic_form', isset($data) ? $data : NULL);
	}
	/**
	*	@name: take_poll
	*	@desc: Adds survey info into the database when a user takes a survey
	*	@access: public
	*	@param: ([vai post][int] topic id, [int] poll answer id)
	*	@return: the poll result
	*/
	function take_poll()
	{
		$poll_answer_id = $this->input->post('poll_answer_id',true);
		$topic_id = $this->input->post('topic_id',true);
		$current_answer_stat = $this->forum_model->get_poll_answer_by_id($poll_answer_id);
		$user = $this->session->userdata('user_data');
		if($current_answer_stat){
			//update poll answer count
			$data = array(
							'answer_count' => $current_answer_stat->answer_count+1
						);
			$this->forum_model->update_poll_answers($poll_answer_id,$data);
			//mark this user as someone who has already taken the poll
			$data_user_poll_answers = array(
											'topic_id' => $topic_id,
											'poll_answer_id' => $poll_answer_id,
											'user_id' => $user['user_id']
										);
			$this->forum_model->add_user_poll_answers($data_user_poll_answers);
		}
		echo modules::run('forum/load_poll',$topic_id);
	}
	
	/**
	*	@name: load_conversation_list
	*	@desc: Loads the most recent conversations
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns 10 most recent conversation
	*/
	function load_conversation_list()
	{
		$params = $this->input->post('params',true);
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['conversations'] = $this->forum_model->get_conversations($user,$params); 
		$this->load->view('conversation_list', isset($data) ? $data : NULL);
	}
	/**
	*	@desc Delete forum reply
	*   @name delete_forum_reply
	*	@access public
	*	@param ([vai post] [int] message id)
	*	@return success or failed message
	*	
	*/
	function delete_forum_reply()
	{
		$message_id = $this->input->post('message_id',true);
		$this->forum_model->delete_conversation_reply($message_id);
		echo 'success';
	}
	
	/**
	*	@desc Delets conversation from the system including the replies for that conversation along with any documents associated with it.
	*	@comments Removes conversation from the system
	*   @name delete_conversation
	*	@access public
	*	@param null
	*	@return success for failed message
	*	
	*/
	function delete_conversation()
	{
		$topic_id = $this->input->post('delete_id',true);
		$conversation = $this->forum_model->get_conversation_by_id($topic_id);
		$file_name = $conversation->document_name;
		if($conversation->document_type == 'image'){
			//delete images
			$path = UPLOADS_PATH.'/conversation/img/'.md5('forum'.$topic_id);
			modules::run('upload/delete_dir_and_contents',$path);
		}elseif($conversation->document_type == 'file'){
			//delete documents
			$path = UPLOADS_PATH.'/conversation/docs/'.md5('forum'.$topic_id);
			modules::run('upload/delete_dir_and_contents',$path);
		}
		
		//delete replies
		$this->forum_model->delete_conversation_replies($topic_id);
		//delete conversation
		$this->forum_model->delete_conversation_topic($topic_id);
		//delete forum poll answers
		$this->forum_model->delete_poll_answers_by_topic_id($topic_id);
		//delete forum_user_poll_answers
		$this->forum_model->delete_user_poll_answers_by_topic_id($topic_id);
		echo 'success';
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
		echo modules::run('forum/load_conversation');	
	}
	/**
	*	@name: reload_supports
	*	@desc: This function reloads support tickets. Mostly after a new support ticket has been lodged etc.
	*	@access: public
	*	@param: (null)
	*	@return: returns most recent support tickets
	*/
	function reload_supports()
	{
		echo modules::run('forum/load_support_tickets');	
	}
	/**
	*	@name: post_reply
	*	@desc: This functions posts reply to a conversation topic
	*	@access: public
	*	@param: (via post [int] topic id, [text] reply)
	*	@return: returns 10 most recent conversation
	*/
	function post_reply()
	{
		$reply = $this->input->post('reply',true);
		$topic_id = $this->input->post('topic_id',true);
		$user_info = $this->session->userdata('user_data');
		$ajax_echo['replies'] = '';
		$ajax_echo['total_replies'] = 0;
		
		if($reply && $topic_id && $user_info){
			$data = array(
							'topic_id' => $topic_id,
							'message' => $reply,
							'posted_by' => $user_info['user_id']
						);	
			if($this->forum_model->add_reply($data)){
				$ajax_echo['total_replies'] = $this->forum_model->get_replies($topic_id,true);
				$ajax_echo['replies'] = modules::run('forum/load_replies',$topic_id);
				return json_encode($ajax_echo);
			}
		}
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
		$conversation_type = 'conversation';
		if($this->input->post('conversation_type',true)){
			$conversation_type = $this->input->post('conversation_type',true);
		}
		$update_id = $this->input->post('update_id',true);
		
		$user_info = $this->session->userdata('user_data');
		$topic_id = 0;
		
		if($update_id){
			//update data
			$data = array(
						'title' => $title,
						'message' => $message,
						'group_id' => $group_id
						);
			$this->forum_model->update_topic($update_id,$data);
			$topic_id = $update_id;
		}else{
			//insert data
			$data = array(
						'title' => $title,
						'message' => $message,
						'group_id' => $group_id,
						'type' => $conversation_type,
						'created_by' => $user_info['user_id']
						);
			$insert_id = $this->forum_model->add_topic($data);
			$topic_id = $insert_id;
		}	
		  //if a file has been uploaded
		  //this ignores previous files that has been uploaded as the system is cleaned every six month
		  if($_FILES['userfile']['name']){
			  //create main folders if not exist
			  $main_sub_folders = array('img','docs');
			  modules::run('upload/create_upload_folders',UPLOADS_PATH.'/conversation/',$main_sub_folders);
			  $path = $_FILES['userfile']['name'];
			  $ext = pathinfo($path, PATHINFO_EXTENSION);
			  $img_ext_chk = array('jpg','png','gif','jpeg');
			  $doc_ext_chk = array('pdf','doc','docx','csv');
			  
			  $main_path = UPLOADS_PATH.'/conversation/';
			  $this->load->library('upload');
			  
			  if (in_array($ext,$img_ext_chk)){
				  //image
				  $subfolders = array('thumb');
				  $salt = 'forum'.$topic_id;
				  //create folders
				  $folder_name = modules::run('upload/create_folders',UPLOADS_PATH.'/conversation/img',$salt,$subfolders);
				  $file_path = $main_path.'img/';
				  $config['upload_path'] = $file_path.$folder_name;
				  $config['allowed_types'] = 'gif|jpg|png|jpeg';
				  $config['max_width']  = '2000';
				  $config['max_height']  = '2000';
				  $document_type = 'image';
					  
			  }elseif (in_array($ext,$doc_ext_chk)){
				  //documents
				  $salt = 'forum'.$topic_id;
				  //create folders
				  $folder_name = modules::run('upload/create_folders',UPLOADS_PATH.'/conversation/docs',$salt);
				  $file_path = $main_path.'docs/';
				  $config['upload_path'] = $file_path.$folder_name;
				  $config['allowed_types'] = 'pdf|doc|docx|csv';
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
				  $this->forum_model->update_topic($topic_id,$file_data);
				  //create thumbnail if file type is image
				  if (in_array($ext,$img_ext_chk)){
					  $thumb_path = $main_path.'img/'.$folder_name;
					   modules::run('upload/resize_photo',$file_name,$thumb_path,"thumb",450,338);
				  }
			  }
		  }
		  
		  if($send_by_email){
			  //send email to staff	
			  modules::run('forum/send_conversation_notification',$topic_id);
		  }
		
		echo 'success';
	}
	/**
	*	@name: create_poll
	*	@desc: Adds new poll
	*	@access: public
	*	@param: (via post) question, poll answers
	*	@return: status of the initiation process i.e. successful or not.
	*/
	function create_poll()
	{
		$poll_question = $this->input->post('poll_question',true);
		$poll_answers = $this->input->post('poll_answers',true);
		$group_id = $this->input->post('conversation_groups',true);
		$send_by_email = $this->input->post('send_by_email',true);
		
		$user_info = $this->session->userdata('user_data');

		//insert data
		$data = array(
					'title' => $poll_question,
					'message' => json_encode($poll_answers),
					'group_id' => $group_id,
					'type' => 'poll',
					'created_by' => $user_info['user_id']
					);
		$insert_id = $this->forum_model->add_topic($data);
		//add poll answers
		if($poll_answers)
		foreach($poll_answers as $pa){
			if($pa){
				$poll_data = array(
									'topic_id' => $insert_id,
									'answer' => $pa
								);
				$this->forum_model->add_poll_answers($poll_data);
			}
		}

		  
		if($send_by_email){
			//send email to staff	
			modules::run('forum/send_conversation_notification',$insert_id);
		}
		
		echo 'success';
	}
	
	
	
}