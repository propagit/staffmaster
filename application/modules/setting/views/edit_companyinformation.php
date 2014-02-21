<div class="company-profile-detail-box">
<h2>Company Profile</h2>
<p>Enter your company information in the below form</p>
</div>
<form class="form-horizontal" role="form" id="form_update_company_profile">
<input type="hidden" name="company_id" value="<?=(isset($company['id'])) ? $company['id'] : 0 ?>" />
    <div class="row">
        <div class="col-md-12">
        	<h4 class="company-profile-header-first">Contact Information</h4>
            <div class="form-group">
                <label for="company_name" class="col-lg-2 control-label">Company Name </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?=(isset($company['company_name'])) ? $company['company_name'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_address" class="col-lg-2 control-label">Address </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="address" name="address" value="<?=(isset($company['address'])) ? $company['address'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_suburb" class="col-lg-2 control-label">Suburb </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="suburb" name="suburb" value="<?=(isset($company['suburb'])) ? $company['suburb'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_postcode" class="col-lg-2 control-label">Postcode </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="postcode" name="postcode" value="<?=(isset($company['postcode'])) ? $company['postcode'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_state" class="col-lg-2 control-label">State </label>
                <div class="col-lg-10">                    
                    <?=modules::run('common/field_select_states', 'state', (isset($company['state'])) ? $company['state'] : '');?>
                    
                </div>
            </div>
            <div class="form-group">
                <label for="company_country" class="col-lg-2 control-label">Country </label>
                <div class="col-lg-10">                                    
                    <?=modules::run('common/field_select_countries', 'country', (isset($company['country'])) ? $company['country'] : '');?>
                </div>
            </div>
            <div class="form-group">
                <label for="company_email" class="col-lg-2 control-label">Email </label>
                <div class="col-lg-10">
                    <input type="email" class="form-control" id="email" name="email" data="email" value="<?=(isset($company['email'])) ? $company['email'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_website" class="col-lg-2 control-label">Website </label>
                <div class="col-lg-10">
                    <input type="url" class="form-control" id="website_account" name="website_account" value="<?=(isset($company['website_account'])) ? $company['website_account'] : '' ?>" placeholder="http://www.staffmaster.com.au"/>
                </div>
            </div>
            <div class="form-group">
                <label for="company_phone" class="col-lg-2 control-label">Telephone </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="telephone" name="telephone" value="<?=(isset($company['telephone'])) ? $company['telephone'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_fax" class="col-lg-2 control-label">Fax </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="fax" name="fax" value="<?=(isset($company['fax'])) ? $company['fax'] : '' ?>" />
                </div>
            </div>
            
            <h4 class="company-profile-header">Banking Information</h4>
            <div class="form-group">
                <label for="company_abn" class="col-lg-2 control-label">ABN / ACN </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="abn_acn" name="abn_acn" value="<?=(isset($company['abn_acn'])) ? $company['abn_acn'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_account_name" class="col-lg-2 control-label">Bank Account Name </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" value="<?=(isset($company['bank_account_name'])) ? $company['bank_account_name'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_account_no" class="col-lg-2 control-label">Account No </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" value="<?=(isset($company['bank_account_no'])) ? $company['bank_account_no'] : '' ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="company_bsb" class="col-lg-2 control-label">BSB </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="bank_bsb" name="bank_bsb" value="<?=(isset($company['bank_bsb'])) ? $company['bank_bsb'] : '' ?>" />
                </div>
            </div> 
            
            <h4 class="company-profile-header">Company Super Fund Information</h4>
            <div class="form-group">
                <label for="super_fund_name" class="col-lg-2 control-label">Super Fund Name </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="super_fund_name" name="super_fund_name" value="<?=(isset($company['super_fund_name'])) ? $company['super_fund_name'] : '' ?>" />
                </div>
            </div> 
            <div class="form-group">
                <label for="super_fund_product_id" class="col-lg-2 control-label">Super Product ID </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="super_product_id" name="super_product_id" value="<?=(isset($company['super_product_id'])) ? $company['super_product_id'] : '' ?>" />
                </div>
            </div>  
            <div class="form-group">
                <label for="super_fund_phone" class="col-lg-2 control-label">Super Fund Phone </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="super_phone" name="super_fund_phone" value="<?=(isset($company['super_fund_phone'])) ? $company['super_fund_phone'] : '' ?>" />
                </div>
            </div>  
            <div class="form-group">
                <label for="super_fund_website" class="col-lg-2 control-label">Super Fund Website </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="super_website" name="super_fund_website" value="<?=(isset($company['super_fund_website'])) ? $company['super_fund_website'] : '' ?>" />
                </div>
            </div>      
    	</div>
    </div>
    <div class="row">
		<div class="col-md-6">
    		<div class="form-group">
        		<div class="col-lg-offset-4 col-lg-8">
            		<div class="alert alert-success hide" id="msg-update-company-profile"><i class="fa fa-check"></i> &nbsp; Company profile details has been updated successfully!</div>
                    <button id="btn_update_company_profile" type="button" class="btn btn-info"><i class="fa fa-save"></i> Update Company Profile</button>
        		</div>
    		</div>
		</div>
	</div>     
</form>
<script>
$(function(){
	$('#btn_update_company_profile').click(function(){
		var valid = help.validate_form('form_update_company_profile');
		
		if(valid){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>setting/ajax/update_company_profile",
				data: $('#form_update_company_profile').serialize(),
				success: function(html) {					
					$('#msg-update-company-profile').removeClass('hide');
					setTimeout(function(){
						$('#msg-update-company-profile').addClass('hide');
					}, 2000);
				}	
			})
		}
	})
})
</script>