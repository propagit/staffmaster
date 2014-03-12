<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Forum
 * @author: namnd86@gmail.com
 */

class Forum extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('forum_model');
		$this->load->model('attribute/group_model');
	}
	
	
	function index($method='', $param='') {
		switch($method)
		{
			default:
					$this->main_view();
				break;
		}
		
	}
	
	function main_view() {
		$this->load->view('manage_conversations', isset($data) ? $data : NULL);
	}
	/**
	*	@name: load_converation
	*	@desc: Loads the most recent conversations
	*	@access: public
	*	@param: (session) user info stored in the session variable when a user logs in
	*	@return: returns 10 most recent conversation
	*/
	function load_conversation()
	{
		$user = $this->session->userdata('user_data');
		$data['user'] = $user;
		$data['conversations'] = $this->forum_model->get_conversations($user);
		$this->load->view('conversations', isset($data) ? $data : NULL);
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
	
	
	
}