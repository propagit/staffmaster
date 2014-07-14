<form class="form-horizontal" role="form" id="form_update_template">
<input type="hidden" name="template_id" value="<?=$template['template_id'];?>" />
	<div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Status</label>
            <div class="col-lg-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="status" <?=($template['status']) ? 'checked' : '';?> /> Active
					</label>
				</div>
            </div>
        </div>            
	</div>
	<div class="row">
        <div class="form-group">
            <label class="col-lg-2 control-label">Text</label>
            <div class="col-lg-10">
				<textarea class="form-control" rows="3" name="msg" onkeyup="updateTextboxCounter('msg', 'currentChars');" onkeydown="updateTextboxCounter('msg', 'currentChars');" onkeypress="updateTextboxCounter('msg', 'currentChars');"><?=$template['msg'];?></textarea>
				<p class="help-block">Note: 1 SMS message = 160 characters (Current number of characters: <span id="currentChars"><b>0</b> character, <b>0</b> SMS message</span>)</p>
            </div>
        </div>            
	</div>
	<div class="row">
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<div class="alert alert-success hide" id="msg-update-template"><i class="fa fa-check"></i> &nbsp; SMS Template <?=$template['title'];?> has been updated successfully!</div>
				<button type="button" class="btn btn-core" id="btn-update-template">Update</button>
			</div>
		</div>		
	</div>
</form>

<script>
$(function(){
	updateTextboxCounter('msg', 'currentChars');
	$('#btn-update-template').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>sms/ajax/update_template",
			data: $('#form_update_template').serialize(),
			success: function(html) {
				$('#msg-update-template').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-template').addClass('hide');
				}, 2000);
			}
		})
	})
})
</script>