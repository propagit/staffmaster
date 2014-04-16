<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@class_desc This model is performs the database operation regarding Support Module
*	@class_comments 
*	
*
*/

class Support_model extends CI_Model {
	
	/**
	*	@name: get_support
	*	@desc: This performs database query to get the most recent conversation (support in this case) mostly 10. For admin dashboard the support will be displayed in the conversation.
	*	@access: public
	*	@param: ([obj] user)
	*	@return: list of most recent supports
	*/
	function get_support($user)
	{
		$records_per_page = SUPPORT_PER_PAGE;
		
		$sql = "SELECT ft.*,
					(select count(*) FROM forum_messages fm WHERE fm.topic_id = ft.topic_id) AS total_replies, 
				u.first_name, u.last_name 
				FROM forum_topics ft
				LEFT JOIN users u ON ft.created_by = u.user_id 
				WHERE type = 'support' 
				GROUP BY ft.topic_id";
				
		$sql .= " ORDER BY ft.created_on DESC";	
		$sql .= " LIMIT ".$records_per_page;
		

		return $this->db->query($sql)->result();
	}
	
	
	
	
	
}