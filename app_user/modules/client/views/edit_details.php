<p class="lg">Please note <span class="text-danger">**</span> denotes a required field</p>
<form class="form-horizontal" role="form" id="form_update_client">
<input type="hidden" name="user_id" value="<?=$client['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<div id="f_company_name">
			<label for="company_name" class="col-md-2 control-label">Company Name <span class="text-danger">**</span></label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="company_name" name="company_name" data="required" value="<?=$client['company_name'];?>" />
			</div>
		</div>
		<div id="f_abn">
			<label for="abn" class="col-md-2 control-label">ABN</label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="abn" name="abn" value="<?=$client['abn'];?>" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="full_name" class="col-md-2 control-label">Contact name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="full_name" name="full_name" value="<?=$client['full_name'];?>" />
		</div>					
		<label for="phone" class="col-md-2 control-label">Phone Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="phone" name="phone" value="<?=$client['phone'];?>" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="address" class="col-md-2 control-label">Address</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="address" name="address" value="<?=$client['address'];?>" />
		</div>					
		<label for="suburb" class="col-md-2 control-label">Suburb</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$client['suburb'];?>" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="city" class="col-md-2 control-label">City</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="city" name="city" value="<?=$client['city'];?>" />
		</div>
		<label for="postcode" class="col-md-2 control-label">Postcode</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="postcode" name="postcode" value="<?=$client['postcode'];?>" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="state" class="col-md-2 control-label">State</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_states', 'state', $client['state']);?>
		</div>
		<label for="country" class="col-md-2 control-label">Country</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_countries', 'country', $client['country']);?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div id="f_email_address">
			<label for="email_address" class="col-md-2 control-label">Email (Username) <span class="text-danger">**</span></label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="email_address" name="email_address" data="email" value="<?=$client['email_address'];?>" />
			</div>
		</div>
		<div id="f_password">
			<label for="password" class="col-md-2 control-label">Password</label>
			<div class="col-md-4">
				<input type="password" class="form-control" id="password" name="password" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Account Status</label>
		<div class="col-md-4">
			<?=modules::run('client/field_select_status', 'status', (int)$client['status']);?>
		</div>
		<label for="external_client_id" class="col-md-2 control-label">External Client ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="external_client_id" name="external_client_id" value="<?=$client['external_client_id'];?>" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<div class="alert alert-success hide" id="msg-update"><i class="fa fa-check"></i> &nbsp; Client details has been updated successfully!</div>
			<button type="button" class="btn btn-core" id="btn_update_client"  data-loading-text="Updating client..."><i class="fa fa-save"></i> Update Client</button>
		</div>
	</div>
</div>
</form>
<script>
$(function(){
	$('#btn_update_client').click(function(){
		var btn = $(this);
		btn.button('loading');
		$('.form-group').find('div[id^=f_]').removeClass('has-error');
		$('#form_update_client').find('input').tooltip('destroy');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/update_details",
			data: $('#form_update_client').serialize(),
			success: function(data) {
				btn.button('reset');
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
					$('input[name="' + data.error_id + '"]').tooltip({
						title: data.msg,
						placement: 'bottom'
					});
					$('input[name="' + data.error_id + '"]').focus();
				} else {
					$('#client_name').html($('input[name="company_name"]').val());
					$('#msg-update').removeClass('hide');
					setTimeout(function(){
						$('#msg-update').addClass('hide');
					}, 2000);
				}
				
			}	
		})
	})	
})
</script>