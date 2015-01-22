<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_setup extends MX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	
	function create_database()
	{
		$subdomain = $this->input->post('subdomain');
		$database = USER_PREFIX_DB . $subdomain;
		# In order to initialize the Forge & Dbutil classes, database driver must already be running, since the forge & dbutil classes relies on it.
		$this->load->model('account_model');
		
		# Check if database exist
		$this->load->dbutil();
		if (!$this->dbutil->database_exists($database))
		{
			$this->load->dbforge();
			$this->dbforge->create_database($database);
		}
		$data['subdomain'] = $subdomain;
		$this->load->view('setup/create_database', isset($data) ? $data : NULL);
	}
	
	function create_tables()
	{
		$subdomain = $this->input->post('subdomain');
		$this->load->model('account/setup_model');
		$this->setup_model->create_tables($subdomain);
		$data['subdomain'] = $subdomain;
		$this->load->view('setup/create_tables', isset($data) ? $data : NULL);
	}
	
	function create_directories()
	{
		$subdomain = $this->input->post('subdomain');
		$this->create_upload_folders("./" . USER_ASSETS_PATH . "/$subdomain", array('exports','uploads'));
		$this->create_upload_folders("./" . USER_ASSETS_PATH . "/$subdomain/exports", 
				array('error','expense','invoice','payrun','staff','client'));
		$this->create_upload_folders("./" . USER_ASSETS_PATH . "/$subdomain/uploads", 
				array('brief','company','conversation','import','pdf','staff'));
		$data['subdomain'] = $subdomain;
		$this->load->view('setup/create_directories', isset($data) ? $data : NULL);
	}
	
	function create_account()
	{
		$subdomain = $this->input->post('subdomain');
		$this->load->model('account_model');
		$account = $this->account_model->get_account(array('subdomain' => $subdomain));
		$this->load->model('account/setup_model');
		$user_id = $this->setup_model->create_account($account);
		$url = str_replace('//', '//' . $subdomain . '.' , base_url());
		$url = str_replace('www.', '', $url);
		$data['url'] = $url;
		$data['account'] = $account;
		$this->load->view('setup/create_account', isset($data) ? $data : NULL);
	}
	
	function send_welcome_email()
	{
		$account = unserialize($this->input->post('account'));
		$url = str_replace('//', '//' . $account['subdomain'] . '.' , base_url());
		$url = str_replace('www.', '', $url);
		$data['url'] = $url;
		$data['email'] = $account['email_address'];
		
		# if the new fields first name, last name and phone exist set them and pass them to welcome email
		if($account['first_name'] && $account['last_name'] && $account['phone'] && $account['package']){
			$data['first_name'] = $account['first_name'];
			$data['last_name'] = $account['last_name'];
			$data['phone'] = $account['phone'];
			$data['package'] = $account['package'];	
		}
		
		$message = $this->load->view('email/welcome', $data, true);
		modules::run('email/send_email', array(
			'to' => $account['email_address'], #'nam@propagate.com.au',
			'cc' => 'sales@staffbooks.com',
			'from' => 'team@staffbooks.com',
			'from_text' => 'StaffBooks',
			'subject' => 'Welcome to StaffBooks',
			'message' => $message
		));
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