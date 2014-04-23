<div class="company-profile-detail-box">
<h2>Your Email Signature</h2>
<p>Your email signature will be attached to the base of every email sent from the sytem</p>
</div>
<button type="button" class="btn btn-info" id="button_trial_email"><i class="fa fa-envelope-o"></i> Send Email</button>
<br /><br />
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
			<input type="text" class="form-control" id="email_c_facebook" name="email_s_facebook" value="<?=(isset($company['email_s_facebook'])) ? $company['email_s_facebook'] : ''  ?>" />
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
			<input type="text" class="form-control" id="email_c_twitter" name="email_s_twitter" value="<?=(isset($company['email_s_twitter'])) ? $company['email_s_twitter'] : ''  ?>" />
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
			<input type="text" class="form-control" id="email_s_linkedin" name="email_s_linkedin" value="<?=(isset($company['email_s_linkedin'])) ? $company['email_s_linkedin'] :''  ?>" />
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
			<input type="text" class="form-control" id="email_s_google" name="email_s_google" value="<?=(isset($company['email_s_google'])) ? $company['email_s_google'] : ''  ?>" />
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
			<input type="text" class="form-control" id="email_s_youtube" name="email_s_youtube" value="<?=(isset($company['email_s_youtube'])) ? $company['email_s_youtube'] : ''  ?>" />
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
			<input type="text" class="form-control" id="email_s_instagram" name="email_s_instagram" value="<?=(isset($company['email_s_instagram'])) ? $company['email_s_instagram'] : ''  ?>" />
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
		<div class="col-md-4" style="position:absolute!important; left:66%; width:32.5%;">			
            <textarea class="form-control" id="email_common_text" name="email_common_text"> <?=(isset($company['email_common_text']) && $company['email_common_text'] !='' ) ? $company['email_common_text'] : ''  ?></textarea>
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
    <div class="col-md-7 remove-gutters">                
    	<div id="template_footer" class="email-footer-preview-wrap"></div>
        
        <br />
        <h4>Colour & Fonts </h4>
    </div>
</div>
<div class="row">
	<div class="form-group">
    	<div class="col-md-3"> 
        	<div style="float:left">Background Colour </div><div style="float:left; margin-left:10px;"class="cPicker" id="cPicker"><div style="background-color:#09F;"></div><span>Choose color...</span></div>
        	
            <input type="hidden" name="email_background_colour" id="email_background_colour" value="<?=(isset($company['email_background_colour']) && $company['email_background_colour'] !='') ? $company['email_background_colour'] : '00bbf8' ?>">
        </div>
		<div class="col-md-3">
			<div style="float:left">Font Colour </div><div style="float:left; margin-left:10px;" class="cPicker" id="FontcPicker"><div style="background-color:#09C;"></div><span>Choose color...</span></div>
            <input type="hidden" name="email_font_colour" id="email_font_colour" value="<?=(isset($company['email_font_colour']) && $company['email_font_colour'] !='') ? $company['email_font_colour'] : 'ffffff' ?>">
		</div>             	        
    </div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-12">
			<div class="alert alert-success hide" id="msg-update-email-template"><i class="fa fa-check"></i> &nbsp; Company Signature has been updated successfully!</div>
			<button type="button" class="btn btn-core" id="btn_update_email_template"><i class="fa fa-save"></i> Save</button>
		</div>
	</div>
</div>
</form>

<script>
$(function(){	
	update_email_template('<?=(isset($company['email_background_colour']) && $company['email_background_colour'] !='') ? $company['email_background_colour'] : '00bbf8' ?>','<?=(isset($company['email_font_colour']) && $company['email_font_colour'] !='') ? $company['email_font_colour'] : 'ffffff' ?>');
	
	$('#cPicker div').css('backgroundColor', '#' + '<?=(isset($company['email_background_colour']) && $company['email_background_colour'] !='') ? $company['email_background_colour'] : '00bbf8' ?>');
	$('#FontcPicker div').css('backgroundColor', '#' + '<?=(isset($company['email_font_colour']) && $company['email_font_colour'] !='') ? $company['email_font_colour'] : 'ffffff' ?>');
	
	
	$('#cPicker').ColorPicker({
		color: '#<?=(isset($company['email_background_colour']) && $company['email_background_colour'] !='') ? $company['email_background_colour'] : '00bbf8' ?>',
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
			$('#email_background_colour').val(hex);
			update_email_template(hex,$('#email_font_colour').val());			
		}
	});
		
	
	$('#FontcPicker').ColorPicker({
		color: '#<?=(isset($company['email_font_colour']) && $company['email_font_colour'] !='') ? $company['email_font_colour'] : 'ffffff' ?>',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('#FontcPicker div').css('backgroundColor', '#' + hex);
			$('#email_font_colour').val(hex);			

			update_email_template($('#email_background_colour').val(),hex);
		}
	});
		
	
	$('#button_trial_email').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>setting/ajax/send_email_template",			
			success: function(html) {				
			}
		})
	})
	
	$('#btn_update_email_template').click(function(){
		var valid = help.validate_form('form_update_company_signature');					
		if(valid){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>setting/ajax/update_company_signature",
				data: $('#form_update_company_signature').serialize(),
				success: function(html) {					
					$('#msg-update-email-template').removeClass('hide');
					setTimeout(function(){
						$('#msg-update-email-template').addClass('hide');
					}, 2000);
					update_email_template($('#email_background_colour').val(),$('#email_font_colour').val())
				}	
			})
		}
		
	})
})
function update_email_template(color,font_color)
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/get_template_footer",	
		data:{color: color,font_color:font_color},
		success: function(html) {				
			$('#template_footer').html(html);
		}
	})
}

</script>