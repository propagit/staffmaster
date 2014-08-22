<div class="company-profile-detail-box">
	<h2></h2>
</div>

<div class="checkbox pull-left">
	<label>
		<input type="checkbox" id="separate_client_payrate" <?=($this->config_model->get('separate_client_payrate')) ? 'checked' : '';?>> Allow separate client rate
	</label>
	<p class="text-muted">By default when setting up a pay rate in the system you are able to set both the client and staff charge rates. <br />
	If you need to charge 1 pay rate for staff and another pay rate for client turn this option on. Turning this on will allow you to select a separate pay rate for clients. The staff rate will still be displayed in the pay rate column with the additional client rate displayed below. The staff rate will be used for the staff pay run and the client rate will be used for client invoices.</p>
</div>

<script>
$(function(){
	$('#separate_client_payrate').click(function(){
		var on = '';
		if ($(this).is(':checked')) {
			on = 1;
		}
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: {separate_client_payrate: on},
			success: function(html) {
				load_client_payrates();
			}
		})
	})
})
</script>