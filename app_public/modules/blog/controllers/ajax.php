<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Blog
 * @author: propagate dev team
 */

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->model('blog_model');
	}
	
	function add_new_category()
	{
		$name = $this->input->post('name',true);
		$blog_id = $this->input->post('blog_id',true);
		if($name){
			$data = array(
						'name' => $name,
					);
			$insert_id = $this->blog_model->add_new_category($data);
			if($insert_id){
				echo $this->blog_model->create_category_list($blog_id,$insert_id);
			}else{
				echo 'failed';	
			}
		}else{
			echo 'failed';	
		}
	}
	
	function delete_blog_image()
	{
		$blog_id = $this->input->post('blog_id',true);
		if($this->blog_model->delete_image_by_id($blog_id)){
			echo 'success';
		}else{
			echo 'failed';	
		}
	}
	
	function delete_blog_doc()
	{
		$blog_id = $this->input->post('blog_id',true);
		if($this->blog_model->delete_document_by_id($blog_id)){
			echo 'success';
		}else{
			echo 'failed';	
		}
	}
	
	function delete_category()
	{
		$category_id = $this->input->post('category_id',true);
		$blog_id = $this->input->post('blog_id',true);
		if($category_id){
			if($this->blog_model->delete_category($category_id)){
				echo $this->blog_model->create_category_list($blog_id);
			}else{
				echo 'failed';	
			}
		}else{
			echo 'failed';	
		}
	}
	
	function permalink_exists()
	{
		$permalink = $this->input->post('permalink',true);
		if($this->blog_model->permalink_exists($permalink)){
			echo 'exists';	
		}else{
			echo 'donot_exists';	
		}
	}
	
	function search_blog()
	{
		$params = $this->input->post('params',true);
		
		$blogs = $this->blog_model->search_blog($params);
		
	}
	
}