<br />
<div class="clearfix" id="email-template">
    <div class="col-md-6">
        <h2> Roster Update </h2>
        <p> The roster update email can be sent to staff to inform them of their upcoming shifts </p> 
        <br>               
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Email From</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="roster_email_from" name="roster_email_from"/>
                </div>
                <label for="email_subject" class="col-md-2 control-label">Email Subject</label>
                <div class="col-md-4 last-right">
                    <input type="text" class="form-control" id="roster_email_subject" name="roster_email_subject"/>
                </div>
            </div>
        </div>
        <textarea id="email_roster" name="email_roster">
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

var email_roster = CKEDITOR.replace('email_roster',{
  height:300
});

CKEDITOR.config.toolbar = [
   ['Bold', 'Italic', 'Underline', 'Strike'],[ 'NumberedList', 'BulletedList','-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink'],['Font'],['FontSize' ],[ 'TextColor', 'BGColor']
] ;
</script>