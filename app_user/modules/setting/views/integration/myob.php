<? if (!$this->config_model->get('myob_api_key') || !$this->config_model->get('myob_api_secret')) { ?>
<div class="alert alert-warning">
	Please contact system administrator to set up MYOB Integration
</div>

<? } else if ($this->config_model->get('myob_company_id') && modules::run('api/myob/test') == 'true') { ?>

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
	<? $employee = modules::run('api/myob/connect/search_employee'); ?>
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
			<span class="badge primary"><?=count($employee);?></span>
		</td>
		<td class="center">
			<a class="btn btn-core" id="btn-sync-staff">
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
			data: {myob_company_id : ''},
			success: function(html) {
				location.reload();
			}
		})
	})
})
</script>
	

<? } else { ?>
<a class="btn btn-myob" href="<?=base_url();?>api/myob/connect">Connect to MYOB</a>
<? } ?>

<? /*
<form role="form" id="form-myob">
<div class="form-group">
    <label for="myob_company_id" class="control-label">MYOB Company ID</label>    
	<input type="text" class="form-control" id="myob_company_id" name="myob_company_id" value="<?=$this->config_model->get('myob_company_id');?>" />
</div>         
        

<button type="button" class="btn btn-core" id="btn-update">Update</button> &nbsp;
</form>

<script>
$(function(){
	$('#btn-update').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: $('#form-myob').serialize(),
			success: function(html) {
				$('#msg-success').html('Updated successfully!');
				$('#msg-success').removeClass('hide');
				setTimeout(function(){
					location.reload();
				}, 2000);
			}
		})
	})
})
</script> */ ?>