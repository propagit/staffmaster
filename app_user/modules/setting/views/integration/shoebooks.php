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
<div class="alert alert-success hide" id="msg-success"></div>
<div class="alert alert-danger hide" id="msg-error"></div>
<button type="button" class="btn btn-core" id="btn-update">Update</button>

</form>

<br />


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
	<? $employee = count(modules::run('api/shoebooks/search_employee')); ?>
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
			<span class="badge primary"><?=$employee;?></span>
		</td>
		<td class="center">
			<a class="btn btn-core" id="btn-check-staff">
				Check
			</a> &nbsp; 
			<a class="btn btn-core" id="btn-sync-staff">
				<i class="fa fa-exchange"></i> Quick Sync								
			</a>
		</td>
	</tr>
	
	<? $customer = count(modules::run('api/shoebooks/search_customer')); ?>
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
			<span class="badge primary"><?=$customer;?></span>							
		</td>
		<td class="center">
			<a class="btn btn-core" id="btn-check-client">
				Check
			</a> &nbsp; 
			<a class="btn btn-core" id="btn-sync-client">
				<i class="fa fa-exchange"></i> Quick Sync								
			</a>
		</td>
	</tr>
</tbody>
</table>
</div>

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
	
	$('#btn-update').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: $('#form-shoebooks').serialize(),
			success: function(html) {
				test_shoebooks();
			}
		})
	})
	$('#btn-check-staff').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>setting/ajax/check_shoebooks_staff",
			success: function(html) {
				$('#order-message').html(html);
				//location.reload();
			}
		})
	})
	$('#btn-sync-staff').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>setting/ajax/sync_shoebooks_staff",
			success: function(html) {
				$('#order-message').html(html);
				//location.reload();
			}
		})
	})
	
	$('#btn-check-client').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>setting/ajax/check_shoebooks_client",
			success: function(html) {
				$('#order-message').html(html);
				//location.reload();
			}
		})
	})
	$('#btn-sync-client').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>setting/ajax/sync_shoebooks_client",
			success: function(html) {
				$('#order-message').html(html);
				//location.reload();
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
})
function close_waiting_modal()
{
	$('#waitingModal').modal('hide');
}
function test_shoebooks()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>api/shoebooks/test",
		success: function(data) {
			data = $.parseJSON(data);
			if(data.ok) {
				$('#msg-success').html('Connected to your Shoebooks account successfully!');
				$('#msg-success').removeClass('hide');
				setTimeout(function(){
					location.reload();
				}, 2000);
			} else {
				$('#platform-data').remove();
				$('#msg-error').html(data.message);
				$('#msg-error').removeClass('hide');
				setTimeout(function(){
					$('#msg-error').addClass('hide');
				}, 2000);
			}
		}
	})
}
</script>