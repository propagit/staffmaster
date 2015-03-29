<? if($external_id) { # Update to shoebooks ?>
<div class="pull-right alert alert-default">
	<div class="checkbox no-margin">
	    <label>
	      <input type="checkbox" id="auto-sync" <?=($this->config_model->get('auto_update_staff')) ? 'checked' : '';?>> Auto update to <?=ucwords($platform);?>
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
		data: {auto_update_staff: auto},
		success: function(html) {}
	})
})
</script>
<? } else if($user_id) {
	if (strtolower($platform) == 'shoebooks') { # Add to shoebooks ?>
	<button class="pull-right btn btn-lg btn-primary" id="btn-shoebooks" data-loading-text="Adding to Shoebooks...">
		Add to Shoebooks &nbsp;
		<i class="fa fa-arrow-right"></i>
	</button>

	<script>
	$('#btn-shoebooks').click(function(){
		var btn = $(this);
		btn.button('loading');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>api/shoebooks/append_employee/<?=$user_id;?>",
			success: function(html) {
				location.reload();
			}
		})
	})
	</script>
	<? } else if (strtolower($platform) == 'myob') { ?>
	<button class="pull-right btn btn-lg btn-myob" id="btn-myob" data-loading-text="Adding to MYOB...">
		Add to MYOB &nbsp;
		<i class="fa fa-arrow-right"></i>
	</button>

	<script>
	$('#btn-myob').click(function(){
		var btn = $(this);
		btn.button('loading');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>api/myob/connect/append_employee~<?=$user_id;?>",
			success: function(html) {
				location.reload();
			}
		})
	})
	</script>

	<? } else if (strtolower($platform) == 'xero') { ?>
	<button class="pull-right btn btn-lg btn-core" id="btn-xero" data-loading-text="Adding to Xero...">
		Add to Xero &nbsp;
		<i class="fa fa-arrow-right"></i>
	</button>

	<script>
	$('#btn-xero').click(function(){
		var btn = $(this);
		btn.button('loading');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>api/xero/add_employee/<?=$user_id;?>",
			success: function(html) {
				location.reload();
			}
		})
	})
	</script>
	<? } ?>

<? } else { # Auto add to shoebooks ?>
<div class="pull-right alert alert-default">
	<div class="checkbox no-margin">
	    <label>
	      <input type="checkbox" id="auto-sync" <?=($this->config_model->get('auto_add_staff')) ? 'checked' : '';?>> Auto add to <?=ucwords($platform);?>
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
		data: {auto_add_staff: auto},
		success: function(html) {}
	})
})
</script>
<? } ?>
