<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {
	
	function get_brands()
	{
		$query = $this->db->get('brands');
		return $query->result_array();
	}
	
	function get_brands_by_category($category_id)
	{
		$sql = "SELECT DISTINCT b.* FROM brands b, products p 
				WHERE p.category_id = '" . $category_id . "'
				AND p.brand_id = b.reference_id ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_brand($brand_id)
	{
		$this->db->where('reference_id', $brand_id);
		$query = $this->db->get('brands');
		return $query->first_row('array');
	}
	
	function get_categories()
	{
		$query = $this->db->get('categories');
		return $query->result_array();
	}
	
	function get_category($category_id)
	{
		$this->db->where('reference_id', $category_id);
		$query = $this->db->get('categories');
		return $query->first_row('array');
	}
	
	function insert_category($data)
	{
		$this->db->insert('categories', $data);
		return $this->db->insert_id();
	}
	
	function insert_brand($data)
	{
		$this->db->insert('brands', $data);
		return $this->db->insert_id();
	}
	
	function get_total_products($keywords = '')
	{
		if ($keywords != '')
		{
			$this->db->like('title', $keywords);
			$this->db->or_like('description', $keywords);
		}
		$query = $this->db->get('products');
		return $query->num_rows();
	}
	
	function get_product($product_id)
	{
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('products');
		return $query->first_row('array');
	}
	
	function get_similar_products($product_id, $category_id)
	{
		$sql = "SELECT * FROM products 
				WHERE product_id != '" . $product_id . "'
				AND category_id = '" . $category_id . "'
				ORDER BY part_no ASC LIMIT 4";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function search_products($category_id, $brand_id, $keywords, $per_page = NULL, $offset = NULL)
	{
		if($category_id)
		{
			$this->db->where('category_id', $category_id);
		}
		if ($brand_id)
		{
			$this->db->where('brand_id', $brand_id);
		}
		if ($keywords)
		{
			$this->db->like('title', $keywords);
			$this->db->or_like('description', $keywords);
			$this->db->or_like('part_no', $keywords);
			$this->db->or_like('alternate_part', $keywords);
		}
		$offset = ($offset) ? $offset : 0;
		if ($per_page != NULL)
		{
			$this->db->limit($per_page, $offset);
		}
		$query = $this->db->get('products');
		return $query->result_array();
	}
	
	function get_products($per_page = NULL, $offset = NULL, $keywords = '')
	{
		$offset = ($offset) ? $offset : 0;
		$sql = "SELECT p.*, b.name as brand_name, c.title as category_title FROM
			products p
			LEFT JOIN brands b ON p.brand_id = b.reference_id
			LEFT JOIN categories c ON p.category_id = c.reference_id";
		if ($keywords != '')
		{
			$sql .= " WHERE (p.title LIKE '%" . $keywords . "%' OR p.description LIKE '%" . $keywords . "%' OR p.part_no LIKE '%" . $keywords . "%')";
		}
		if ($per_page != NULL)
		{
			$sql .= " LIMIT " . $offset . ", " . $per_page;
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function prepare_product_data($data)
	{
		if (isset($data['visible']))
		{
			$data['visible'] = ($data['visible']) ? 1 : 0;
		}		
		return $data;	
	}
	
	function insert_product($data)
	{
		$data = $this->prepare_product_data($data);
		$this->db->insert('products', $data);
		return $this->db->insert_id();
	}
	
	function update_product($product_id, $data)
	{
		$data = $this->prepare_product_data($data);
		$this->db->where('product_id', $product_id);
		return $this->db->update('products', $data);
	}
	
	function get_product_stock($part_no, $company_name)
	{
		$this->db->where('product_part_no', $part_no);
		$this->db->where('distributor_company_name', $company_name);
		$this->db->where('customer_name', NULL);
		$this->db->where('sale_date', NULL);
		$query = $this->db->get('orders');
		return $query->num_rows();
	}
}