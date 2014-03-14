<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_template_model extends CI_Model {
	
	function update_template($email_template_id, $data)
	{
		$this->db->where('email_template_id', $email_template_id);
		return $this->db->update('email_templates', $data);
	}
	
	function get_template($email_template_id)
	{
		$template = $this->db->where('email_template_id',$email_template_id)->get('email_templates')->row();
		return $template;
	}
	
	function get_all_templates()
	{
		$templates = $this->db->get('email_templates')->result();
		return $templates;
	}
	
	function get_email_merge_fields_by_template_id($template_id)
	{
		$merge_fields = $this->db->where('email_template_id',$template_id)->get('email_merge_fields')->result();
		if($merge_fields){
			return $merge_fields;
		}
	}
	
	
}