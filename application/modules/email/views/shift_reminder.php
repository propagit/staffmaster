<br />
<div class="clearfix" id="email-template">
    <div class="col-md-6">
        <h2 class="email-template-title">Shift Reminder </h2>
        <p> The shift reminder email can be sent to staff to remind them of their shifts </p> 
        <br>               
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Email From</label>
                <div class="col-md-4 first-left">
                    <input type="text" class="form-control" id="shift_reminder_email_from" name="shift_reminder_email_from"/>
                </div>
                <label for="email_subject" class="col-md-2 control-label">Email Subject</label>
                <div class="col-md-4 last-right">
                    <input type="text" class="form-control" id="shift_reminder_email_subject" name="shift_reminder_email_subject"/>
                </div>
            </div>
        </div>
        <textarea id="email_shift_reminder" name="email_shift_reminder">
        	Dear [FIRST NAME] <br>
            Your roster has been updated and requires your attention. Please login to your account to confirm your shifts. <br>
            Your Current Roster is as follows:
            <br>
            <br>
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>	
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>	
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>
            [DATE]	[STARTTIME]	[ENDTIME]		[VENUE]		[SHIFTSTATUS]<br>
            <br>
            Please contact us immeadiatly if you have any questions regarding your roster.<br>
            To Login to your account click here	 
        </textarea>   
        <br>     
        <button type="button" class="btn btn-info"><i class="fa fa-check-square"></i> Save</button>  
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
        <?=modules::run('email/ajax/description_merge_fields');?>
    </div>
</div>

<script>

var email_shift_reminder = CKEDITOR.replace('email_shift_reminder',{
  height:300
});

CKEDITOR.config.toolbar = [
   ['Bold', 'Italic', 'Underline', 'Strike'],[ 'NumberedList', 'BulletedList','-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink'],['Font'],['FontSize' ],[ 'TextColor', 'BGColor']
] ;
</script>