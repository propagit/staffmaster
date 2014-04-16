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
			case 'system_styles':
					$this->system_styles();
				break;
			case 'update_system_styles':
					$this->update_system_styles();
				break;
			case 'custom_css':
					$this->custom_css();
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
		if($_POST){
			$color = $this->input->post('color');
			$font_color = $this->input->post('font_color');
		}
		else
		{
			$color = $company['email_background_colour'];
			$font_color = $company['email_font_colour'];
		}
		
		
		$data['color'] = $color;
		$data['font_color'] = $font_color;
		$data['company'] = $company;
		$this->load->view('setting/email_footer_template', isset($data) ? $data : NULL);	
	}
	
	/**
	*	@name: company_logo
	*	@desc: ajax function to get company logo
	*	@access: public
	*	
	*	
	*/
	function company_logo()
	{
		$data['company'] = $this->setting_model->get_profile();
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
	*	@name: system_styles
	*	@desc: Provides UI to change system colour
	*	@access: public
	*	@param: (null)
	*	@return: Loads UI to change system styles
	*/
	function system_styles()
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
		$this->load->view('system_styles', isset($data) ? $data : NULL);
	}
	
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
		redirect('setting/system_styles');
	}
}