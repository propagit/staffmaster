<br />
<div class="clearfix email-template">
    <div class="col-md-6">
    	<form id="edit-timesheet-approval-email-template-form" role="form">
        <h2 class="email-template-title"> Timesheet Approval </h2>
        <p> The timesheet approval email can be sent to supervisor or staff to inform them of their timesheets </p> 
        <br>               
        <div class="row">
            <div class="form-group">
                <label for="email_from" class="col-md-2 control-label">Reply To</label>
                <div class="col-md-4 first-left">
                    <input type="text" class="form-control" id="timesheet_approval_email_from" name="timesheet_approval_email_from" value="<?=$template->email_from;?>"/>
                </div>
                <label for="email_subject" class="col-md-2 control-label">Email Subject</label>
                <div class="col-md-4 last-right">
                    <input type="text" class="form-control" id="timesheet_approval_email_subject" name="timesheet_approval_email_subject" value="<?=$template->email_subject;?>"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 remove-gutters">
                <div class="checkbox">
                    <label>
                      <input type="checkbox" class="ts_email_setting" data-key="ts_email_supervisor" <?=($this->config_model->get('ts_email_supervisor')) ? 'checked' : '';?>> Email timesheet to supervisor for approval
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                      <input type="checkbox" class="ts_email_setting" data-key="ts_email_staff" <?=($this->config_model->get('ts_email_staff')) ? 'checked' : '';?>> Email timesheet to staff for approval
                    </label>
                </div>
                <div class="alert alert-success push hide" id="ts-msg-success"><i class="fa fa-check"></i> &nbsp; Your settings was successfully updated!</div>
        </div>
        </div>
        <div class="row">
            <div class="form-group">
        		<textarea class="email-template-text-area" id="timesheet_approval_email" name="timesheet_approval_email"><?=$template->template_content;?></textarea>   
        	</div>
        </div>
        <br>     
        <button type="button" class="btn btn-info" onclick="update_template('edit-timesheet-approval-email-template-form')"><i class="fa fa-check-square"></i> Save</button> <br />
        <input name="template_update_id" type="hidden" value="<?=$template->email_template_id;?>"  />
        <input name="form_name_prefix" type="hidden" value="timesheet_approval_"  />
        </form> 
        <div class="alert alert-success add-top-margin-20 email-template-updated hide"><i class="fa fa-check"></i> &nbsp; Email Template Successfully Updated</div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
    	<? //params 'text field name so that the merge field can be inserted into the text area editor when clicked','Template id : Welcome Template = 1' ?>
        <?=modules::run('email/description_merge_fields','timesheet_approval_email',TIMESHEET_EMAIL_TEMPLATE_ID);?>
    </div>
</div>

<script>
var welcome_email = CKEDITOR.replace('timesheet_approval_email',{
  height:300
});

CKEDITOR.config.toolbar = [
   <?=LIVE_SERVER ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

$(function(){
		
	//add template items on click
	$('.template-item').on('click',function(){
		var text_area_id = $(this).attr('data');
		CKEDITOR.instances['timesheet_approval_email'].insertText($(this).html());
	});	
	
	// config setting for timesheet approval
	$('.ts_email_setting').click(function(){
		var $this = $(this);
		var key = $this.attr('data-key');
		var on = '';
		if ($this.is(':checked')) {
			on = 1;
		}
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: key + '=' + on,
			success: function(html) {
				$('#ts-msg-success').removeClass('hide');
				setTimeout(function(){
					$('#ts-msg-success').addClass('hide');
				}, 2000);
			}
		})
	})
});

</script>