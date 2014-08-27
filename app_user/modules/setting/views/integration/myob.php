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
	<p><b>The below table displays how many staff and clients you have in StaffBooks and MYOB.</b></p>
	<p><i>Note:</i>
	<ul>
		<li>Clicking the sync button will bring MYOB staff and clients into StaffBooks (Provided they have a unique Card ID in MYOB).</li>
		<li>Staff and clients will also be sent to MYOB if they have no External ID set in StaffBooks. </li>
		<li>New staff pushed into MYOB will be assigned a Card ID that will appear  in StaffBooks in the External ID field</li>
		<li>Clicking the auto add functions on will automatically add and update staff and client data to MYOB</li>
	</ul>
	</p><br />

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
	
	<br />
	<p><b>Settings</b></p>
	<p><i>Note:</i>
	<ul>
		<li>Client Invoice data that have shifts details attached to them will push to MYOB as "TimeBilling".</li>
		<li>Client invoices that include manual line items can not be pushed as "Time Billing" and will be pushed as "Miscellaneous"</li>
	</ul><br />
	<p>You can choose what account in MYOB you would to push manual invoice data to below.</p>
	<table class="table table-bordered table-hover table-middle" width="100%">
	<tbody>
		<tr>
			<td>Invoice</td>
			<td>
				<? $accounts = modules::run('api/myob/connect', 'read_accounts~Income'); ?>
				<select id="myob_invoice_account" class="form-control">
					<option value="">Please select</option>
					<? for($i=0; $i < count($accounts) - 1; $i++) { ?>
					<option value="<?=$accounts[$i]->UID;?>"<?=($accounts[$i]->UID == $this->config_model->get('myob_invoice_account')) ? ' selected' : '';?>><?=$accounts[$i]->Name;?></option>
					<? } ?>
				</select>
			</td>
		</tr>
	</tbody>
	</table>
	
	
	</div>
	
	<div id="output"></div>
	
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
		init_select();
		$('#waitingModal').modal({
			backdrop: 'static',
			keyboard: true,
			show: false
		})
		$('#myob_invoice_account').change(function(){
			var myob_invoice_account = $(this).val();
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>config/ajax/add",
				data: {myob_invoice_account: myob_invoice_account},
				success: function(html) {}
			})
		})
		$('#btn-sync-staff').click(function(){
			$('.bs-modal-lg').modal('hide');
			$('#waitingModal').modal('show');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>setting/ajax/sync_myob_staff",
				success: function(html) {
					$('#order-message').html(html);
				}
			})
		})
		$('#btn-sync-client').click(function(){
			$('.bs-modal-lg').modal('hide');
			$('#waitingModal').modal('show');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>setting/ajax/sync_myob_client",
				success: function(html) {
					$('#order-message').html(html);
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
		$('#auto-add-client').click(function(){
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
		$('#auto-update-client').click(function(){
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