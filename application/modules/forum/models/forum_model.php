<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc This model is performs the database operation regarding the forum module (Conversation module) 
*	@class_comments 
*	
*
*/

class Forum_model extends CI_Model {
	/**
	*	@name: add_topic
	*	@desc: Performs Database operation - insert data to the table forum_topics
	*	@access: public
	*	@param: (array) array of forum topic data such as title, message etc
	*	@return: insert id
	*/
	function add_topic($data)
	{
		$this->db->insert('forum_topics',$data);
		return $this->db->insert_id();
	}
	/**
	*	@name: update_topic
	*	@desc: Update existing forum topic. Mostly used during the process of creating if the user has uploaded documents
	*	@access: public
	*	@param: ([int] topic id, [array] update data)
	*	@return: returns number of rows affected
	*/
	function update_topic($topic_id,$data)
	{
		$this->db->where('topic_id', $topic_id);
		return $this->db->update('forum_topics', $data);	
	}
	/**
	*	@name: get_conversations
	*	@desc: This performs database query to get the most recent conversation mostly 10. For admin dashboard the conversation will be loaded ignoring the groups.
	*	@access: public
	*	@param: ([obj] user)
	*	@return: list of most recent conversations
	*/
	function get_conversations($user,$params = array(),$total = false)
	{
		$records_per_page = 5;
		
		$sql = "SELECT ft.*,(select count(*) FROM forum_messages fm WHERE fm.topic_id = ft.topic_id) AS total_replies, u.first_name, u.last_name FROM forum_topics ft
				LEFT JOIN users u ON ft.created_by = u.user_id";
		//if user is not admin
		if(!$user['is_admin']){
			$staff_groups = modules::run('staff/get_staff_groups',$user['user_id']);
			if($staff_groups){
				$sql .= " WHERE (ft.group_id IN (".$staff_groups.") OR ft.group_id = 0)";
			}
		}
		$sql .= " GROUP BY ft.topic_id";
		if($params){
			$sort_param = json_decode($params);	
			if(isset($sort_param->sort_by)){ $sql .= " ORDER BY ".$sort_param->sort_by." ".$sort_param->sort_order;}				
			if(isset($sort_param->limit)){ 
				//if limit is not set it will default start the pagination
				$sql .= " LIMIT " . $sort_param->limit; 
			}else{
				if(!$total && isset($sort_param->current_page)){
					$sql .= " LIMIT ".(($sort_param->current_page-1)*$records_per_page)." ,".$records_per_page;
				}
			}
		}else{
			if(!$params){
				$sql .= " ORDER BY ft.created_on desc";	
			}
		}
		return $this->db->query($sql)->result();
	}
	/**
	*	@name: add_reply
	*	@desc: Performs Database operation - insert data to the table forum_messages, everytime someone replies to a conversation topic
	*	@access: public
	*	@param: (array) array of forum reply data such as reply, topic id, user id etc
	*	@return: insert id
	*/
	function add_reply($data)
	{
		$this->db->insert('forum_messages',$data);
		return $this->db->insert_id();
	}
	/**
	*	@name: get_replies
	*	@desc: This performs database query to get the most recent replices for a conversation topic.
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: list of most recent replies
	*/
	function get_replies($topic_id,$total = false)
	{
		$sql = "select * from forum_messages where topic_id = ".$topic_id;
		$sql .= " order by posted_on desc";
		if($total){
			$total = $this->db->query($sql)->result();
			return count($total);
		}else{
			//$sql .= ' limit 0,5';	
		}
		return $this->db->query($sql)->result();
	}
	
	/**
	*	@name: get_conversation_by_id
	*	@desc: This performs database query to get conversation by id
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: Information for a single conversation 
	*/
	function get_conversation_by_id($topic_id)
	{
		$conversation = $this->db->where('topic_id',$topic_id)->get('forum_topics')->row();
		return $conversation;	
	}
	
	/**
	*	@name: delete_conversation_topic
	*	@desc: Permanently removes a conversation topic from the system 
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: rows affected 
	*/
	function delete_conversation_topic($topic_id)
	{
		$this->db->where('topic_id', $topic_id);
		return $this->db->delete('forum_topics');
	}
	
	/**
	*	@name: delete_conversation_topic
	*	@desc: Permanently removes replies to a conversation topic from the system 
	*	@access: public
	*	@param: ([int] topic id)
	*	@return: rows affected 
	*/
	function delete_conversation_replies($topic_id)
	{
		$this->db->where('topic_id', $topic_id);
		return $this->db->delete('forum_messages');
	}
	
	
	
}