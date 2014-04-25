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
			'term_and_conditions' => $data['term_and_conditions'],
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
			'email_background_colour' => $data['email_background_colour'],			
			'email_font_colour' => $data['email_font_colour'],
			'email_common_text' => $data['email_common_text']			
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
	*	@name: upload_logo
	*	@desc: Upload logo of the company. the image will be resized with ratio 150:150 stored on thumbnail folder. There is no thumbnail needed for upload logo 
	*	@access: public
	*	@param: (via POST) (int) company_id
	*	@updates: Resize image is now being called from upload modules, works for image type, jpeg,png and gif
	*	@updated_by: Kaushtuv
	*	
	*/
	function upload_logo()
	{
		
		$company_id = $this->input->post('company_id');
		
		if($company_id==0){$comp_id=1;}else{$comp_id=$company_id;}
		$path = UPLOADS_PATH."/company";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		
		$path = UPLOADS_PATH."/company/logo";
		$dir = $path;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}
		$path = UPLOADS_PATH."/company/logo";
		$newfolder = md5($comp_id);
		$dir = $path."/".$newfolder;
		if(!is_dir($dir))
		{
		  mkdir($dir);
		  chmod($dir,0777);
		  $fp = fopen($dir.'/index.html', 'w');
		  fwrite($fp, '<html><head>Permission Denied</head><body><h3>Permission denied</h3></body></html>');
		  fclose($fp);
		}		
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '4096'; // 4 MB
		$config['max_width']  = '2000';
		$config['max_height']  = '2000';
		$config['overwrite'] = FALSE;
		$config['remove_space'] = TRUE;
	
		$this->load->library('upload', $config);
		
				
		
		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error_addphoto',$this->upload->display_errors());			
		}	
		else
		{
			//prep data so that old image can be safely removed
			$old_company_logo_data = $this->setting_model->get_profile();
			
			$data = array('upload_data' => $this->upload->data());
			$file_name = $data['upload_data']['file_name'];
			$width = $data['upload_data']['image_width'];
			$height = $data['upload_data']['image_height'];
			$photo = array(				
				'company_logo' => $file_name,
				'modified' => date('Y-m-d H:i:s'),				
			);
			if($company_id==0){			
				$company_id = $this->setting_model->create_company_profile($photo);		
			}
			else
			{
				$this->setting_model->update_profile($company_id, $photo);		
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
			//copy($dir.'/'.$file_name, $dirs."/".$file_name);
			//$target = $dirs."/".$file_name;
			//$this->imageResizer($target,$target,260,100);	
			modules::run('upload/resize_photo',$file_name,$dir,'thumbnail',275,100,TRUE);
			//delete old logo
			modules::run('setting/delete_company_logo',$dir,$old_company_logo_data['company_logo']);
		}
	}
	/**
	*	@name: imageResizer
	*	@desc: Resize Image from uploaded logo. this will resize based on ratio parameter which is in this case 150:150
	*	@access: public
	*	@param: image, url target, width and height ratio image
	*	
	*/
	function imageResizer($image_u,$target, $width, $height) {        
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
	/**
	*	@name: get_template_footer
	*	@desc: Get Email Footer Template
	*	@access: public
	*	@param: (via POST) Background color and Font color
	*	
	*/
	function get_template_footer()
	{
		$company = $this->setting_model->get_profile();
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
		if($company){
			if($company['email_background_colour']){
				$color = $company['email_background_colour'];
			}
			if($company['email_font_colour']){
				$font_color = $company['email_font_colour'];
			}
		}
		if($_POST){
			$color = $this->input->post('color');
			$font_color = $this->input->post('font_color');
		}
		
		
		
		
		
		$data['color'] = $color;
		$data['font_color'] = $font_color;
		$data['company'] = $company;
		$this->load->view('setting/email_footer_template', isset($data) ? $data : NULL);	
	}
	/**
	*	@name: send_email_template
	*	@desc: Function to send email the templaete email
	*	@access: public
	*/
	function send_email_template()
	{
		
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
		
		$subject ="Email Template Company Profile";
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('propagate.au@gmail.com'); // change it to yours
		$this->email->to('raquel@propagate.com.au');// change it to yours
		$company_logo = modules::run('setting/company_logo');
		$email_signature = modules::run('setting/ajax/get_template_footer');
		$this->email->subject($subject);
		$this->email->message($company_logo . '<br />'.$message . $email_signature);
		
		if($this->email->send())
		{
		echo 'Email sent.';
		}
		else
		{
			show_error($this->email->print_debugger());
		}
		
	}
	
	function reload_header_logo()
	{
		echo modules::run('setting/company_logo');	
	}	
	
	
	/**
	*	@name: edit_system_styles
	*	@desc: Provides UI to change system colour
	*	@access: public
	*	@param: (null)
	*	@return: Loads UI to change system styles
	*/
	function edit_system_styles()
	{
		$data['styles'] = array(
							'primary_colour' => COLOUR_PRIM,
							'rollover_colour' => COLOUR_ROLL,
							'secondary_colour' => COLOUR_SECO,
							'text_colour' => TEXT_COLOUR
							);
		$current_styles = $this->setting_model->get_system_styles(1);
		if($current_styles){
			$data['styles'] = $current_styles;	
		}
		$this->load->view('system_settings/edit_system_styles', isset($data) ? $data : NULL);
	}
	
	/**
	*	@name: edit_information_sheet
	*	@desc: Provides UI to change information sheet configuration
	*	@access: public
	*	@param: (null)
	*	@return: Loads UI to change information sheet configuration
	*/
	function edit_information_sheet()
	{
		$data['info_sheet_configs'] = $this->setting_model->get_information_sheet_configuration();
		$this->load->view('system_settings/edit_information_sheet', isset($data) ? $data : NULL);
	}
	
	function update_information_sheet()
	{
		$information_sheet_id = $this->input->post('information_sheet_id');	
		$cur_status = $this->setting_model->get_information_sheet_configuration($information_sheet_id);
		$update_status = ($cur_status->element_active == 'yes') ? 'no' : 'yes';
		$data = array(
					'element_active' => $update_status,
					'modified' => date('Y-m-d H:i:s')
					);
		echo $this->setting_model->update_information_sheet_configuration($information_sheet_id,$data);
	}

	
	
}