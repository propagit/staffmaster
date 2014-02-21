<div class="company-profile-detail-box">
<h2>Your Email Signature</h2>
<p>Your email signature will be attached to the base of every email sent from the sytem</p>
</div>

<form class="form-horizontal" role="form" id="form_update_company_signature">
<input type="hidden" name="company_id" value="<?=(isset($company['id'])) ? $company['id'] : 0 ?>" />
<div class="row">	
    <div class="form-group">
		<label for="contactinformation" class="col-md-6 control-label"><h4 class="company-profile-header-first">Contact Information</h4></label>
        <label for="socialmedia" class="col-md-6 control-label"><h4 class="company-profile-header-first">Social Media</h4></label>
	</div>	
</div>
<div class="row">
	<div class="form-group">
    	<label for="company_name" class="col-md-2 control-label">Company Name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_name" name="email_c_name" value="<?=(isset($company['email_c_name']) && $company['email_c_name'] !='') ? $company['email_c_name'] : '' ?>"/>
		</div>
        <label for="facebook" class="col-md-2 control-label">Facebook</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_facebook" name="email_c_facebook" value="<?=(isset($company['email_c_facebook'])) ? $company['email_c_facebook'] : ''  ?>" />
		</div>
    </div>
</div>
<div class="row">
	<div class="form-group">
    	<label for="address" class="col-md-2 control-label">Address</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_address" name="email_c_address" value="<?=(isset($company['email_c_address']) && $company['email_c_address'] !='') ? $company['email_c_address'] : ''  ?>"/>
		</div>
        <label for="twitter" class="col-md-2 control-label">Twitter</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_twitter" name="email_c_twitter" value="<?=(isset($company['email_c_twitter'])) ? $company['email_c_twitter'] : ''  ?>" />
		</div>
    </div>
</div>
<div class="row">
	<div class="form-group">
    	<label for="suburb" class="col-md-2 control-label">Suburb</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_suburb" name="email_c_suburb" value="<?=(isset($company['email_c_suburb']) && $company['email_c_suburb'] !='') ? $company['email_c_suburb'] : ''  ?>"/>
		</div>
        <label for="linkedin" class="col-md-2 control-label">LinkedIn</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_linkedin" name="email_c_linkedin" value="<?=(isset($company['email_c_linkedin'])) ? $company['email_c_linkedin'] :''  ?>" />
		</div>
    </div>
</div>
<div class="row">
	<div class="form-group">
    	<label for="state" class="col-md-2 control-label">State</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_states', 'email_c_state', (isset($company['email_c_state']) && $company['email_c_state'] !='') ? $company['email_c_state'] : '');?>
            
		</div>
        <label for="google" class="col-md-2 control-label">Google+</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_google" name="email_c_google" value="<?=(isset($company['email_c_google'])) ? $company['email_c_google'] : ''  ?>" />
		</div>
    </div>
</div>

<div class="row">
	<div class="form-group">
    	<label for="postcode" class="col-md-2 control-label">Postcode</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_postcode" name="email_c_postcode" value="<?=(isset($company['email_c_postcode']) && $company['email_c_postcode'] !='') ? $company['email_c_postcode'] : ''  ?>"/>
		</div>
        <label for="youtube" class="col-md-2 control-label">Youtube</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_youtube" name="email_c_youtube" value="<?=(isset($company['email_c_youtube'])) ? $company['email_c_youtube'] : ''  ?>" />
		</div>
    </div>
</div>

<div class="row">
	<div class="form-group">
    	<label for="country" class="col-md-2 control-label">Country</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_countries', 'email_c_country', (isset($company['email_c_country']) && $company['email_c_country'] !='') ? $company['email_c_country'] : '');?>            
		</div>
    	
        <label for="instagram" class="col-md-2 control-label">Instagram</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_instagram" name="email_c_instagram" value="<?=(isset($company['email_c_instagram'])) ? $company['email_c_instagram'] : ''  ?>" />
		</div>
    </div>
</div>

<div class="row">
	<div class="form-group">
    	<label for="telephone" class="col-md-2 control-label">Telephone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_telephone" name="email_c_telephone" value="<?=(isset($company['email_c_telephone']) && $company['email_c_telephone'] !='') ? $company['email_c_telephone'] : ''  ?>"/>
		</div>
        
        
		
    </div>
