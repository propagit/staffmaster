<form role="form" id="form-shoebooks">
<div class="form-group">
    <label for="shoebooks_account_name" class="control-label">Shoebooks Account Name</label>    
	<input type="text" class="form-control" id="shoebooks_account_name" name="shoebooks_account_name" value="<?=$this->config_model->get('shoebooks_account_name');?>" />
</div>         
        
<div class="form-group">
	<label for="shoebooks_login_name" class="control-label">Shoebooks Login Name </label>	
	<input type="text" class="form-control" id="shoebooks_login_name" name="shoebooks_login_name" value="<?=$this->config_model->get('shoebooks_login_name');?>" />
</div>          
<div class="form-group">
	<label for="shoebooks_login_password" class="control-label">Shoebooks Login Password </label>
	<input type="password" class="form-control" id="shoebooks_login_password" name="shoebooks_login_password" value="<?=$this->config_model->get('shoebooks_login_password');?>" />
</div>

<button type="button" class="btn btn-core" id="btn-shoebooks">Update</button>

</form>
<script>
$(function(){
	$('#btn-shoebooks').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: $('#form-shoebooks').serialize(),
			success: function(html) {
			}
		})
	})
})
</script>