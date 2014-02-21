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
			$this->setting_model->update_company_profile($data['company_id'], $company_data);		
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
			$this->setting_model->update_company_profile($data['company_id'], $company_data);		
		}
	}
		
}