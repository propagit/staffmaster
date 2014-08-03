<? if($external_id) { # Update to shoebooks ?>
<div class="pull-right alert alert-default">
	<div class="checkbox no-margin">
	    <label>
	      <input type="checkbox" id="auto-sync" <?=($this->config_model->get('auto_update_client')) ? 'checked' : '';?>> Auto update to Shoebooks
	    </label>
	</div> 
</div>
<script>
$('#auto-sync').click(function(){
	var auto = '';
	if ($(this).is(':checked')) {
		auto = 1;
	}
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>config/ajax/add",
		data: {auto_update_client: auto},
		success: function(html) {}
	})
})
</script>
<? } else if($user_id) { # Add to shoebooks ?>
<a class="pull-right btn btn-lg btn-primary" id="btn-shoebooks">
	Add to Shoebooks &nbsp;  
	<i class="fa fa-arrow-right"></i> 
</a>

<script>
$('#btn-shoebooks').click(function(){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>api/shoebooks/append_customer/<?=$user_id;?>",
		success: function(html) {
			location.reload();
		}
	})
})
</script>
<? } else { # Auto add to shoebooks ?>
<div class="pull-right alert alert-default">
	<div class="checkbox no-margin">
	    <label>
	      <input type="checkbox" id="auto-sync" <?=($this->config_model->get('auto_add_client')) ? 'checked' : '';?>> Auto add to Shoebooks
	    </label>
	</div> 
</div>
<script>
$('#auto-sync').click(function(){
	var auto = '';
	if ($(this).is(':checked')) {
		auto = 1;
	}
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>config/ajax/add",
		data: {auto_add_client: auto},
		success: function(html) {}
	})
})
</script>
<? } ?>