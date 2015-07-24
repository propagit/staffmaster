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
		if ($tab == 'systemstyles')
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
		}
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
			'super_fund_external_id' => $data['super_fund_external_id'],
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

	function edit_staff_portal()
	{
		$this->load->view('system_settings/edit_staff_portal');
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

	function check_shoebooks_staff_v2()
	{
		# Get all staff from StaffBooks
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();

		$synced = 0;
		$warnings = array();
		foreach($staff as $s)
		{
			if ($s['external_staff_id'])
			{
				$e = modules::run('api/shoebooks/read_employee', $s['external_staff_id']);
				if ($e)
				{
					$synced++;
					if (strtolower(trim($s['first_name']) . ' ' . trim($s['last_name'])) != strtolower(trim($e['FirstName']) . ' ' . trim($e['LastName'])))
					{
						$warnings[] = $s['user_id'];
					}
				}
			}
		}

		$data['type'] = 'staff';
		$data['platform'] = 'Shoebooks';
		$data['total_staffbooks'] = count($staff);
		$data['synced'] = $synced;
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results_v2', isset($data) ? $data : NULL);
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
		$data['total'] = count($employee);
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

	function download_shoebooks_staff_report_v2()
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
			$s = modules::run('staff/get_staff', $ids[$i]);
			$e = modules::run('api/shoebooks/read_employee', $s['external_staff_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $s['external_staff_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name'] . ' ' . $s['last_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $e['FirstName'] . ' ' . $e['LastName']);
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

	function check_shoebooks_client_v2()
	{
		# Get all clients from StaffBooks
		$this->load->model('client/client_model');
		$clients = $this->client_model->search_clients();

		$synced = 0;
		$warnings = array();
		foreach($clients as $client)
		{
			if ($client['external_client_id'])
			{
				$customer = modules::run('api/shoebooks/read_customer', $client['external_client_id']);
				if ($customer)
				{
					$synced++;
					if (strtolower(trim($client['company_name'])) != strtolower(trim($customer['CompanyName'])))
					{
						$warnings[] = $client['user_id'];
					}
				}
			}
		}


		$data['type'] = 'client';
		$data['platform'] = 'Shoebooks';
		$data['total_staffbooks'] = count($clients);
		$data['synced'] = $synced;
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results_v2', isset($data) ? $data : NULL);
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
		$data['total'] = count($customers);
		$data['synced'] = count($synced);
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results', isset($data) ? $data : NULL);
	}

	function download_shoebooks_client_report_v2()
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
			$client = modules::run('client/get_client', $ids[$i]);
			$customer = modules::run('api/shoebooks/read_customer', $client['external_client_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $client['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $client['external_client_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $client['company_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $customer['CompanyName']);
		}

		$objPHPExcel->getActiveSheet()->setTitle('sync_report_client_');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "sync_report_client_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
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
				if (trim(strtolower($s['first_name'] . ' ' . $s['last_name'])) != trim(strtolower($e->FirstName . ' ' . $e->LastName)))
				{
					$warnings[] = $e->DisplayID;
				}
			}
		}

		$data['type'] = 'staff';
		$data['platform'] = 'MYOB';
		$data['total_staffbooks'] = count($staff);
		$data['total'] = count($employee);
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

		$objPHPExcel->getActiveSheet()->setTitle('check_myob_staff');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_myob_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}

	function download_not_synced_staff_myob_staffbooks()
	{
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();
		$employee = modules::run('api/myob/connect/search_employee');
		$e_ids = array();
		foreach($employee as $e)
		{
			$e_ids[] = $e->DisplayID;
		}

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
			if (!in_array($s['external_staff_id'], $e_ids))
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $s['external_staff_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $s['last_name']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . ($i+2), $s['email_address']);
				$i++;
			}
		}

		$objPHPExcel->getActiveSheet()->setTitle('check_staffbooks_staff');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_staffbooks_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}

	function download_myob_staff_report()
	{
		$ids = unserialize($this->input->post('ids'));
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("MYOB Staff Report");
		$objPHPExcel->getProperties()->setSubject("MYOB Staff Report");
		$objPHPExcel->getProperties()->setDescription("Check Staff for Sync to MYOB Excel file, generated from Admin Portal.");

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'StaffBooks Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Shoebooks Name');

		for($i=0; $i<count($ids); $i++)
		{
			$s = modules::run('staff/get_staff_by_external_id', $ids[$i]);
			$e = modules::run('api/myob/connect', 'read_employee~' . $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $s['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $s['first_name'] . ' ' . $s['last_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $e->FirstName . ' ' . $e->LastName);
		}

		$objPHPExcel->getActiveSheet()->setTitle('check_myob_staff');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_myob_staff_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}


	function test_sync_myob_staff()
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

		# Get all actived staff from StaffBooks
		$staffs = $this->staff_model->search_staffs(array('status' => STAFF_ACTIVE));

		# Check if any employee is already in StaffBooks, otherwise add to StaffBooks
		$n = 0;
		foreach($employee as $e)
		{
			if ($imported == 100) { break; } // More than 100 will cause duplication
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
					$user_id = $this->insert_myob_user($e);
					if ($user_id)
					{
						$staff_id = $this->insert_myob_user_staff($user_id,$e->DisplayID);
						if ($staff_id)
						{
							$imported++;
						}
					}
				}
			}

			# Employee does not have external id
			else
			{

				$user_id = $this->insert_myob_user($e);
				if ($user_id)
				{
					# set Display ID in MYOB
					$display_id = STAFF_PREFIX . $user_id;

					if(modules::run('api/myob/update_employee_displayID_onetime',$e,$display_id)){
						#var_dump($staff_data); die();
						$staff_id = $this->insert_myob_user_staff($user_id,$display_id);
						if ($staff_id)
						{
							$imported++;
						}
					}
				}
				else
				{
					$errors++;
				}

			}
		}

		# Now transfer from Staffbooks to MYOB
		/*foreach($staffs as $staff)
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
		}*/

		echo 'MYOB: ' . count($employee);
		echo '<br />E_ids: ' . count($e_ids);
		echo '<br />Staffbooks: ' . count($staffs);
		echo '<br />Imported: ' . $imported;
		echo '<br />Exported: ' . $exported;
		echo '<br />Updated: ' . $updated;
		echo '<br />Error: '; var_dump($errors);

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

		# Get all actived staff from StaffBooks
		$staffs = $this->staff_model->search_staffs(array('status' => STAFF_ACTIVE));

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
					$user_id = $this->insert_myob_user($e);
					if ($user_id)
					{
						$staff_id = $this->insert_myob_user_staff($user_id,$e->DisplayID);
						if ($staff_id)
						{
							$imported++;
						}
					}
				}
			}

			# Employee does not have external id
			else
			{
				/*
					Initially the Sync was build using Display ID instead of UID [yeah i konw, don't ask why, i did not build this],
					which does not work if the MYOB account doesnot have a display id
					since few of our account is already synced we cannot simply starting using UID without doing some
					heavy maintenance work other wise the existing accounts will be out of sync
					to work around this what we will be doing is check if display id exists in myob
					if not then we push the create a DisplayID and puch back to myob
				*/

				$user_id = $this->insert_myob_user($e);
				if ($user_id)
				{
					# set Display ID in MYOB
					$display_id = STAFF_PREFIX . $user_id;

					if(modules::run('api/myob/update_employee_displayID_onetime',$e,$display_id)){
						#var_dump($staff_data); die();
						$staff_id = $this->insert_myob_user_staff($user_id,$display_id);
						if ($staff_id)
						{
							$imported++;
						}
					}
				}
				else
				{
					$errors++;
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

	function insert_myob_user($employee)
	{
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');

		$user_data = array(
						'status' => 1,
						'is_admin' => 0,
						'is_staff' => 1,
						'is_client' => 0,
						'email_address' => isset($employee->Addresses[0]->Email) ? $employee->Addresses[0]->Email : '',
						'username' => isset($employee->Addresses[0]->Email) ? $employee->Addresses[0]->Email : '',
						'password' => '',
						'title' => ($employee->Addresses[0]->Salutation) ? $employee->Addresses[0]->Salutation : '',
						'first_name' => $employee->FirstName,
						'last_name' => $employee->LastName,
						'address' => ($employee->Addresses[0]->Street) ? $employee->Addresses[0]->Street : '',
						'suburb' => '',
						'city' => ($employee->Addresses[0]->City) ? $employee->Addresses[0]->City : '',
						'state' => ($employee->Addresses[0]->State) ? $employee->Addresses[0]->State : '',
						'postcode' => ($employee->Addresses[0]->PostCode) ? $employee->Addresses[0]->PostCode : '',
						'country' => ($employee->Addresses[0]->Country) ? $employee->Addresses[0]->Country : '',
						'phone' => ($employee->Addresses[0]->Phone1) ? $employee->Addresses[0]->Phone1 : '',
						'mobile' => ($employee->Addresses[0]->Phone2) ? $employee->Addresses[0]->Phone2 : ''
					);
		return $this->user_model->insert_user($user_data);

	}

	function insert_myob_user_staff($user_id,$display_id)
	{
		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');

		$payment_details = modules::run('api/myob/connect' , 'read_employee_payment~' . $display_id);
		$payroll_details = modules::run('api/myob/connect', 'read_employee_payroll~' . $display_id);

		$staff_data = array(
			'user_id' => $user_id,
			'external_staff_id' => $display_id,
			'gender' => isset($payroll_details->Gender) ? $payroll_details->Gender : '',
			'dob' => isset($payroll_details->DateOfBirth) ? date('Y-m-d', strtotime($payroll_details->DateOfBirth)) : '0000-00-00',
			#'emergency_contact' => $input['EmergencyContact'],
			#'emergency_phone' => $input['EmergencyPhone'],
			'f_tfn' => isset($payroll_details->Tax->TaxFileNumber) ? $payroll_details->Tax->TaxFileNumber : '',
			'f_acc_name'=> isset($payment_details->BankAccounts[0]->BankAccountName) ? $payment_details->BankAccounts[0]->BankAccountName : '',
			'f_bsb' => isset($payment_details->BankAccounts[0]->BSBNumber) ? $payment_details->BankAccounts[0]->BSBNumber : '',
			'f_acc_number' => isset($payment_details->BankAccounts[0]->BankAccountNumber) ? $payment_details->BankAccounts[0]->BankAccountNumber : ''
		);
		return $this->staff_model->insert_staff($staff_data, true);
	}

	function check_myob_client()
	{
		# Get all customers from MYOB
		$customers = modules::run('api/myob/connect/search_customer');
		$customer_ids = array();
		foreach($customers as $c)
		{
			$customer_ids[] = $c->DisplayID;
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

		foreach($customers as $c)
		{
			if (in_array($c->DisplayID, $synced))
			{
				$client = modules::run('client/get_client_by_external_id', $c->DisplayID);
				$company_name = ($c->IsIndividual) ? $c->FirstName . ' ' . $c->LastName : $c->CompanyName;
				if (trim(strtolower($client['company_name'])) != trim(strtolower($company_name)))
				{
					$warnings[] = $c->DisplayID;
				}
			}
		}

		$data['type'] = 'client';
		$data['platform'] = 'MYOB';
		$data['total_staffbooks'] = count($clients);
		$data['total'] = count($customers);
		$data['synced'] = count($synced);
		$data['warnings'] = $warnings;
		$this->load->view('integration/check_results', isset($data) ? $data : NULL);

	}

	function download_not_synced_client_myob()
	{
		$customers = modules::run('api/myob/connect/search_customer');

		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("MYOB Customer Report");
		$objPHPExcel->getProperties()->setSubject("MYOB Customer Report");
		$objPHPExcel->getProperties()->setDescription("Check MYOB Customer for Sync to StaffBooks Excel file, generated from Admin Portal.");

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Display ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Company Name');

		$i = 0;
		foreach($customers as $c)
		{
			if (!modules::run('client/get_client_by_external_id', $c->DisplayID))
			{
				$company_name = ($c->IsIndividual) ? $c->FirstName . ' ' . $c->LastName : $c->CompanyName;
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $c->DisplayID);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $company_name);
				$i++;
			}
		}

		$objPHPExcel->getActiveSheet()->setTitle('check_myob_client');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_myob_client_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}

	function download_not_synced_client_myob_staffbooks()
	{
		$this->load->model('client/client_model');
		$clients = $this->client_model->search_clients();
		$customers = modules::run('api/myob/connect/search_customer');
		$customer_ids = array();
		foreach($customers as $c)
		{
			$customer_ids[] = $c->DisplayID;
		}

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
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Company Name');

		$i = 0;
		foreach($clients as $c)
		{
			if (!in_array($c['external_client_id'], $customer_ids))
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $c['user_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $c['external_client_id']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $c['company_name']);
				$i++;
			}
		}

		$objPHPExcel->getActiveSheet()->setTitle('check_staffbook_client');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_staffbook_client_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
	}

	function download_myob_client_report()
	{
		$ids = unserialize($this->input->post('ids'));
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Admin Portal");
		$objPHPExcel->getProperties()->setLastModifiedBy("Admin Portal");
		$objPHPExcel->getProperties()->setTitle("MYOB Client Report");
		$objPHPExcel->getProperties()->setSubject("MYOB Client Report");
		$objPHPExcel->getProperties()->setDescription("Check Client for Sync to MYOB Excel file, generated from Admin Portal.");

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Internal ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'External ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'StaffBooks Company Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'MYOB Company Name');

		for($i=0; $i<count($ids); $i++)
		{
			$client = modules::run('client/get_client_by_external_id', $ids[$i]);
			$customer = modules::run('api/myob/connect', 'read_customer~' . $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ($i+2), $client['user_id']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . ($i+2), $ids[$i]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . ($i+2), $client['company_name']);
			$company_name = ($customer->IsIndividual) ? $customer->FirstName . ' ' . $customer->LastName : $customer->CompanyName;
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . ($i+2), $company_name);
		}

		$objPHPExcel->getActiveSheet()->setTitle('check_client');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
		$file_name = "check_client_" . time() . ".xlsx";
		$objWriter->save(EXPORTS_PATH . "/error/" . $file_name);
		echo $file_name;
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
					$user_id = $this->insert_myob_client_userdata($c);
					if ($user_id)
					{
						$client_id = $this->insert_myob_user_client($c,$user_id,$c->DisplayID);
						if ($client_id)
						{
							$imported++;
						}
					}
				}
			}
			else
			{
				$user_id = $this->insert_myob_client_userdata($c);
				if ($user_id)
				{
					# set Display ID in MYOB
					$display_id = CLIENT_PREFIX . $user_id;
					if(modules::run('api/myob/update_customer_displayID_onetime',$c,$display_id)){
						$client_id = $this->insert_myob_user_client($c,$user_id,$display_id);
						if ($client_id)
						{
							$imported++;
						}
					}
				}
				else
				{
					$errors++;
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

	function insert_myob_client_userdata($client)
	{
		$this->load->model('user/user_model');
		$this->load->model('client/client_model');

		$user_data = array(
						'status' => CLIENT_ACTIVE,
						'is_admin' => 0,
						'is_staff' => 0,
						'is_client' => 1,
						'email_address' => isset($client->Addresses[0]->Email) ? $client->Addresses[0]->Email : '',
						'username' => isset($client->Addresses[0]->Email) ? $client->Addresses[0]->Email : '',
						'full_name' => ($client->IsIndividual) ? $client->FirstName . ' ' . $client->LastName : $client->CompanyName,
						'address' => ($client->Addresses[0]->Street) ? $client->Addresses[0]->Street : '',
						'suburb' => '',
						'city' => ($client->Addresses[0]->City) ? $client->Addresses[0]->City : '',
						'state' => ($client->Addresses[0]->State) ? $client->Addresses[0]->State : '',
						'postcode' => ($client->Addresses[0]->PostCode) ? $client->Addresses[0]->PostCode : '',
						'country' => ($client->Addresses[0]->Country) ? $client->Addresses[0]->Country : '',
						'phone' => ($client->Addresses[0]->Phone1) ? $client->Addresses[0]->Phone1 : ''
					);
		return $this->user_model->insert_user($user_data);
	}

	function insert_myob_user_client($client,$user_id,$display_id)
	{
		$this->load->model('user/user_model');
		$this->load->model('client/client_model');

		$client_data = array(
							'user_id' => $user_id,
							'external_client_id' => $display_id,
							'company_name' => ($client->IsIndividual) ? $client->FirstName . ' ' . $client->LastName : $client->CompanyName,
							'abn' => isset($client->SellingDetails->ABN) ? $client->SellingDetails->ABN : ''
						);
		return $this->client_model->insert_client($client_data, true);
	}

	# Email timesheet to supervisor/staff etc setting
	function edit_timesheet()
	{
		$this->load->view('system_settings/edit_timesheet', isset($data) ? $data : NULL);
	}

	function push_xero_employees() {
		$this->load->model('staff/staff_model');
		$staff = $this->staff_model->search_staffs();

		$xml = "<Employees>
					<Employee>
						<FirstName></FirstName>
						<LastName></LastName>
						<DateOfBirth></DateOfBirth>
						<HomeAddress>
							<AddressLine1></AddressLine1>
							<AddressLine2></AddressLine2>
							<City></City>
							<Region></Region>
							<PostalCode></PostalCode>
							<Country></Country>
						</HomeAddress>
						<StartDate></StartDate>
						<TaxDeclaration>
							<AustralianResidentForTaxPurposes>true</AustralianResidentForTaxPurposes>
							<TaxFreeThresholdClaimed>true</TaxFreeThresholdClaimed>
							<HasHELPDebt>false</HasHELPDebt>
							<HasSFSSDebt>false</HasSFSSDebt>
						</TaxDeclaration>
					</Employee>
				</Employees>";
	}

	function pull_xero_employees_to_staffbooks() {

		$this->load->model('user/user_model');
		$this->load->model('staff/staff_model');

		$employees = modules::run('api/xero/get_employees');

		#print_r($employees);return;exit;
		$imported = 0;

		foreach($employees as $e) {
			$staff = modules::run('staff/get_staff_by_external_id', $e['EmployeeID']);
			if (!$staff) {
				$employee = modules::run('api/xero/get_employee', $e['EmployeeID']);
				$user_data = array(
					'status' => 1,
					'is_admin' => 0,
					'is_staff' => 1,
					'is_client' => 0,
					'email_address' => isset($employee['Email']) ? $employee['Email'] : '',
					'username' => isset($employee['Email']) ? $employee['Email'] : '',
					'password' => '',
					#'title' => isset($employee['Title']) ? $employee['Title'] : '',
					'first_name' => $employee['FirstName'],
					'last_name' => $employee['LastName'],
					'address' => isset($employee['HomeAddress']['AddressLine1']) ? $employee['HomeAddress']['AddressLine1'] : '',
					'suburb' => isset($employee['HomeAddress']['AddressLine2']) ? $employee['HomeAddress']['AddressLine2'] : '',
					'city' => isset($employee['HomeAddress']['City']) ? $employee['HomeAddress']['City'] : '',
					'state' => isset($employee['HomeAddress']['Region']) ? $employee['HomeAddress']['Region'] : '',
					'postcode' => isset($employee['HomeAddress']['PostalCode']) ? $employee['HomeAddress']['PostalCode'] : '',
					'country' => isset($employee['HomeAddress']['Country']) ? $employee['HomeAddress']['Country'] : ''
				);
				// echo '<hr />User: '; var_dump($user_data); echo '<br />';
				// $user_id = 1;
				$user_id = $this->user_model->insert_user($user_data);
				if ($user_id)
				{
					$staff_data = array(
						'user_id' => $user_id,
						'external_staff_id' => $employee['EmployeeID'],
						'gender' => isset($employee['Gender']) ? strtolower($employee['Gender']) : '',
						'dob' => isset($employee['DateOfBirth']) ? date('Y-m-d', strtotime($employee['DateOfBirth'])) : '',
						'emergency_contact' => '',
						'emergency_phone' => '',
						'f_aus_resident' => (isset($employee['TaxDeclaration']['AustralianResidentForTaxPurposes']) && $employee['TaxDeclaration']['AustralianResidentForTaxPurposes'] == 'true') ? 1 : 0,
						'f_tax_free_threshold' => (isset($employee['TaxDeclaration']['TaxFreeThresholdClaimed']) && $employee['TaxDeclaration']['TaxFreeThresholdClaimed'] == 'true') ? 1 : 0,
						'f_help_debt' => (isset($employee['TaxDeclaration']['HasHELPDebt']) && $employee['TaxDeclaration']['HasHELPDebt'] == 'true') ? 1 : 0,
						'f_tfn' => isset($employee['TaxDeclaration']['TaxFileNumber']) ? $employee['TaxDeclaration']['TaxFileNumber'] : ''
					);

					if (isset($employee['BankAccounts']['BankAccount'])){
						# check if staff has more than one bank accoun in xero
						$emp_bank_accounts = $employee['BankAccounts'];
						if(isset($employee['BankAccounts']['BankAccount'][0])){
							$emp_bank_accounts = $employee['BankAccounts']['BankAccount'];
						}

						foreach($emp_bank_accounts as $account) {
							if (isset($account['Remainder']) && $account['Remainder']) {
								$staff_data['f_acc_name'] = $account['AccountName'];
								$staff_data['f_bsb'] = $account['BSB'];
								$staff_data['f_acc_number'] = $account['AccountNumber'];
							}
						}

					}


					if (isset($employee['SuperMemberships']['SuperMembership'])){
						# check for multiple super in xero
						$xero_super_account = $employee['SuperMemberships']['SuperMembership'];
						if(isset($employee['SuperMemberships']['SuperMembership'][0])){
							$xero_super_account = $employee['SuperMemberships']['SuperMembership'][0];
						}

						# check if company has set a default super account
						$id = modules::run('setting/superinformasi', 'super_fund_external_id');


						if(isset($xero_super_account['SuperFundID'])){
							$staff_data['s_external_id'] = isset($xero_super_account['SuperFundID']) ? $xero_super_account['SuperFundID'] : '';
							$staff_data['s_employee_id'] = isset($xero_super_account['EmployeeNumber']) ? $xero_super_account['EmployeeNumber'] : '';
							$staff_data['s_choice'] = 'own';
							if($id && ($xero_super_account['SuperFundID'] == $id)){
								$staff_data['s_choice'] = 'employer';
							}
						}

					}

					/*if (count($employee['BankAccounts']) > 0) {
						foreach($employee['BankAccounts']['BankAccount'] as $account) {
							if (isset($account['Remainder']) && $account['Remainder']) {
								$staff_data['f_acc_name'] = $account['AccountName'];
								$staff_data['f_bsb'] = $account['BSB'];
								$staff_data['f_acc_number'] = $account['AccountNumber'];
							}
						}
					}*/
					// echo '<hr />Staff: '; var_dump($staff_data); echo '<br />';
					$staff_id = $this->staff_model->insert_staff($staff_data, true);
					$imported++;
				}
			}
		}
		// echo $imported . '<br />' . $found; return;
		$output = '';
		if ($imported > 0) {
			$output .= '<p>' . $imported . ' new staff has been imported successfully to StaffBooks</p>';
		}
		if (count($employees) > $imported) {
			$output .= '<p>' . (count($employees) - $imported) . ' staff already found in StaffBooks</p>';
		}
		echo $output;
	}
}
