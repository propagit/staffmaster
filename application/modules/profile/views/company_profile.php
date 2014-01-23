<h2>Company Profile</h2>
<p></p>

<div class="panel panel-default">
	<div class="panel-heading">Company Profile</div>
	<div class="panel-body">
    	<ul class="nav nav-tabs" id="navCompany">
			<li class="active"><a href="#profile" data-toggle="tab">Profile Details</a></li>
			<li><a href="#logo" data-toggle="tab">Edit Logo</a></li>
            <li><a href="#emailtemplate" data-toggle="tab">Email Template</a></li>			
		</ul>
        <div class="tab-content">
            <div class="tab-pane active" id="profile">
                <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>profile">
                    <div class="row">
						<div class="col-md-12">
                            <div class="form-group">
                                <label for="company_name" class="col-lg-2 control-label">Company Name <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?=$company['company_name']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_address" class="col-lg-2 control-label">Address <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_address" name="company_address" value="<?=$company['company_address']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_suburb" class="col-lg-2 control-label">Suburb <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_suburb" name="company_suburb" value="<?=$company['company_suburb']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_postcode" class="col-lg-2 control-label">Postcode <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_postcode" name="company_postcode" value="<?=$company['company_postcode']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_state" class="col-lg-2 control-label">State <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_state" name="company_state" value="<?=$company['company_state']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_country" class="col-lg-2 control-label">Country <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_country" name="company_country" value="<?=$company['company_country']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_email" class="col-lg-2 control-label">Email <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_email" name="company_email" value="<?=$company['company_email']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_website" class="col-lg-2 control-label">Website <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_website" name="company_website" value="<?=$company['company_website']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_phone" class="col-lg-2 control-label">Telephone <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_phone" name="company_phone" value="<?=$company['company_phone']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_fax" class="col-lg-2 control-label">Fax <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_fax" name="company_fax" value="<?=$company['company_fax']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_abn" class="col-lg-2 control-label">ABN / ACN <span class="required">**</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_abn" name="company_abn" value="<?=$company['company_abn']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_account_name" class="col-lg-2 control-label">Account Name </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_account_name" name="company_account_name" value="<?=$company['company_account_name']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_account_no" class="col-lg-2 control-label">Account No </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_account_no" name="company_account_no" value="<?=$company['company_account_no']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_bsb" class="col-lg-2 control-label">BSB </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_bsb" name="company_bsb" value="<?=$company['company_bsb']?>" />
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="super_fund_name" class="col-lg-2 control-label">Super Fund Name </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="super_name" name="super_name" value="<?=$company['super_name']?>" />
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="super_fund_product_id" class="col-lg-2 control-label">Super Product ID </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="super_product_id" name="super_product_id" value="<?=$company['super_product_id']?>" />
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="super_fund_phone" class="col-lg-2 control-label">Super Fund Phone </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="super_phone" name="super_fund_phone" value="<?=$company['super_fund_phone']?>" />
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="super_fund_website" class="col-lg-2 control-label">Super Fund Website </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="super_website" name="super_fund_website" value="<?=$company['super_fund_website']?>" />
                                </div>
                            </div>      
                           </div>
                    </div>
                     <div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-8">
							<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update Profile</button>
						</div>
					</div>
				</div>
			</div>     
                </form>
            </div>
    
    
            <div class="tab-pane" id="logo">
                <div class="row">
                    <div class="col-md-12">
                        Company Logo<br />
                        Upload your company Logo that will appear throughout the system,<br />
                        on automated emails, invoices and pay slips.<br />
                        Ideal image size for your logo is<Br />
                        Width: 100PX - 450PX<br />
                        Height 100PX - 220PX <br />
                        <br /><br />
                    </div>
                </div>
            </div>
    
    
            <div class="tab-pane" id="emailtemplate">
                <div class="row">
                    <div class="col-md-12">
                        Email Footer Template
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>