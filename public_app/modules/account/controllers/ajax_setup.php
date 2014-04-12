<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_setup extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function create_database()
	{
		$username = $this->input->post('username');
		$database = 'sm_' . $username;
		# In order to initialize the Forge & Dbutil classes, database driver must already be running, since the forge & dbutil classes relies on it.
		$this->load->model('account_model');
		
		# Check if database exist
		$this->load->dbutil();
		if (!$this->dbutil->database_exists($database))
		{
			$this->load->dbforge();
			$this->dbforge->create_database($database);
		}
		$data['username'] = $username;
		$this->load->view('setup/create_database', isset($data) ? $data : NULL);
	}
	
	function create_tables()
	{
		$username = $this->input->post('username');
		$this->load->model('account/setup_model');
		$this->setup_model->create_tables($username);
		$data['username'] = $username;
		$this->load->view('setup/create_tables', isset($data) ? $data : NULL);
	}
	
	function create_directories()
	{
		$username = $this->input->post('username');
		$this->create_upload_folders("./public_html/$username", array('exports','uploads'));
		$this->create_upload_folders("./public_html/$username/exports", 
				array('error','expense','invoice','payrun','staff'));
		$this->create_upload_folders("./public_html/$username/uploads", 
				array('brief','company','conversation','import','pdf','staff'));
		$data['username'] = $username;
		$this->load->view('setup/create_directories', isset($data) ? $data : NULL);
	}
	
	function create_account()
	{
		$username = $this->input->post('username');
		$this->load->model('account_model');
		$account = $this->account_model->get_account(array('username' => $username));
		$this->load->model('account/setup_model');
		$user_id = $this->setup_model->create_account($account);
		$data['url'] = str_replace('//', '//' . $username . '.' , base_url());
		$this->load->view('setup/create_account', isset($data) ? $data : NULL);
	}
	
	function create_upload_folders($path, $subfolders = null)
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
}