</div>
<div class="row">
	<div class="form-group">
    	<label for="fax" class="col-md-2 control-label">Fax</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_fax" name="email_c_fax" value="<?=(isset($company['email_c_fax']) && $company['email_c_fax'] !='') ? $company['email_c_fax'] : ''  ?>" />
		</div>
        <label for="commonstatement" class="col-md-6 control-label">Common Statement</label>
		
    </div>
</div>

<div class="row">
	<div class="form-group">
    	<label for="email" class="col-md-2 control-label">Email</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_email" name="email_c_email" value="<?=(isset($company['email_c_email']) && $company['email_c_email'] !='' ) ? $company['email_c_email'] : ''  ?>" data="email"/>
		</div>
    	
        <label for="entertext" class="col-md-2 control-label">Enter Text</label>
		<div class="col-md-4">
			
		</div>
    </div>
</div>

<div class="row">
	<div class="form-group">
    	<label for="website" class="col-md-2 control-label">Website</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_c_website" name="email_c_website" value="<?=(isset($company['email_c_website']) && $company['email_c_email'] !='') ? $company['email_c_website'] : '' ?>" />
		</div>    	        
    </div>
</div>
<div class="company-profile-detail-box">
<h2>Preview</h2>

</div>

<div class="row" >
    <div class="col-md-12" style="padding-left:0px!important; margin-left:0px!important">                
        <div id="template_email" style="border:1px solid #dfdfdf;background:#fbfbfb; border-radius:3px; padding:15px;">
            <div id="template_email_inside" style="background:#00bbf8; padding:15px;color:#fff;float:none;">
                <div style="float:left;width:40%;font-size:11px;">
                <?=(isset($company['email_c_name'])) ? $company['email_c_name'] : 'Company Name';?><br />
                <?=(isset($company['email_c_address'])) ? $company['email_c_address'] : 'Address';?><br />
                <?=(isset($company['email_c_state'])) ? $company['email_c_state'] : 'State';?>&nbsp; 
                <?=(isset($company['email_c_country'])) ? $company['email_c_country'] : 'Country';?> &nbsp;
                <?=(isset($company['email_c_postcode'])) ? $company['email_c_postcode'] : 'Postcode';?><br />
                <br />
                T: <?=(isset($company['email_c_phone'])) ? $company['email_c_phone'] : 'Phone';?> <br />
                F: <?=(isset($company['email_c_fax'])) ? $company['email_c_fax'] : 'Fax';?> <br />
                E: <?=(isset($company['email_c_email'])) ? $company['email_c_email'] : 'Email';?> <br />
                W: <?=(isset($company['email_c_website'])) ? $company['email_c_website'] : 'Website';?> <br />
                </div>
                <div style="float:right;width:60%; text-align:right;">
                    <table>
                    <tr><td>
                    <?=(isset($company['email_company_login_button'])) ?  '<div id="login_button">Login To Your Account</div>' : ''; ?>
                    </td></tr>
                    <tr>
                        <td><table align="right"><tr>
                        <?=(isset($company['email_s_facebook'])) ? '<td><i class="fa fa-facebook-square"></i></td>' : ''; ?> 
                        <?=(isset($company['email_s_twitter'])) ? '<td><i class="fa fa-twitter-square"></i></td>' : ''; ?> 
                        <?=(isset($company['email_s_linkedin'])) ? '<td><i class="fa fa-linkedin-square"></i></td>' : ''; ?> 
                        <?=(isset($company['email_s_googleplus'])) ?  '<td><i class="fa fa-google-plus-square"></i></td>' : ''; ?> 
                        <?=(isset($company['email_s_youtube'])) ? '<td><i class="fa fa-youtube-square"></i></td>' : ''; ?> 
                        </tr></table></td>
                    </tr>
                    <tr><td>
                    <p style="font-size:10px;">
                        <?=(isset($company['email_company_text'])) ? $company['email_company_text'] : '';?>                                            
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
        <br><br>
        
    </div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-12">
			<div class="alert alert-success hide" id="msg-update-personal"><i class="fa fa-check"></i> &nbsp; Company Signature has been updated successfully!</div>
			<button type="button" class="btn btn-core" id="btn_update_personal"><i class="fa fa-save"></i> Save</button>
		</div>
	</div>
</div>


</form>