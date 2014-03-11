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
	function get_conversations($user)
	{
		
		
		$sql = "select * from forum_topics ";
		//if user is not admin
		if(!$user['is_admin']){
			$staff_groups = modules::run('staff/get_staff_groups',$user['user_id']);
			if($staff_groups){
				$sql .= " where (group_id in (".$staff_groups.") or group_id = 0)";
			}
		}
		$sql .= " order by created_on desc";
		return $this->db->query($sql)->result();
	}
	
	
	
	
	
}