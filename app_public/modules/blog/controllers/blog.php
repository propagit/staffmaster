<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Blog
 * @author: kaushtuvgurung@gmail.com
 */

class Blog extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('blog_model');
	}
	
	function index($method='', $param='')
	{
		switch($method)
		{
			case 'add':
				$this->add();
			break;
			
			case 'add_new_blog':
				$this->add_new_blog();
			break;
			
			case 'edit':
				$this->edit($param);
			break;
			
			case 'update_blog':
				$this->update_blog();
			break;
			
			case 'activate':
				$this->activate($param);
			break;
			
			case 'deactivate':
				$this->deactivate($param);
			break;
			
			case 'delete_blog':
				$this->delete($param);
			break;
			
			case 'update_records_per_page':
				$this->update_records_per_page();
			break;
			
			case 'test':
				$this->test();
			break;
			
			default:
				$this->list_all($method);
			break;
		}
	}
	
	function list_all($offset='')
	{
		$data['categories'] = $this->blog_model->get_all_categories();
		$data['records_per_page'] = $this->blog_model->get_records_per_page();		
		$this->load->view('main_view', isset($data) ? $data : NULL);
	}
	
	function add()
	{
		$this->load->view('add', isset($data) ? $data : NULL);	
	}
	
	function add_new_blog()
	{
	
		$title = $this->input->post('title',true);
		$id_title = $this->input->post('id_title',true);
		$date = $this->input->post('date',true);
		$gallery_id = $this->input->post('gallery_id',true);
		$preview_article = $this->input->post('preview_article',true);
		$complete_article = $this->input->post('complete_article',true);
		$testimonial = $this->input->post('testimonial',true);
		$article_categories = $this->input->post('article_categories',true);
		$meta_title = $this->input->post('meta_title',true);
		$meta_desc = $this->input->post('meta_desc',true);
		$meta_keywords = $this->input->post('meta_keywords',true);
		
		$data = array(
				'title' => $title,
				'study_date' => date('Y-m-d', strtotime($date)),
				'preview' => $preview_article,
				'content' => $complete_article,
				'testimonial' => $testimonial,
				'gallery' => $gallery_id,
				'meta_title' => $meta_title,
				'meta_description' => $meta_desc,
				'meta_keywords' => $meta_keywords
				); 
				
		$insert_id = $this->blog_model->add_blog($data);
		if($insert_id){
			//insert article categories
			if($article_categories){
				$this->blog_model->add_blog_categories($article_categories, $insert_id);
			}
			//check if permalink exists and make necessary changes
			if($this->blog_model->permalink_exists($id_title)){
				$id_title_temp = $id_title.'-'.$insert_id;
			}else{
				$id_title_temp = $id_title;	
			}
			
			$this->blog_model->update_blog($insert_id,array('id_title' => $id_title_temp));
			
			//create folder
			$folder_name = $this->blog_model->create_folders('./uploads/blog','case_std'.$insert_id,array('thumb','thumb2','doc'));
		}
		
		$this->load->library('upload');
		//if image file has been uploaded
		if ($_FILES['userfile_thumb']['name']){
		//image upload
		$config['upload_path'] = "./uploads/blog/".$folder_name;	
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '4000';
		$config['max_height']  = '4000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
		
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('userfile_thumb')) {
				//image upload filed abort file upload
				$data['upload_error'] = $this->upload->display_errors();
				$valid_upload = false;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$image_name = $data['upload_data']['file_name'];
				# Create thumbnails thumb
				$path = "./uploads/blog/".$folder_name;
				$this->blog_model->create_thumbs($image_name,$path);

				//update image name
				$data = array(
						'image' => $image_name,
						);
				$this->blog_model->update_blog($insert_id,$data);											
			}
		}
		
		//if document has been uploaded
		if ($_FILES['userfile_download']['name']){
		//document upload
		$config_file['upload_path'] = "./uploads/blog/".$folder_name."/doc";	
		$config_file['allowed_types'] = 'pdf';
		$config_file['max_size']	= '4096'; // 4 MB
		$config_file['overwrite'] = FALSE;
		$config_file['remove_space'] = TRUE;
		$this->upload->initialize($config_file);
		//$this->load->library('upload', $config_file);
		if (!$this->upload->do_upload('userfile_download')) {
				//upload filed abort file upload
				$data['upload_error'] = $this->upload->display_errors();
				$valid_upload = false;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$doc_name = $data['upload_data']['file_name'];


				//update image name
				$data = array(
						'doc' => $doc_name,
						);
				$this->blog_model->update_blog($insert_id,$data);											
			}
		}
		redirect('blog/edit/'.$insert_id);
	}
	
	function edit($blog_id = '')
	{
		
		if(!$blog_id){
			redirect('blog');	
		}
		$data['blog'] = $this->blog_model->get_blog($blog_id);
		$this->load->view('add', isset($data) ? $data : NULL);	
	}
	
	function update_blog()
	{
	
		$title = $this->input->post('title',true);
		$id_title = $this->input->post('id_title',true);
		$date = $this->input->post('date',true);
		$gallery_id = $this->input->post('gallery_id',true);
		$preview_article = $this->input->post('preview_article',true);
		$complete_article = $this->input->post('complete_article',true);
		$testimonial = $this->input->post('testimonial',true);
		$article_categories = $this->input->post('article_categories',true);
		$meta_title = $this->input->post('meta_title',true);
		$meta_desc = $this->input->post('meta_desc',true);
		$meta_keywords = $this->input->post('meta_keywords',true);
		$update_id = $this->input->post('update_id',true);
		
		
		
		$data = array(
				'title' => $title,
				'study_date' => date('Y-m-d', strtotime($date)),
				'preview' => $preview_article,
				'content' => $complete_article,
				'testimonial' => $testimonial,
				'gallery' => $gallery_id,
				'meta_title' => $meta_title,
				'meta_description' => $meta_desc,
				'meta_keywords' => $meta_keywords
				); 
				
		$this->blog_model->update_blog($update_id,$data);

		
		//delete previous categories and update with new ones
		$this->blog_model->delete_blog_category_relation($update_id);
		//insert article categories
		if($article_categories){
			//delete previous categories and update with new ones
			if($this->blog_model->delete_blog_category_relation($update_id)){
				$this->blog_model->add_blog_categories($article_categories, $update_id);
			}
		}
		
		//to leave id title variable intact in case it is used in the future
		$id_title_temp = $id_title;
		
		//check if permalink exists and make necessary changes
		while($this->blog_model->permalink_exists($id_title_temp,$update_id)){
			$id_title_temp = $id_title_temp.'-'.$update_id;
		}
		
		$this->blog_model->update_blog($update_id,array('id_title' => $id_title_temp));
		$folder_name = md5('case_std'.$update_id);	
	
		
		$this->load->library('upload');
		//if image file has been uploaded
		if ($_FILES['userfile_thumb']['name']){
			
			//delete current image
			if($this->blog_model->delete_image_by_id($update_id)){	
					
			//image upload
			$config['upload_path'] = "./uploads/blog/".$folder_name;	
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '4096'; // 4 MB
			$config['max_width']  = '4000';
			$config['max_height']  = '4000';
			$config['overwrite'] = FALSE;
			$config['remove_space'] = TRUE;
			
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('userfile_thumb')) {
					//image upload filed abort file upload
					$data['upload_error'] = $this->upload->display_errors();
					$valid_upload = false;
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$image_name = $data['upload_data']['file_name'];
					# Create thumbnails thumb
					$path = "./uploads/blog/".$folder_name;
					$this->blog_model->create_thumbs($image_name,$path);
	
					//update image name
					$data = array(
							'image' => $image_name,
							);
					$this->blog_model->update_blog($update_id,$data);											
				}
			}
		}
		
		//if document has been uploaded
		if ($_FILES['userfile_download']['name']){
			
			//delete current document
			if($this->blog_model->delete_document_by_id($update_id)){	
			//document upload
			$config_file['upload_path'] = "./uploads/blog/".$folder_name."/doc";	
			$config_file['allowed_types'] = 'pdf';
			$config_file['max_size']	= '4096'; // 4 MB
			$config_file['overwrite'] = FALSE;
			$config_file['remove_space'] = TRUE;
			$this->upload->initialize($config_file);
			//$this->load->library('upload', $config_file);
			if (!$this->upload->do_upload('userfile_download')) {
					//upload filed abort file upload
					$data['upload_error'] = $this->upload->display_errors();
					$valid_upload = false;
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					$doc_name = $data['upload_data']['file_name'];
	
	
					//update image name
					$data = array(
							'doc' => $doc_name,
							);
					$this->blog_model->update_blog($update_id,$data);											
				}
			}
		}
		redirect('blog/edit/'.$update_id);
	}
	
	function activate($blog_id)
	{
		if($blog_id){
			$this->blog_model->update_blog($blog_id,array('status' => 'active'));	
		}
		redirect('blog');
	}
	
	function deactivate($blog_id)
	{
		if($blog_id){
			$this->blog_model->update_blog($blog_id,array('status' => 'inactive'));	
		}
		redirect('blog');
	}
	
	function delete($blog_id)
	{
		if($blog_id){
			$this->blog_model->delete_blog($blog_id);	
		}
		redirect('blog');
	}
	
	function update_records_per_page()
	{
		$backend = $this->input->post('records_per_page_backend',true);	
		$frontend = $this->input->post('records_per_page_frontend',true);
		$id = $this->input->post('records_per_page_id',true);
		$data = array(
					'backend' => $backend,
					'frontend' => $frontend
					);
		$this->blog_model->update_records_per_page($id,$data);
		redirect('blog');
	}
	
	function test()
	{
		echo md5('case_std1');
		exit;	
	}
	

}