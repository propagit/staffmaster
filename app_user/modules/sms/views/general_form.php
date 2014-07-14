<form id="send-sms-form">
<input type="hidden" name="selected_user_ids" value="<?=implode(',', $selected_user_ids);?>" />
<textarea class="form-control" rows="4" name="msg" onkeyup="updateTextboxCounter('msg', 'currentChars');" onkeydown="updateTextboxCounter('msg', 'currentChars');" onkeypress="updateTextboxCounter('msg', 'currentChars');"></textarea><br />
<p class="step-desc" id="message-desc">Note: 1 SMS message = 160 characters (Current number of characters: <span id="currentChars"><b>0</b> character, <b>0</b> SMS message</span>)</p>
<button type="button" class="btn btn-core" id="btn-send-sms"><i class="fa fa-mobile-phone"></i> Send SMS</button>
&nbsp;&nbsp;
(Selected Recipients: <b id="total-selected-receiver"><?=count($selected_user_ids);?></b>)
&nbsp;&nbsp;
<a id="view-sms-receiver-list"><i class="fa fa-eye"> </i> View Send List</a>
<div class="alert alert-success add-top-margin-20 hide" id="msg-sms-sent-successfully"><i class="fa fa-check"></i> &nbsp; SMS Successfully Sent</div>
<div class="alert alert-danger add-top-margin-20 hide" id="msg-sms-sent-failed"></div>
</form>
<div id="sms-receiver-list" class="email-modal-receiver-list"></div>
<script>
$(function(){
	$('#btn-send-sms').click(function(){
		
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/ajax/send_general_sms",
			data: $('#send-sms-form').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#msg-sms-sent-failed').html('<i class="fa fa-times"></i> &nbsp;' + data.msg);
					$('#msg-sms-sent-failed').removeClass('hide');
				} else {
					setTimeout(function(){
						$('#msg-sms-sent-successfully').removeClass('hide');
					}, 200);
				}
			}
		})
	});
	updateTextboxCounter('msg', 'currentChars');
	$('#view-sms-receiver-list').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/ajax/list_receivers",
			data: {user_ids: '<?=implode(',', $selected_user_ids);?>'},
			success: function(html) {
				$('#sms-receiver-list').html(html);
			}
		})
	})
})

</script>