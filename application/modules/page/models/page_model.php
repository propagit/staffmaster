<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	
	function get_pages()
	{
		$query = $this->db->get('pages');
		return $query->result_array();
	}
	function update_page($page_id, $data)
	{
		$data['lastupdatedon'] = date('Y-m-d H:i:s', time());
		$this->db->where('page_id', $page_id);
		return $this->db->update('pages', $data);
	}
	
	function get_page($page_id)
	{
		$this->db->where('page_id', $page_id);
		$query = $this->db->get('pages');
		return $query->first_row('array');
	}
	function get_page_by_name($page_name)
	{
		$this->db->where('name', $page_name);
		$query = $this->db->get('pages');
		return $query->first_row('array');
	}
}