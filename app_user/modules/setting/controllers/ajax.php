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
			'accept_cc' => 0,
			'accept_cc_msg' => $data['accept_cc_msg'],
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
		if (isset($data['accept_cc'])) {
			$company_data['accept_cc'] = 1;
		}
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
	
	function edit_others()
	{
		$this->load->view('system_settings/edit_others', isset($data) ? $data : NULL);
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
	
	function accounting_platform()
	{
		$accounting_platform = $this->input->post('accounting_platform');
		$this->config_model->add(array(
			'key' => 'accounting_platform',
			'value' => $accounting_platform
		));
		if ($accounting_platform != '')
		{
			$this->load->view('integration/' . $accounting_platform);
		}
	}
		
	function check_shoebooks_staff()
	{
		# Get all employee from Shoebooks
		$employee = modules::run('api/shoebooks/search_employee');
		$e_ids = array();
		foreach($employee as $e)
		{
			$e_ids[] = $e['DataID'];
		}
		
		# Get all staff from StaffBooks
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();
		$s_ids = array();
		foreach($staff as $s)
		{
			$s_ids[] = $s['external_staff_id'];
		}
		
		$synced = array_intersect($e_ids, $s_ids);
		$warnings = array();
		foreach($synced as $external_id)
		{
			$s = modules::run('staff/get_staff_by_external_id', $external_id);
			$e = modules::run('api/shoebooks/read_employee', $external_id);
			if (strtolower($s['first_name'] . ' ' . $s['last_name']) != strtolower($e['FirstName'] . ' ' . $e['LastName']))
			{
				$warnings[] = $external_id;
			}
		}
		
		$data['type'] = 'staff';
		$data['platform'] = 'Shoebooks';
		$data['total_staffbooks'] = count($staff);
		$data['total_shoebooks'] = count($employee);
		$data['synced'] = count($synced);
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results', isset($data) ? $data : NULL);
	}
	
	function download_not_synced_staff_shoebooks()
	{
		$employee = modules::run('api/shoebooks/search_employee');
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Shoebooks Employee Report");
		$objPHPExcel->getProperties()->setSubject("Shoebooks Employee Report");
		$objPHPExcel->getProperties()->setDescription("Check Shoebooks Employee for Sync to StaffBooks Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Data ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
		
		$i = 0;
		foreach($employee as $e)
		{
			if (!modules::run('staff/get_staff_by_external_id', $e['DataID']))
			{
				$emp = modules::run('api/shoebooks/read_employee', $e['DataID']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $e['DataID']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $emp['FirstName']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $emp['LastName']);
				$i++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_staff_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function download_not_synced_staff_shoebooks_staffbooks()
	{
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("StaffBooks Staff Report");
		$objPHPExcel->getProperties()->setSubject("StaffBooks Staff Report");
		$objPHPExcel->getProperties()->setDescription("Check Staff for Sync to Shoebooks Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email Address');
		
		$i = 0;
		foreach($staff as $s)
		{
			if (!modules::run('api/shoebooks/read_employee', $s['external_staff_id']))
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $s['external_staff_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $s['last_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $s['email_address']);
				$i++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_staff_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function download_shoebooks_staff_report()
	{
		$ids = unserialize($this->input->post('ids'));
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Shoebooks Staff Report");
		$objPHPExcel->getProperties()->setSubject("Shoebooks Staff Report");
		$objPHPExcel->getProperties()->setDescription("Check Staff for Sync to Shoebooks Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'StaffBooks Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Shoebooks Name');
		
		for($i=0; $i<count($ids); $i++)
		{
			$s = modules::run('staff/get_staff_by_external_id', $ids[$i]);
			$e = modules::run('api/shoebooks/read_employee', $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name'] . ' ' . $s['last_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $e['FirstName'] . ' ' . $e['LastName']);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_staff_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function sync_shoebooks_staff()
	{
		$imported = 0;
		$exported = 0;
		$updated = 0;
		$errors = 0;
		
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');
		
		# First get all employee from Shoebooks
		$employee = modules::run('api/shoebooks/search_employee');
		$e_ids = array();
		
		# Get all staff from StaffBooks
		$staffs = $this->staff_model->search_staffs();
		
		# Check if any employee is already in StaffBooks, otherwise add to StaffBooks
		foreach($employee as $e)
		{
			$staff = modules::run('staff/get_staff_by_external_id', $e['DataID']);
			if ($staff)
			{
				$e_ids[] = $e['DataID'];
			}
			else
			{
				$input = modules::run('api/shoebooks/read_employee', $e['DataID']);
				$user_data = array(
					'status' => 1,
					'is_admin' => 0,
					'is_staff' => 1,
					'is_client' => 0,
					'email_address' => '',
					'username' => '',
					'password' => '',
					'title' => $input['Title'],
					'first_name' => $input['FirstName'],
					'last_name' => $input['LastName'],
					'address' => $input['Address'],
					'suburb' => $input['County'],
					'city' => $input['City'],
					'state' => $input['State'],
					'postcode' => $input['Zip'],
					'country' => $input['Country']			
				);
				$user_id = $this->user_model->insert_user($user_data);
				if ($user_id)
				{
					$staff_data = array(
						'user_id' => $user_id,
						'external_staff_id' => $e['DataID'],
						'gender' => $input['Gender'],
						'dob' => date('Y-m-d', strtotime($input['BirthDate'])),
						'emergency_contact' => $input['EmergencyContact'],
						'emergency_phone' => $input['EmergencyPhone'],
						'f_tfn' => $input['SocialSecurity'],
						'f_acc_name'=> $input['BankName'],
						'f_bsb' => $input['BankNumber'],
						'f_acc_number' => $input['BankAccount']
					);					
					$staff_id = $this->staff_model->insert_staff($staff_data, true);
					if ($staff_id)
					{
						$imported++;
					}
				}				
			}			
		}
		
		# Now transfer from Staffbooks to Shoebooks		
		foreach($staffs as $staff)
		{
			if (in_array($staff['external_staff_id'], $e_ids)) 
			{
				if(modules::run('api/shoebooks/update_employee', $staff['external_staff_id']))
				{
					$updated++;
				}
			}
			else
			{
				if(modules::run('api/shoebooks/append_employee', $staff['user_id']))
				{
					$exported++;
				}
				else
				{
					$errors++;
				}
			}
		}
		
		$data['total'] = count($employee);
		$data['old'] = count($e_ids);
		$data['staffbooks_total'] = count($staffs);
		$data['imported'] = $imported;
		$data['exported'] = $exported;
		$data['updated'] = $updated;
		$data['errors'] = $errors;
		$data['type'] = 'Staff';
		$data['platform'] = 'Shoebooks';
		$this->load->view('integration/results', isset($data) ? $data : NULL);
	}
	
	function check_shoebooks_client()
	{
		# Get all customers from Shoebooks
		$customers = modules::run('api/shoebooks/search_customer');
		$customer_ids = array();
		foreach($customers as $c)
		{
			$customer_ids[] = $c['DataID'];
		}
		
		# Get all clients from StaffBooks
		$this->load->model('client/client_model');
		$clients = $this->client_model->search_clients();
		$client_ids = array();
		foreach($clients as $client)
		{
			$client_ids[] = $client['external_client_id'];
		}
		
		$synced = array_intersect($customer_ids, $client_ids);
		$warnings = array();
		foreach($synced as $external_id)
		{
			$client = modules::run('client/get_client_by_external_id', $external_id);
			$customer = modules::run('api/shoebooks/read_customer', $external_id);
			if (strtolower($client['company_name']) != strtolower($customer['CompanyName']))
			{
				$warnings[] = $external_id;
			}
		}
		
		$data['type'] = 'client';
		$data['platform'] = 'Shoebooks';
		$data['total_staffbooks'] = count($clients);
		$data['total_shoebooks'] = count($customers);
		$data['synced'] = count($synced);
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results', isset($data) ? $data : NULL);
	}
	
	function download_shoebooks_client_report()
	{
		$ids = unserialize($this->input->post('ids'));
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("Shoebooks Client Report");
		$objPHPExcel->getProperties()->setSubject("Shoebooks Client Report");
		$objPHPExcel->getProperties()->setDescription("Check Client for Sync to Shoebooks Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'StaffBooks Company Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Shoebooks Company Name');
		
		for($i=0; $i<count($ids); $i++)
		{
			$client = modules::run('client/get_client_by_external_id', $ids[$i]);
			$customer = modules::run('api/shoebooks/read_customer', $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $client['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $client['company_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $customer['CompanyName']);
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_client_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_client_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function sync_shoebooks_client()
	{
		$imported = 0;
		$exported = 0;
		$updated = 0;
		$errors = 0;
		
		$this->load->model('user/user_model');
		$this->load->model('client/client_model');
		
		# Get all customers from Shoebooks
		$customers = modules::run('api/shoebooks/search_customer');
		$c_ids = array();
		
		# Get all clients from StaffBooks
		$clients = $this->client_model->search_clients();
		
		# Check if any customer is already in StaffBooks, otherwise add to StaffBooks
		foreach($customers as $c)
		{
			$client = modules::run('client/get_client_by_external_id', $c['DataID']);
			if ($client)
			{
				$c_ids[] = $c['DataID'];
			}
			else
			{
				$input = modules::run('api/shoebooks/read_customer', $c['DataID']);
				$user_data = array(
					'status' => CLIENT_ACTIVE,
					'is_admin' => 0,
					'is_staff' => 0,
					'is_client' => 1,
					'email_address' => '',
					'username' => '',
					'full_name' => trim($input['FirstName'] . ' ' . $input['LastName']),
					'address' => $input['Address'],
					'suburb' => $input['County'],
					'city' => $input['City'],
					'state' => $input['State'],
					'postcode' => $input['Zip'],
					'country' => $input['Country']
				);
				
				$user_id = $this->user_model->insert_user($user_data);
				if ($user_id)
				{
					$client_data = array(
						'user_id' => $user_id,
						'external_client_id' => $c['DataID'],
						'company_name' => $input['CompanyName'],
						'abn' => $input['CompanyABN']
					);
					$client_id = $this->client_model->insert_client($client_data, true);
					if ($client_id)
					{
						$imported++;
					}
				}				
			}
		}
		
		# Now transfer from Staffbooks to Shoebooks		
		foreach($clients as $client)
		{
			if (in_array($client['external_client_id'], $c_ids)) 
			{
				if (modules::run('api/shoebooks/update_customer', $client['external_client_id']))
				{
					$updated++;
				}
			}
			else 
			{
				if (modules::run('api/shoebooks/append_customer', $client['user_id']))
				{
					$exported++;
				}
				else
				{
					$errors++;
				}
			}
		}
		$data['total'] = count($customers);
		$data['old'] = count($c_ids);
		$data['staffbooks_total'] = count($clients);
		$data['imported'] = $imported;
		$data['exported'] = $exported;
		$data['updated'] = $updated;
		$data['errors'] = $errors;
		$data['type'] = 'Clients';
		$data['platform'] = 'Shoebooks';
		$this->load->view('integration/results', isset($data) ? $data : NULL);
	}
	
	function check_myob_staff()
	{
		# First get all employee from MYOB
		$employee = modules::run('api/myob/connect/search_employee');
		$e_ids = array();
		foreach($employee as $e)
		{
			$e_ids[] = $e->DisplayID;
		}
		
		# Get all staff from StaffBooks
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();
		$s_ids = array();
		foreach($staff as $s)
		{
			$s_ids[] = $s['external_staff_id'];
		}
		
		$synced = array_intersect($e_ids, $s_ids);
		$warnings = array();
		
		foreach($employee as $e)
		{
			if (in_array($e->DisplayID, $synced))
			{
				$s = modules::run('staff/get_staff_by_external_id', $e->DisplayID);
				if (strtolower($s['first_name'] . ' ' . $s['last_name']) != strtolower($e->FirstName . ' ' . $e->LastName))
				{
					$warnings[] = $e->DisplayID;
				}
			}
		}
		
		$data['type'] = 'staff';
		$data['platform'] = 'MYOB';
		$data['total_staffbooks'] = count($staff);
		$data['total_shoebooks'] = count($employee);
		$data['synced'] = count($synced);
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results', isset($data) ? $data : NULL);
	}
	
	function download_not_synced_staff_myob()
	{
		$employee = modules::run('api/myob/connect/search_employee');
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("MYOB Employee Report");
		$objPHPExcel->getProperties()->setSubject("MYOB Employee Report");
		$objPHPExcel->getProperties()->setDescription("Check MYOB Employee for Sync to StaffBooks Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Display ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
		
		$i = 0;
		foreach($employee as $e)
		{
			if (!modules::run('staff/get_staff_by_external_id', $e->DisplayID))
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $e->DisplayID);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $e->FirstName);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $e->LastName);
				$i++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_staff_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function download_not_synced_staff_myob_staffbooks()
	{
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("StaffBooks Staff Report");
		$objPHPExcel->getProperties()->setSubject("StaffBooks Staff Report");
		$objPHPExcel->getProperties()->setDescription("Check Staff for Sync to MYOB Excel file, generated from Admin Portal.");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email Address');
		
		$i = 0;
		foreach($staff as $s)
		{
			if (!modules::run('api/myob/connect', 'read_employee~' . $s['external_staff_id']))
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $s['external_staff_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $s['last_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $s['email_address']);
				$i++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('sync_report_staff_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}
	
	function sync_myob_staff()
	{
		$imported = 0;
		$exported = 0;
		$updated = 0;
		$errors = 0;
		
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');
		
		# First get all employee from MYOB
		$employee = modules::run('api/myob/connect/search_employee');
		$e_ids = array();
		
		# Get all staff from StaffBooks
		$staffs = $this->staff_model->search_staffs();
		
		# Check if any employee is already in StaffBooks, otherwise add to StaffBooks
		foreach($employee as $e)
		{
			# Note: if employee doesnot have external id on MYOB (DisplayID), it won't be imported to StaffBooks
			if ($e->DisplayID && $e->DisplayID != '*None')
			{
				$staff = modules::run('staff/get_staff_by_external_id', $e->DisplayID);
				if ($staff)
				{					
					$e_ids[] = $e->DisplayID;
				}
				else
				{
					$user_data = array(
						'status' => 1,
						'is_admin' => 0,
						'is_staff' => 1,
						'is_client' => 0,
						'email_address' => '',
						'username' => '',
						'password' => '',
						'title' => ($e->Addresses[0]->Salutation) ? $e->Addresses[0]->Salutation : '',
						'first_name' => $e->FirstName,
						'last_name' => $e->LastName,
						'address' => ($e->Addresses[0]->Street) ? $e->Addresses[0]->Street : '',
						'suburb' => '',
						'city' => ($e->Addresses[0]->City) ? $e->Addresses[0]->City : '',
						'state' => ($e->Addresses[0]->State) ? $e->Addresses[0]->State : '',
						'postcode' => ($e->Addresses[0]->PostCode) ? $e->Addresses[0]->PostCode : '',
						'country' => ($e->Addresses[0]->Country) ? $e->Addresses[0]->Country : '',
						'phone' => ($e->Addresses[0]->Phone1) ? $e->Addresses[0]->Phone1 : '',
						'mobile' => ($e->Addresses[0]->Phone2) ? $e->Addresses[0]->Phone2 : ''			
					);
					$user_id = $this->user_model->insert_user($user_data);
					if ($user_id)
					{
						$payment_details = modules::run('api/myob/connect' , 'read_employee_payment~' . $e->DisplayID);
						$staff_data = array(
							'user_id' => $user_id,
							'external_staff_id' => $e->DisplayID,
							#'gender' => $input['Gender'],
							#'dob' => date('Y-m-d', strtotime($input['BirthDate'])),
							#'emergency_contact' => $input['EmergencyContact'],
							#'emergency_phone' => $input['EmergencyPhone'],
							#'f_tfn' => $input['SocialSecurity'],
							'f_acc_name'=> isset($payment_details->BankAccounts[0]->BankAccountName) ? $payment_details->BankAccounts[0]->BankAccountName : '',
							'f_bsb' => isset($payment_details->BankAccounts[0]->BSBNumber) ? $payment_details->BankAccounts[0]->BSBNumber : '',
							'f_acc_number' => isset($payment_details->BankAccounts[0]->BankAccountNumber) ? $payment_details->BankAccounts[0]->BankAccountNumber : ''
						);
						#var_dump($staff_data); die();
						$staff_id = $this->staff_model->insert_staff($staff_data, true);
						if ($staff_id)
						{
							$imported++;
						}
					}					
				}
			}						
		}
		
		# Now transfer from Staffbooks to MYOB				
		foreach($staffs as $staff)
		{
			if (in_array($staff['external_staff_id'], $e_ids)) 
			{
				# Update employee
				if(modules::run('api/myob/connect/update_employee~' . $staff['external_staff_id']))
				{
					$updated++;
				}
			}
			else
			{
				# Add new employee
				if (modules::run('api/myob/connect', 'append_employee~' . $staff['user_id']))
				{
					$exported++;
				}
				else
				{
					$errors++;
				}
			}
		}
		
		
		$data['total'] = count($employee);
		$data['old'] = count($e_ids);
		$data['staffbooks_total'] = count($staffs);
		$data['imported'] = $imported;
		$data['exported'] = $exported;
		$data['updated'] = $updated;
		$data['errors'] = $errors;
		$data['type'] = 'Staff';
		$data['platform'] = 'MYOB';
		$this->load->view('integration/results', isset($data) ? $data : NULL);
	}
	
	function sync_myob_client()
	{
		$imported = 0;
		$exported = 0;
		$updated = 0;
		$errors = 0;
		
		$this->load->model('user/user_model');
		$this->load->model('client/client_model');
		
		# Get all customers from MYOB
		$customers = modules::run('api/myob/connect/search_customer');
		$c_ids = array();
		
		# Get all clients from StaffBooks		
		$clients = $this->client_model->search_clients();
		
		# Check if any customer is already in StaffBooks, otherwise add to StaffBooks
		foreach($customers as $c)
		{
			# Note: if customer doesnot have external id on MYOB (DisplayID), it won't be imported to StaffBooks
			if ($c->DisplayID && $c->DisplayID != '*None')
			{				
				$client = modules::run('client/get_client_by_external_id', $c->DisplayID);
				if ($client)
				{
					$c_ids[] = $c->DisplayID;
				}
				else
				{
					$user_data = array(
						'status' => CLIENT_ACTIVE,
						'is_admin' => 0,
						'is_staff' => 0,
						'is_client' => 1,
						'email_address' => isset($c->Addresses[0]->Email) ? $c->Addresses[0]->Email : '',
						'username' => isset($c->Addresses[0]->Email) ? $c->Addresses[0]->Email : '',
						'full_name' => ($c->IsIndividual) ? $c->FirstName . ' ' . $c->LastName : $c->CompanyName,
						'address' => ($c->Addresses[0]->Street) ? $c->Addresses[0]->Street : '',
						'suburb' => '',
						'city' => ($c->Addresses[0]->City) ? $c->Addresses[0]->City : '',
						'state' => ($c->Addresses[0]->State) ? $c->Addresses[0]->State : '',
						'postcode' => ($c->Addresses[0]->PostCode) ? $c->Addresses[0]->PostCode : '',
						'country' => ($c->Addresses[0]->Country) ? $c->Addresses[0]->Country : '',
						'phone' => ($c->Addresses[0]->Phone1) ? $c->Addresses[0]->Phone1 : ''
					);
					$user_id = $this->user_model->insert_user($user_data);
					if ($user_id)
					{
						$client_data = array(
							'user_id' => $user_id,
							'external_client_id' => $c->DisplayID,
							'company_name' => ($c->IsIndividual) ? $c->FirstName . ' ' . $c->LastName : $c->CompanyName,
							'abn' => isset($c->SellingDetails->ABN) ? $c->SellingDetails->ABN : ''
						);
						$client_id = $this->client_model->insert_client($client_data, true);
						if ($client_id)
						{
							$imported++;
						}
					}
				}
			}
		}
		
		# Now transfer from StaffBooks to MYOB
		foreach($clients as $client)
		{
			if (in_array($client['external_client_id'], $c_ids))
			{
				if (modules::run('api/myob/connect/update_customer~' . $client['external_client_id']))
				{
					$updated++;
				}
			}
			else
			{
				if (modules::run('api/myob/connect', 'append_customer~' . $client['user_id']))
				{
					$exported++;
				}
				else
				{
					$errors++;
				}	
			}
		}
		$data['total'] = count($customers);
		$data['old'] = count($c_ids);
		$data['staffbooks_total'] = count($clients);
		$data['imported'] = $imported;
		$data['exported'] = $exported;
		$data['updated'] = $updated;
		$data['errors'] = $errors;
		$data['type'] = 'Clients';
		$data['platform'] = 'MYOB';
		$this->load->view('integration/results', isset($data) ? $data : NULL);
	}
}