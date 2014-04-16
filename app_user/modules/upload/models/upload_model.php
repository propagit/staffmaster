<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_model extends CI_Model {
	
	function insert_upload($data)
	{
		$this->db->insert('uploads', $data);
		return $this->db->insert_id();
	}
	
	function get_upload($upload_id)
	{
		$this->db->where('upload_id', $upload_id);
		$query = $this->db->get('uploads');
		return $query->first_row('array');
	}
}