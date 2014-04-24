<?=modules::run('wizard/main_view', 'client');?>

<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Add Client</h2>
    	 <p>Add clients using below form or import multiple clients.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            
            <ul class="nav nav-tabs tab-respond">
				<li class="pull-right"><a href="<?=base_url();?>client/import">Import Clients</a></li>
				<li class="active"><a>Client Details</a></li>
				<li class="disabled"><a>Departments</a></li>
			</ul>
			
			<p class="lg">Please note <span class="text-danger">**</span> denotes a required field</p>
			<form class="form-horizontal" role="form" id="form_add_client">
			<div class="row">
				<div class="form-group">
					<label for="company_name" class="col-md-2 control-label">Company Name <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="company_name" name="company_name" data="required" />
					</div>
					<label for="abn" class="col-md-2 control-label">ABN</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="abn" name="abn" />
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="form-group">
					<label for="full_name" class="col-md-2 control-label">Contact name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="full_name" name="full_name" />
					</div>					
					<label for="phone" class="col-md-2 control-label">Phone Number</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="phone" name="phone" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="address" class="col-md-2 control-label">Address</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="address" name="address" />
					</div>					
					<label for="suburb" class="col-md-2 control-label">Suburb</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="suburb" name="suburb" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-md-2 control-label">City</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="city" name="city" />
					</div>
					<label for="postcode" class="col-md-2 control-label">Postcode</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="postcode" name="postcode" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="state" class="col-md-2 control-label">State</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_states', 'state');?>
					</div>
					<label for="country" class="col-md-2 control-label">Country</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_countries', 'country');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="email_address" class="col-md-2 control-label">Email Address <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="email_address" name="email_address" data="email" />
					</div>
					<label for="password" class="col-md-2 control-label">Password <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="password" class="form-control" id="password" name="password" data="required" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="email_address" class="col-md-2 control-label">Account Status</label>
					<div class="col-md-4">
						<?=modules::run('client/field_select_status', 'status', CLIENT_ACTIVE);?>
					</div>
					<label for="external_client_id" class="col-md-2 control-label">External Client ID</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="external_client_id" name="external_client_id" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
                    	<div class="alert alert-success hide" id="msg-success"><i class="fa fa-check"></i> &nbsp; Client successfully added!</div>
						<button type="button" class="btn btn-core" id="btn_add_client"><i class="fa fa-plus"></i> Add Client</button>
					</div>
				</div>
			</div>
			</form>
    	</div>
	</div>
</div>
<script>
$(function(){
	$('#btn_add_client').click(function(){
		var valid = help.validate_form('form_add_client');
		if (valid) {
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>client/ajax/add_client",
				data: $('#form_add_client').serialize(),
				success: function(html) {
					reload_wizard('client');
					$('#form_add_client')[0].reset();
					$('#msg-success').removeClass('hide');
					setTimeout(function(){
						$('#msg-success').addClass('hide');
					}, 2000);
					//window.location.href = '<?=base_url();?>client/edit/' + html;
				}
			});
		}		
	});
});
</script>