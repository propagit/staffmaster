<br />
<div class="clearfix email-template">
    <div class="col-md-6">
    	<form id="edit-welcome-email-template-form" role="form">
        <h2 class="email-template-title"> Welcome Staff </h2>
        <p> The welcome staff email can be sent to staff to inform them of their accounts </p>
        <br>
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Email From</label>
                <div class="col-md-4 first-left">
                    <input type="text" class="form-control" id="welcome_email_from" name="welcome_email_from" value="<?=$template->email_from;?>"/>
                </div>
                <label for="email_subject" class="col-md-2 control-label">Email Subject</label>
                <div class="col-md-4 last-right">
                    <input type="text" class="form-control" id="welcome_email_subject" name="welcome_email_subject" value="<?=$template->email_subject;?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Auto Send</label>
                <div class="col-md-4 first-left">
                    <input type="checkbox" id="welcome_auto_send" name="welcome_auto_send" <?=$template->auto_send == 'yes' ? 'checked="checked"' : '';?>/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
        		<textarea class="email-template-text-area" id="welcome_email" name="welcome_email"><?=$template->template_content;?></textarea>
        	</div>
        </div>
        <br>
        <button type="button" class="btn btn-info" onclick="update_template('edit-welcome-email-template-form')"><i class="fa fa-check-square"></i> Save</button> <br />
        <input name="template_update_id" type="hidden" value="<?=$template->email_template_id;?>"  />
        <input name="form_name_prefix" type="hidden" value="welcome_"  />
        </form>
        <div class="alert alert-success add-top-margin-20 email-template-updated hide"><i class="fa fa-check"></i> &nbsp; Email Template Successfully Updated</div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
    	<? //params 'text field name so that the merge field can be inserted into the text area editor when clicked','Template id : Welcome Template = 1' ?>
        <?=modules::run('email/description_merge_fields','welcome_email',WELCOME_EMAIL_TEMPLATE_ID);?>
    </div>
</div>

<script>
var welcome_email = CKEDITOR.replace('welcome_email',{
  height:300
});

CKEDITOR.config.toolbar = [
   <?=LIVE_SERVER ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

$(function(){

	//add template items on click
	$('.template-item').on('click',function(){
		var text_area_id = $(this).attr('data');
		CKEDITOR.instances['welcome_email'].insertText($(this).html());
	});
});
</script>
