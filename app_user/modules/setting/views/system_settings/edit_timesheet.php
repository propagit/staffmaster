<div class="company-profile-detail-box">
	<h2>Email Timesheet For Approval</h2>
	<p>
    You can choose to send email to a supervisor or staff for approval everytime you generate new timesheets.<br>
    If you do not want to send these emails to your supervisor or staff, simply uncheck all the boxes below. (These settings are turned off by default).
    </p>
</div>
<p>Tick the appropriate boxes you would like to receive these emails<br /><br /></p>
<div class="col-md-12 remove-gutters">
		<div class="checkbox">
			<label>
			  <input type="checkbox" class="ts_email_setting" data-key="ts_email_supervisor" <?=($this->config_model->get('ts_email_supervisor')) ? 'checked' : '';?>> Email pending timesheet to supervisor for approval
			</label>
		</div>
        <div class="checkbox">
			<label>
			  <input type="checkbox" class="ts_email_setting" data-key="ts_email_staff" <?=($this->config_model->get('ts_email_staff')) ? 'checked' : '';?>> Email pending timesheet to staff for approval
			</label>
		</div>
</div>
<br><br>
<div class="alert alert-success push hide" id="ts-msg-success"><i class="fa fa-check"></i> &nbsp; Your settings was successfully updated!</div>
<script>
$(function(){
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
})
</script>
