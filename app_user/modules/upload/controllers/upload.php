<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*	@module: upload
*	@controller: upload
*/

class Upload extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('upload/upload_model');
	}
	
	/**
	*	@name: do_upload
	*	@desc: function to upload a file and store file information to database
	*	@access: public
	*	@param: (array) $config
	*	@return: (json) {ok: false, msg: string} or {ok: true, upload_id: int}
	*/
	function do_upload($config) 
	{
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload())
		{
			$msg = $this->upload->display_errors('','');
			return json_encode(array(
				'ok' => false,
				'msg' => $msg
			));
		}
		else
		{
			$data = $this->upload->data();
			$upload_id = $this->upload_model->insert_upload($data);
			return json_encode(array(
				'ok' => true,
				'upload_id' => $upload_id
			));
		}
	}
	
	function update_upload($upload_id, $data)
	{
		return $this->upload_model->update_upload($upload_id, array('data' => $data));
	}
	
	/**
	*	@name: get_upload
	*	@desc: function to get file information from database
	*	@access: public
	*	@param: (int) $upload_id
	*	@return: (array) file data
	*/
	function get_upload($upload_id)
	{
		return $this->upload_model->get_upload($upload_id);
	}
	
	/**
	*	@name: create_upload_folders
	*	@desc: Creates main folder for documents in the upload folders. This not the folder with md5 hash names. These folders have distinct meaning such as staff_picture etc.
	*	@access: public
	*	@param: (string) path of the folder, (array) array of subfolders if applicable
	*	@return: null
	*/
	function create_upload_folders($path,$subfolders = null)
	{	
		if($path){
			$dir = $path;
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			
			$sub_dir = '';
			if($subfolders){
				foreach($subfolders as $folder){
					$sub_dir = $dir.'/'.$folder;	
					if(!is_dir($sub_dir))
					{
					  mkdir($sub_dir);
					  chmod($sub_dir,0777);
					  $fp = fopen($sub_dir.'/index.html', 'w');
					  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
					  fclose($fp);
					}		
				}
			}
		}
		
	}
	
	/**
	*	@name: create_folders
	*	@desc: Creates folder for documents
	*	@access: public
	*	@param: (string) path of the folder, (string) salt, (array) array of subfolders if applicable
	*	@return: returns the folder name to the control that called this function
	*/
	function create_folders($path,$salt,$subfolders = null)
	{	
		//create staff specific folders
		if($path && $salt){
			$newfolder = md5($salt);
			$dir = $path."/".$newfolder;
			if(!is_dir($dir))
			{
			  mkdir($dir);
			  chmod($dir,0777);
			  $fp = fopen($dir.'/index.html', 'w');
			  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
			  fclose($fp);
			}
			
			$sub_dir = '';
			if($subfolders){
				foreach($subfolders as $folder){
					$sub_dir = $dir.'/'.$folder;	
					if(!is_dir($sub_dir))
					{
					  mkdir($sub_dir);
					  chmod($sub_dir,0777);
					  $fp = fopen($sub_dir.'/index.html', 'w');
					  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
					  fclose($fp);
					}		
				}
			}
			return $newfolder;
		}
		
	}
	
	/**
	*	@name: resize_photo
	*	@desc: Create thumbnails for images
	*	@access: public
	*	@param: (string) path of the folder, (string) salt, (array) array of subfolders if applicable
	*	@return: returns the folder name to the control that called this function
	*/
	function resize_photo($name,$directory,$sub,$width,$height,$maintain_ratio = TRUE) 
	{
		$image_size = getimagesize($directory.'/'.$name);
		if($image_size[0] < $width){
			$width = $image_size[0];	
		}
		$config = array();
		$config['source_image'] = $directory."/".$name;
		$config['create_thumb'] = FALSE;
		$config['new_image'] = $directory."/".$sub."/".$name;
		$config['maintain_ratio'] = $maintain_ratio;
		$config['quality'] = 100;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		$this->image_lib->resize();		
		$this->image_lib->clear();	
	}
	
	/**
	*	@name: delete_dir_and_contents
	*	@desc: Deletes the document contents,sub folders included and the directory iteself
	*	@access: public
	*	@param: (string) path of the folder
	*	@return: NULL
	*/
	function delete_dir_and_contents($path)
	{
		$this->load->helper("file"); // load the helper
		delete_files($path, true); // delete all files/folders
		rmdir($path);	
	}
	
}