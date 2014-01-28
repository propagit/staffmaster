<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url()?>assets/js/colorpicker/colorpicker.css" />  
<script type="text/javascript" src="<?=base_url()?>assets/js/colorpicker/colorpicker.js"></script>
<script>
$('#cPicker').ColorPicker({
		color: '#e62e90',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#cPicker div').css('backgroundColor', '#' + hex);
		}
	});
	
	$('#flatPicker').ColorPicker({flat: true});
</script>
<h2>Manage Company Profile</h2>
<p>Your company profile information is used in various areas of the system such as email corospondance,<br />
your invoices, your quotes and login screen, Please ensure the below information is accurate.</p>
<br />
<div class="panel panel-default">
	<div class="panel-heading">Company Profile</div>
	<div class="panel-body">
    	<ul class="nav nav-tabs" id="navCompany">
			<li class="active"><a href="#profile" data-toggle="tab">Company Information</a></li>
			<li><a href="#logo" data-toggle="tab">Your Company Logo</a></li>
            <li><a href="#emailtemplate" data-toggle="tab">Your Email Signature</a></li>			
		</ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="profile">
            	<h2>Company Profile</h2>
        		<p>Enter your company information in the below form</p>
                <br />
                <h4>Contact Information</h4>
                <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>profile">
                    <div class="row">
						<div class="col-md-12">
                            <div class="form-group">
                                <label for="company_name" class="col-lg-2 control-label">Company Name </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?=$company['company_name']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_address" class="col-lg-2 control-label">Address </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_address" name="company_address" value="<?=$company['company_address']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_suburb" class="col-lg-2 control-label">Suburb </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_suburb" name="company_suburb" value="<?=$company['company_suburb']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_postcode" class="col-lg-2 control-label">Postcode </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_postcode" name="company_postcode" value="<?=$company['company_postcode']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_state" class="col-lg-2 control-label">State </label>
                                <div class="col-lg-10">
                                    <?=modules::run('common/dropdown_states', 'company_state', $company['company_state']);?>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_country" class="col-lg-2 control-label">Country </label>
                                <div class="col-lg-10">                                    
                                    <?=modules::run('common/dropdown_countries', 'company_country', $company['company_country']);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_email" class="col-lg-2 control-label">Email </label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="company_email" name="company_email" value="<?=$company['company_email']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_website" class="col-lg-2 control-label">Website </label>
                                <div class="col-lg-10">
                                    <input type="url" class="form-control" id="company_website" name="company_website" value="<?=$company['company_website']?>" placeholder="http://www.staffmaster.com.au"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_phone" class="col-lg-2 control-label">Telephone </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_phone" name="company_phone" value="<?=$company['company_phone']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_fax" class="col-lg-2 control-label">Fax </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_fax" name="company_fax" value="<?=$company['company_fax']?>" />
                                </div>
                            </div>
                            <br />
                            <h4>Banking Information</h4>
                            <div class="form-group">
                                <label for="company_abn" class="col-lg-2 control-label">ABN / ACN </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="company_abn" name="company_abn" value="<?=$company['company_abn']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_account_name" class="col-lg-2 control-label">Bank Account Name </label>
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
                            <br />
                            <h4>Company Super Fund Information</h4>
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
                       	<h2>Your Email Signature</h2>
                        <p>Your email signature will be attached to the base of every email sent from the system</p>
                        <br />
                        
                        <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>profile/emailtemplate">
                        <div class="row">
                            <div class="col-md-6">
                            	<h4>Contact Information</h4>
                                <br />
                                <div class="form-group">
                                    <label for="company_name" class="col-lg-3 control-label">Company Name </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_name" name="email_company_name" value="<?=($company_email['email_company_name'] == '') ? $company['company_name'] : $company_email['email_company_name'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_address" class="col-lg-3 control-label">Address </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_address" name="email_company_address" value="<?=($company_email['email_company_address'] == '') ? $company['company_address'] : $company_email['email_company_address'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_suburb" class="col-lg-3 control-label">Suburb </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_suburb" name="email_company_suburb" value="<?=($company_email['email_company_suburb'] == '') ? $company['company_suburb'] : $company_email['email_company_suburb'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_state" class="col-lg-3 control-label">State </label>
                                    <div class="col-lg-6">
                                        <?=modules::run('common/dropdown_states', 'email_company_state', ($company_email['email_company_state'] == '') ? $company['company_state'] : $company_email['email_company_state']);?>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_postcode" class="col-lg-3 control-label">Postcode </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_postcode" name="email_company_postcode" value="<?=($company_email['email_company_postcode'] == '') ? $company['company_postcode'] : $company_email['email_company_postcode'];?>" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="company_country" class="col-lg-3 control-label">Country </label>
                                    <div class="col-lg-6">                                    
                                        <?=modules::run('common/dropdown_countries', 'email_company_country', ($company_email['email_company_country'] == '') ? $company['company_country'] : $company_email['email_company_country']);?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_phone" class="col-lg-3 control-label">Telephone </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_phone" name="email_company_phone" value="<?=($company_email['email_company_phone'] == '') ? $company['company_phone'] : $company_email['email_company_phone'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_fax" class="col-lg-3 control-label">Fax </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_fax" name="email_company_fax" value="<?=($company_email['email_company_fax'] == '') ? $company['company_fax'] : $company_email['email_company_fax'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_email" class="col-lg-3 control-label">Email </label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" id="email_company_email" name="email_company_email" value="<?=($company_email['email_company_email'] == '') ? $company['company_email'] : $company_email['email_company_email'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_website" class="col-lg-3 control-label">Website </label>
                                    <div class="col-lg-6">
                                        <input type="url" class="form-control" id="email_company_website" name="email_company_website" value="<?=($company_email['email_company_website'] == '') ? $company['company_website'] : $company_email['email_company_website'];?>" placeholder="http://www.staffmaster.com.au"/>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-6">
                            	<h4>Social Media</h4>
                                <br />
                                <div class="form-group">
                                    <label for="company_name" class="col-lg-3 control-label">Facebook </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_facebook" name="email_company_facebook" value="<?=($company_email['email_company_facebook'] == '') ? '' : $company_email['email_company_facebook'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_address" class="col-lg-3 control-label">Twitter </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_twitter" name="email_company_twitter" value="<?=($company_email['email_company_twitter'] == '') ? '' : $company_email['email_company_twitter'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_suburb" class="col-lg-3 control-label">LinkedIn </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_linkedin" name="email_company_linkedin" value="<?=($company_email['email_company_linkedin'] == '') ? '' : $company_email['email_company_linkedin'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_state" class="col-lg-3 control-label">Google+ </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_googleplus" name="email_company_googleplus" value="<?=($company_email['email_company_googleplus'] == '') ? '' : $company_email['email_company_googleplus'];?>" />
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_postcode" class="col-lg-3 control-label">You Tube </label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="email_company_youtube" name="email_company_youtube" value="<?=($company_email['email_company_youtube'] == '') ? '' : $company_email['email_company_youtube'];?>" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="company_country" class="col-lg-3 control-label">Instagram </label>
                                    <div class="col-lg-6">                                    
                                        <input type="text" class="form-control" id="email_company_instagram" name="email_company_instagram" value="<?=($company_email['email_company_instagram'] == '') ? '' : $company_email['email_company_instagram'];?>" />
                                    </div>
                                </div>
                                <h4>Common Statement</h4>
                                <br />
                                <div class="form-group">
                                    <label for="company_phone" class="col-lg-3 control-label">Enter text </label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" id="email_company_text" name="email_company_text" rows="10"> <?=($company_email['email_company_text'] == '') ? '' : $company_email['email_company_text'];?> </textarea>
                                    </div>
                                </div>     
                                <h4>Login To Your Account</h4>                           
                                <div class="form-group">
                                    <label for="company_country" class="col-lg-3 control-label">Include</label>
                                    <div class="col-lg-6">                                    
                                        <input type="checkbox" class="form-control" id="email_company_login_button" name="email_company_login_button" value="<?=($company_email['email_company_login_button'] == '') ? '' : $company_email['email_company_login_button'];?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            	<h2> Preview </h2>
                                <br />
                                <div id="template_email" style="border:1px solid #dfdfdf;background:#fbfbfb; border-radius:3px; padding:15px;">
                                	<div id="template_email_inside" style="background:#00bbf8; padding:15px;color:#fff;float:none;">
                                    	<div style="float:left;width:40%;font-size:11px;">
                                    	<?=($company_email['email_company_name'] == '') ? $company['company_name'] : $company_email['email_company_name'];?><br />
                                        <?=($company_email['email_company_address'] == '') ? $company['company_address'] : $company_email['email_company_address'];?><br />
                                        <?=($company_email['email_company_state'] == '') ? $company['company_state'] : $company_email['email_company_state'];?>&nbsp; 
										<?=($company_email['email_company_country'] == '') ? $company['company_country'] : $company_email['email_company_country'];?> &nbsp;
										<?=($company_email['email_company_postcode'] == '') ? $company['company_postcode'] : $company_email['email_company_postcode'];?><br />
                                        <br />
                                        T: <?=($company_email['email_company_phone'] == '') ? $company['company_phone'] : $company_email['email_company_phone'];?> <br />
                                        F: <?=($company_email['email_company_fax'] == '') ? $company['company_fax'] : $company_email['email_company_fax'];?> <br />
                                        E: <?=($company_email['email_company_email'] == '') ? $company['company_email'] : $company_email['email_company_email'];?> <br />
                                        W: <?=($company_email['email_company_website'] == '') ? $company['company_website'] : $company_email['email_company_website'];?> <br />
                                        </div>
                                        <div style="float:right;width:60%; text-align:right;">
                                    		<table>
                                            <tr><td>
                                            <?=($company_email['email_company_login_button'] == 0) ? '' : '<div id="login_button">Login To Your Account</div>';?>
                                            </td></tr>
                                            <tr>
                                            	<td><table align="right"><tr>
                                                <?=($company_email['email_company_facebook'] == '') ? '' : '<td><i class="fa fa-facebook-square"></i></td>'; ?> 
                                                <?=($company_email['email_company_twitter'] == '') ? '' : '<td><i class="fa fa-twitter-square"></i></td>'; ?> 
                                                <?=($company_email['email_company_linkedin'] == '') ? '' : '<td><i class="fa fa-linkedin-square"></i></td>'; ?> 
                                                <?=($company_email['email_company_googleplus'] == '') ? '' : '<td><i class="fa fa-google-plus-square"></i></td>'; ?> 
                                                <?=($company_email['email_company_youtube'] == '') ? '' : '<td><i class="fa fa-youtube-square"></i></td>'; ?> 
                                                </tr></table></td>
                                            </tr>
                                            <tr><td>
                                            <p style="font-size:10px;">
                                            	<?=($company_email['email_company_text'] == '') ? '' : $company_email['email_company_text'];?>                                            
                                            </p>
                                            </td></tr>
                                            </table>
                                        </div>   
                                        <div style="clear:both;"></div>                                  
                                    </div>
                                       
                                </div>
                                <br />
                                <h4>Colour & Fonts </h4>
                                Background Colour<div class="cPicker" id="cPicker"><div style="background-color: #e62e90"></div><span>Choose color...</span></div>
                                <div class="cPicker" id="flatPicker"></div>
                                Font Colour
                                Font
                                <br />
                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>