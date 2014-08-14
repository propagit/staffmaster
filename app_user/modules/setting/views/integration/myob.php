<? # First check API key & secret have been setup 
if (!$this->config_model->get('myob_api_key') || !$this->config_model->get('myob_api_secret')) 
{ ?>
	
	<div class="alert alert-warning">
		Please contact system administrator to set up MYOB Integration
	</div>

<? } 
# Then check if the company_id is configured 
else if (!$this->config_model->get('myob_company_id')) { ?>
	
	<form role="form" id="form-myob">
	<div class="form-group">
	    <label for="myob_username" class="control-label">Username</label>    
		<input type="text" class="form-control" id="myob_username" name="myob_username" value="<?=($this->config_model->get('myob_username')) ? $this->config_model->get('myob_username') : 'Administrator';?>" />
	</div>       
	<div class="form-group">
		<label for="myob_password" class="control-label">Password</label>
		<input type="password" class="form-control" id="myob_password" name="myob_password" value="<?=$this->config_model->get('myob_password');?>" />
	</div>
	<p class="text-muted">The username and password for your company file is usually different from the one you use to sign into MYOB online. It is commonly 'Administrator' and a blank password.</p>
	<div class="alert alert-success hide" id="msg-success"></div>
	<div class="alert alert-danger hide" id="msg-error"></div>
	<button type="button" class="btn btn-myob" id="btn-update">Connect to MYOB</button>
	</form>
	
	<script>
	$(function(){
		$('#btn-update').click(function(){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>config/ajax/add",
				data: $('#form-myob').serialize(),
				success: function(html) {
					window.location = '<?=base_url();?>api/myob/connect';
				}
			})
		})
	})
	</script>

<? } 
# Now test connection
else if (!modules::run('api/myob/connect/test'))
{ ?>
	<script>
	window.location = '<?=base_url();?>api/myob/connect';
	</script>
<? }
# Otherwise, all good
else { ?>

	<div class="alert alert-success">
		Your MYOB Account is connected successfully!	
	</div>

	<div id="platform-data" class="table-responsive">
	<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<th>Data Type</th>
			<th class="center">Auto Add</th>
			<th class="center">Auto Update</th>
			<th class="center">StaffBooks</th>
			<th class="center"><?=ucwords($accounting_platform = $this->config_model->get('accounting_platform'));?></th>
			<th class="center">Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Staff / Employee</td>
			<td class="center">
				<label>
					<input type="checkbox" id="auto-add-staff" <?=($this->config_model->get('auto_add_staff')) ? 'checked' : '';?>>
				</label>
			</td>
			<td class="center">
				<label>
					<input type="checkbox" id="auto-update-staff" <?=($this->config_model->get('auto_update_staff')) ? 'checked' : '';?>>
				</label>
			</td>
			<td class="center">
				<span class="badge success"><?=modules::run('staff/get_total_staff', STAFF_ACTIVE);?></span>
			</td>
			<td class="center">							
				<span class="badge primary"><?=count(modules::run('api/myob/connect/search_employee'));?></span>
			</td>
			<td class="center">
				<a class="btn btn-core" id="btn-sync-staff">
					<i class="fa fa-exchange"></i> Quick Sync								
				</a>
			</td>
		</tr>
		<tr>
		<td>Client / Customer</td>
		<td class="center">
			<label>
				<input type="checkbox" id="auto-add-client" <?=($this->config_model->get('auto_add_client')) ? 'checked' : '';?>>
			</label>
		</td>
		<td class="center">
			<label>
				<input type="checkbox" id="auto-update-client" <?=($this->config_model->get('auto_update_client')) ? 'checked' : '';?>>
			</label>
		</td>
		<td class="center">
			<span class="badge success"><?=modules::run('client/get_total_client');?></span>
		</td>
		<td class="center">
			<span class="badge primary"><?=count(modules::run('api/myob/connect/search_customer'));?></span>							
		</td>
		<td class="center">
			<a class="btn btn-core" id="btn-sync-client">
				<i class="fa fa-exchange"></i> Quick Sync								
			</a>
		</td>
	</tr>
		
	</tbody>
	</table>
	</div>
	
	<button type="button" class="btn btn-danger" id="btn-disconnect">Disconnect MYOB</button>
	
	<!-- Modal -->
	<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" id="order-message">
				<img src="<?=base_url();?>assets/img/loading3.gif" />
				<h2>Please wait!</h2>
				<p>Please wait a moment while we are processing your request ...</p>
			</div>
		</div>
	</div>
	
	<script>
	$(function(){
		$('#waitingModal').modal({
			backdrop: 'static',
			keyboard: true,
			show: false
		})
		$('#btn-sync-staff').click(function(){
			$('.bs-modal-lg').modal('hide');
			$('#waitingModal').modal('show');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>setting/ajax/sync_myob_staff",
				success: function(html) {
					//alert(html);
					location.reload();
				}
			})
		})
		$('#auto-add-staff').click(function(){
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
		$('#auto-update-staff').click(function(){
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
		$('#btn-disconnect').click(function(){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>config/ajax/add",
				data: {myob_company_id : '', myob_access_token_expires: 0, myob_access_token: '', myob_refresh_token: ''},
				success: function(html) {
					location.reload();
				}
			})
		})
	})
	</script>
	
<? } ?>