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
	
	
	
}