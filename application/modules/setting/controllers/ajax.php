<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('setting_model');
	}
	
	/**
	*	@name: update_company
	*	@desc: abstract function to call element of company profile
	*	@access: public
	*	@param: (string) $tab
	*	@return: (view) of different update form depends on selected tab
	*/
	function update_company($tab)
	{
		$data['company'] = $this->setting_model->get_profile();				
		$this->load->view('edit_' . $tab, isset($data) ? $data : NULL);
	}
	/**
	*	@name: update_company_profile
	*	@desc: abstract function to update company profile. When no company profile data, it will create otherwise it will update the data 
	*	@access: public
	*	@param: POST
	*	
	*/
	function update_company_profile()
	{
		$data = $this->input->post();
		$company_data = array(
			'company_name' => $data['company_name'],
			'address' => $data['address'],
			'suburb' => $data['suburb'],
			'postcode' => $data['postcode'],
			'state' => $data['state'],
			'country' => $data['country'],			
			'email' => $data['email'],			
			'telephone' => $data['telephone'],
			'fax' => $data['fax'],
			'website_account' => $data['website_account'],
			'abn_acn' => $data['abn_acn'],
			'bank_account_name' => $data['bank_account_name'],
			'bank_account_no' => $data['bank_account_no'],
			'bank_bsb' => $data['bank_bsb'],
			'super_fund_name' => $data['super_fund_name'],
			'super_product_id' => $data['super_product_id'],
			'super_fund_phone' => $data['super_fund_phone'],
			'super_fund_website' => $data['super_fund_website'],
			'email_c_name' => $data['company_name'],
			'email_c_address' => $data['address'],
			'email_c_suburb' => $data['suburb'],
			'email_c_postcode' => $data['postcode'],
			'email_c_state' => $data['state'],
			'email_c_country' => $data['country'],			
			'email_c_email' => $data['email'],			
			'email_c_telephone' => $data['telephone'],
			'email_c_fax' => $data['fax'],
			'email_c_website' => $data['website_account'],
		);
		if($data['company_id']==0){			
			$this->setting_model->create_company_profile($company_data);		
		}
		else
		{
			$this->setting_model->update_profile($data['company_id'], $company_data);		
		}
	}
	
	/**
	*	@name: update_company_signature
	*	@desc: abstract function to update company profile. When no company profile data, it will create otherwise it will update the data 
	*	@access: public
	*	@param: POST
	*	
	*/
	function update_company_signature()
	{
		$data = $this->input->post();
		$company_data = array(			
			'email_c_name' => $data['email_c_name'],
			'email_c_address' => $data['email_c_address'],
			'email_c_suburb' => $data['email_c_suburb'],
			'email_c_postcode' => $data['email_c_postcode'],
			'email_c_state' => $data['email_c_state'],
			'email_c_country' => $data['email_c_country'],			
			'email_c_email' => $data['email_c_email'],			
			'email_c_telephone' => $data['email_c_telephone'],
			'email_c_fax' => $data['email_c_fax'],
			'email_c_website' => $data['email_c_website'],
			'email_s_facebook' => $data['email_s_facebook'],
			'email_s_twitter' => $data['email_s_twitter'],
			'email_s_linkedin' => $data['email_s_linkedin'],
			'email_s_google' => $data['email_s_google'],
			'email_s_youtube' => $data['email_s_youtube'],
			'email_s_instagram' => $data['email_s_instagram'],			
		);
		if($data['company_id']==0){			
			$this->setting_model->create_company_profile($company_data);		
		}
		else
		{
			$this->setting_model->update_profile($data['company_id'], $company_data);		
		}
	}
	function upload_logo()
	{
		$stat=1;
		$company_id = $this->input->post('company_id');
		if($company_id==0){$stat = 0;$company_id = 1;}
		$path = "./uploads/company";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$path = "./uploads/company/logo";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$path = "./uploads/company/logo";
		$newfolder = md5($company_id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}				
		$dirs=$dir.'/thumbnail';
		if(!is_dir($dirs))
		{
		  mkdir($dirs);
		  chmod($dirs,0777);
		  $fp = fopen($dirs.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$dirs_thumb2 = $dir.'/thumbnail2';
		if(!is_dir($dirs_thumb2))
		{
		  mkdir($dirs_thumb2);
		  chmod($dirs_thumb2,0777);
		  $fp = fopen($dirs_thumb2.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
	
		$this->load->library('upload', $config);
		if($stat==0){$company_id=0;}
		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());			
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			$photo = array(				
				'company_logo' => $file_name,
				'modified' => date('Y-m-d H:i:s'),				
			);
			if($company_id==0){			
				$this->setting_model->create_company_profile($photo);		
			}
			else
			{
				$this->setting_model->update_profile($company_id, $photo);		
			}
			
			
			
			copy($dir.'/'.$file_name, $dirs."/".$file_name);
			$target = $dirs."/".$file_name;
			$this->imageResizer($target,$target,150,150);	
			
			$thumb2_width = 216;
			$thumb2_height = 216;
			copy($dir.'/'.$file_name, $dirs_thumb2."/".$file_name);
			$target_thumb2 = $dirs_thumb2."/".$file_name;
			$this->scale_image($target_thumb2,$target_thumb2,$thumb2_width,$thumb2_height);
		}
	}
	function imageResizer($image_u,$target, $width, $height) {

        //header('Content-type: image/jpeg');

        list($width_orig, $height_orig) = getimagesize($image_u);
		$myImage = imagecreatefromjpeg($image_u);
        $ratio_orig = $width_orig/$height_orig;

        if ($width/$height > $ratio_orig) {
          $width = $height*$ratio_orig;
        } else {
          $height = $width/$ratio_orig;
        }

        // This resamples the image
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($image_u);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // Output the image
        imagejpeg($image_p, $target, 100);

    }
	function scale_image($image,$target,$thumbnail_width,$thumbnail_height)
	{
	  if(!empty($image)) //the image to be uploaded is a JPG I already checked this
	  {		
		list($width_orig, $height_orig) = getimagesize($image);   
		$myImage = imagecreatefromjpeg($image);
		$ratio_orig = $width_orig/$height_orig;
		//echo $ratio_orig;
		if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
		   $new_height = $thumbnail_width/$ratio_orig;
		   $new_width = $thumbnail_width;
		} else {
		   $new_width = $thumbnail_height*$ratio_orig;
		   $new_height = $thumbnail_height;
		}
		
		$x_mid = $new_width/2;  //horizontal middle
		$y_mid = $new_height/2; //vertical middle
		
		$process = imagecreatetruecolor(round($new_width), round($new_height)); 
		
		imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
		
		imagedestroy($process);
		imagedestroy($myImage);
		imagejpeg($thumb,$target, 100);
	
	  }
	}	
	
	/**
	*	@name: load_picture
	*	@desc: show the company logo picture
	*	@access: public
	*	@param: (via POST) (int) company_id
	*	
	*/
	function load_picture($company_id)
	{
		$company_id = $this->input->post('company_id',true);
		$data['company'] = $this->setting_model->get_profile();				
		
		$this->load->view('setting/list_photo', isset($data) ? $data : NULL);
	}
	/**
	*	@name: delete_logo
	*	@desc: Delete the currently logo and will be replaced with the default logo staff master
	*	@access: public
	*	@param: (via POST) (int) company_id
	*	
	*/
	function delete_logo($company_id)
	{
		$company_id = $this->input->post('company_id');
		$photo = array(				
				'company_logo' => '',
				'modified' => date('Y-m-d H:i:s'),				
		);
		if($company_id!=0){	$this->setting_model->update_profile($company_id, $photo);}
	}
	
	function send_email()
	{
		/*$data['company'] = $this->setting_model->get_profile();		
		$message ='Test Message';
		//$message_footer = $this->load->view('setting/email_footer_template', isset($data) ? $data : NULL);
		//$message.=$message_footer;
		//$this->load->library('email');
		$config = Array(
 	      'protocol' => 'smtp',
		  'smtp_host' => 'ssl://smtp.googlemail.com',
		  'smtp_port' => 465,
		  'smtp_user' => 'propagate.au@gmail.com', // change it to yours
		  'smtp_pass' => 'morem0n3y', // change it to yours
		  'mailtype' => 'html',
		  'charset' => 'iso-8859-1',
		  'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$config['mailtype'] = 'html';
		$this->email->initialize($config);	
		$this->email->from('propagate.au@gmail.com');
		$this->email->to('rseptiane@gmail.com');
		
		$this->email->subject('Email Template');
		$this->email->message($message);
		if ($this->email->send()) {
        // This becomes triggered when sending
        echo("Mail Sent");
		}else{
			echo($this->email->print_debugger()); //Display errors if any
		}
		*/
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'propagate.au@gmail.com', // change it to yours
			'smtp_pass' => 'morem0n3y', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		
		$message = 'Test message';
		//$message ='Test Message';
		$message_footer = modules::run('setting/ajax/get_template_footer');
		$message=$message.$message_footer;
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com'); // change it to yours
		$this->email->to('rseptiane@gmail.com');// change it to yours
		$this->email->subject('Testing Email from localhost');
		$this->email->message($message);
		if($this->email->send())
		{
		echo 'Email sent.';
		}
		else
		{
			show_error($this->email->print_debugger());
		}
		
	}
	
	function get_template_footer($color='#fbfbfb')
	{
		$data['color'] = $color;
		$data['company'] = $this->setting_model->get_profile();
		$this->load->view('setting/email_footer_template', isset($data) ? $data : NULL);	
	}
	
}