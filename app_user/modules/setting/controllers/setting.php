<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller: Setting
 */

class Setting extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user/user_model');
		$this->load->model('setting_model');
	}

	public function index($method='', $param='')
	{
		switch($method)
		{
			case 'edit_sub_user':
					$this->edit_sub_user();
				break;
			case 'delete_sub_user':
					$this->delete_sub_user($param);
				break;
			case 'create_pdf':
					$this->create_pdf();
				break;
			case 'update_system_styles':
					$this->update_system_styles();
				break;
			case 'custom_css':
					$this->custom_css();
				break;
			case 'system_settings':
					$this->system_settings();
				break;
			case 'integration':
					$this->integration();
				break;
			default:
					$this->company();
			break;
		}
	}
	/**
	*	@name: company
	*	@desc: function to call the view of one of company profile
	*	@access: public
	*	@return: view based on tab
	*/
	function company()
	{
		$company = $this->setting_model->get_profile();
		$data['company'] = $company;
		$this->load->view('company_profile', isset($data) ? $data : NULL);
	}
	/**
	*	@name: update_profile
	*	@desc: function to update company profile
	*	@access: public
	*	@return: view based on tab
	*/
	function update_profile()
	{
		$company = $this->setting_model->get_profile();
		$company_email = $this->setting_model->get_profile_email_template();
		if ($this->input->post())
		{
			$data = $this->input->post();
			$this->setting_model->update_profile(1, array(
				'company_name' => $data['company_name'],
				'company_address' => $data['company_address'],
				'company_suburb' => $data['company_suburb'],
				'company_postcode' => $data['company_postcode'],
				'company_state' => $data['company_state'],
				'company_country' => $data['company_country'],
				'company_email' => $data['company_email'],
				'company_website' => $data['company_website'],
				'company_phone' => $data['company_phone'],
				'company_fax' => $data['company_fax'],
				'company_abn' => $data['company_abn'],
				'company_account_name' => $data['company_account_name'],
				'company_account_no' => $data['company_account_no'],
				'company_bsb' => $data['company_bsb'],
				'super_name' => $data['super_name'],
				'super_product_id' => $data['super_product_id'],
				'super_fund_phone' => $data['super_fund_phone'],
				'super_fund_website' => $data['super_fund_website'],
			));
		}
		$data['states'] = $this->user_model->get_states();
		$data['company'] = $company;
		$this->load->view('company_profile', isset($data) ? $data : NULL);
	}


	function form_upload_photo($company_id)
	{
		$data['company_id'] = $company_id;
		$this->load->view('upload_logo_form', isset($data) ? $data : NULL);
	}

	function superinformasi($field_name='',$field_value='')
	{
		$company = $this->setting_model->get_profile();
		if(isset($company))
		{
			echo $company[$field_name];
		}
	}
	/**
	*	@name: get_template_footer
	*	@desc: Get Email Footer Template
	*	@access: public
	*	@param: (via POST) Background color and Font color
	*
	*/
	function get_email_footer()
	{
		$company = $this->setting_model->get_profile();
		$color = COLOUR_PRIM;
		$font_color = COLOUR_SECO;
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

		$data['color'] = $color;
		$data['font_color'] = $font_color;
		$data['company'] = $company;
		$this->load->view('email_footer_template', isset($data) ? $data : NULL);
	}

	/**
	*	@name: company_logo
	*	@desc: ajax function to get company logo
	*	@access: public
	*
	*
	*/
	function company_logo($full_image = false)
	{
		$data['company'] = $this->setting_model->get_profile();
		$data['full_image'] = $full_image;
		$this->load->view('company_logo', isset($data) ? $data : NULL);
	}

	/**
	*	@name: company_profile
	*	@desc: ajax function to get company logo
	*	@access: public
	*
	*
	*/
	function company_profile()
	{
		return $this->setting_model->get_profile();
	}


	/**
	*	@name: update_system_styles
	*	@desc: Updates System styles
	*	@access: public
	*	@param: ([vai post] primary colour, secondary colour, rollover colour, text colour)
	*	@return: reloads system styles page
	*/
	function update_system_styles()
	{
		$data = array(
					'primary_colour' => $this->input->post('primary_colour'),
					'rollover_colour' => $this->input->post('rollover_colour'),
					'secondary_colour' => $this->input->post('secondary_colour'),
					'text_colour' => $this->input->post('text_colour'),
					'modified' => date('Y-m-d H:i:s')
				);
		$this->setting_model->update_system_styles($data);
		//update email signature colors
		$company = $this->company_profile();
		$data = $this->input->post();
		$company_data = array(
			'email_background_colour' => trim($this->input->post('primary_colour'),'#'),
			'email_font_colour' => trim($this->input->post('secondary_colour'),'#')
		);

		if(!$company){
			$this->setting_model->create_company_profile($company_data);
		}else		{
			$this->setting_model->update_profile($company['id'], $company_data);
		}

		redirect('setting/company');
	}
	/**
	*	@name: delete_company_logo
	*	@desc: Deletes old company logo as new one is added to the system
	*	@access: public
	*	@param: ([string] path to the file, file name)
	*	@return: null
	*/
	function delete_company_logo($path,$file_name)
	{
		//delete main image
		if(file_exists($path.'/'.$file_name)){
			unlink($path.'/'.$file_name);
		}
		//delete thumb
		if(file_exists($path.'/thumbnail/'.$file_name)){
			unlink($path.'/thumbnail/'.$file_name);
		}
	}

	/**
	*	@name: system_settings
	*	@desc: Provides UI to update system settings such as system styles, information sheet configuration etc
	*	@access: public
	*	@param: (null)
	*	@return: Loads UI to change system settings
	*/
	function system_settings()
	{
		$this->load->view('system_settings/main_view', isset($data) ? $data : NULL);
	}

	/**
	*	@name: get_information_sheet_config_status
	*	@desc: This function checks if an element of the information sheet is set as active or not
	*	@access: public
	*	@param: ([int] information_sheet_config_id)
	*	@return: returns information sheet status
	*/
	function get_information_sheet_config_status($information_sheet_config_id)
	{
		$info_sheet_status = $this->setting_model->get_information_sheet_configuration($information_sheet_config_id);
		if($info_sheet_status->element_active == 'yes'){
			return true;
		}else{
			return false;
		}
	}

	function integration()
	{
		$this->load->view('integration', isset($data) ? $data : NULL);
	}


}
