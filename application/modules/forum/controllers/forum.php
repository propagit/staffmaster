<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MX_Controller {
	/**
	*	@class_desc Forum controller
	*	
	*
	*/
	function __construct()
	{
		parent::__construct();
		$this->load->model('forum_model');
		$this->load->model('attribute/group_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			case 'manage_conversation_replies':
				$this->manage_conversation_replies($param);
			break;	
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$this->load->view('manage_conversations', isset($data) ? $data : NULL);
	}
	/**
	*	@name: manage_conversation_replies
	*	@desc: Loads list of replies to the conversation for editing purpose by the admin.
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: Displays the list of replies to a conversation for admin to edit
	*	@action_permitted: Delete only
	*/
	function manage_conversation_replies($topic_id)
	{	
		$data['replies'] = $this->forum_model->get_replies($topic_id);
		$data['conversation'] = $this->forum_model->get_conversation_by_id($topic_id);
		$this->load->view('manage_conversation_replies', isset($data) ? $data : NULL);
	}
	/**
	*	@name: load_converation
	*	@desc: Loads the most recent conversations
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns most recent conversation
	*/
	function load_conversation()
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['conversations'] = $this->forum_model->get_conversations($user);
		$this->load->view('conversations', isset($data) ? $data : NULL);
	}
	/**
	*	@name: load_poll
	*	@desc: Loads a poll
	*	@access: public
	*	@param: ([int] topic_id) 
	*	@return: returns a poll
	*/
	function load_poll($topic_id)
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['topic_id'] = $topic_id;
		//if a user has already taken the poll show result
		if($this->forum_model->has_user_taken_poll($user['user_id'],$topic_id)){
			$data['total_answer_count'] = $this->forum_model->get_poll_answer_total_count($topic_id);
			$data['poll_results'] = $this->forum_model->get_poll_answers($topic_id);	
			$this->load->view('poll_result', isset($data) ? $data : NULL);
		}else{
		//if user has not taken the poll show the poll
			$data['poll_answers'] = $this->forum_model->get_poll_answers($topic_id);
			$this->load->view('poll', isset($data) ? $data : NULL);
		}
	}
	/**
	*	@name: load_support_tickets
	*	@desc: Loads the most recent support requests
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns most recent supports
	*/
	function load_support_tickets()
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['support_tickets'] = $this->forum_model->get_support($user);
		$this->load->view('support_tickets', isset($data) ? $data : NULL);
	}
	/**
	*	@name: get_reply_count
	*	@desc: Gets the number of reply a conversation has
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: returns the number of reply a conversation topic has
	*/
	function get_reply_count($topic_id)
	{
		return $this->forum_model->get_replies($topic_id,true);
	}
	/**
	*	@name: load_replies
	*	@desc: Loads the most replies for a conversation
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: returns 5 most recent replies
	*/
	function load_replies($topic_id)
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['replies'] = $this->forum_model->get_replies($topic_id);
		$this->load->view('replies', isset($data) ? $data : NULL);
	}
	/**
	*	@name: send_conversation_notification
	*	@desc: Sends email to staff notifying them of a conversation that has been posted
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: sends email
	*/
	
	function send_conversation_notification($topic_id)
	{
		if($topic_id){
			$conversation = $this->forum_model->get_conversation_by_id($topic_id);
			if($conversation){
				$group_id = $conversation->group_id;
				if(!$group_id){
					//group id is zero so send to all staff	
				}else{
					//get staff belonging to this group and send email to those staff	
				}
			}
		}
	}
	
	
}