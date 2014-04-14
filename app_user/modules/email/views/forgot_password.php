<br />
<div class="clearfix email-template">
    <div class="col-md-6">
    	<form id="forgot-password-update-email-template-form" role="form">
        <h2 class="email-template-title"> Forgot Password </h2>
        <p> The forgot password email can be sent to staff to inform them of their passwords </p> 
        <br>               
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Email From</label>
                <div class="col-md-4 first-left">
                    <input type="text" class="form-control" id="forgot_password_email_from" name="forgot_password_email_from" value="<?=$template->email_from;?>"/>
                </div>
                <label for="email_subject" class="col-md-2 control-label">Email Subject</label>
                <div class="col-md-4 last-right">
                    <input type="text" class="form-control" id="forgot_password_email_subject" name="forgot_password_email_subject" value="<?=$template->email_subject;?>"/>
                </div>
            </div>
        </div>
        <textarea id="forgot_password_email" name="forgot_password_email"><?=$template->template_content;?></textarea>   
        <br>     
        <button type="button" class="btn btn-info" onclick="update_template('forgot-password-update-email-template-form')"><i class="fa fa-check-square"></i> Save</button> 
        <input name="template_update_id" type="hidden" value="<?=$template->email_template_id;?>"  />
		<input name="form_name_prefix" type="hidden" value="forgot_password_"  />
        </form> 
        <div class="alert alert-success add-top-margin-20 email-template-updated hide" id="email-template-updated"><i class="fa fa-check"></i> &nbsp; Email Template Successfully Updated</div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <?=modules::run('email/description_merge_fields','forgot_password_email',FORGOT_PASSWORD_EMAIL_TEMPLATE_ID);?>
    </div>
</div>

<script>

var forgot_password_email = CKEDITOR.replace('forgot_password_email',{
  height:300
});

CKEDITOR.config.toolbar = [
    <?=LIVE_SERVER ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

$(function(){
		
	//add template items on click
	$('.template-item').on('click',function(){
		var text_area_id = $(this).attr('data');
		CKEDITOR.instances['forgot_password_email'].insertText($(this).html());
	});	
});
</script>