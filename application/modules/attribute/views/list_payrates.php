<h2>Pay Rates</h2>

<p>Manage your pay rates attribute.</p>

<a data-toggle="modal" href="#addPayrate" ><i class="icon-plus-sign"></i> Add Pay Rate</a>
<br /><br />


<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">Name <a href="<?=base_url();?>attribute/payrate/sort"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center">Staff Rate<!--  <a href="#"><i class="icon-sort-by-alphabet"></i></a> --></td>
		<td class="center">Client Rate<!--  <a href="#"><i class="icon-sort-by-alphabet"></i></a> --></td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
		<!-- <td class="center"><i class="icon-time"></i> Status</td> -->
		<!-- <td class="center"><i class="icon-check"></i> Check</td> -->
	</tr>
	</thead>
	<? foreach($payrates as $payrate) { ?>
	<tr>
		<td class="left"><?=$payrate['name'];?></td>
		<td class="center">$<?=$payrate['staff_rate'];?></td>
		<td class="center">$<?=$payrate['client_rate'];?></td>
		<td class="center"><a href="javascript:edit_payrate(<?=$payrate['payrate_id'];?>,'<?=$payrate['name'];?>',<?=$payrate['staff_rate'];?>,<?=$payrate['client_rate'];?>)"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="javascript:delete_payrate(<?=$payrate['payrate_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
		<!-- <td class="center"><?=($payrate['status'] == 1) ? 'Active' : 'Inactive';?></td> -->
		<!-- <td class="center"><input type="checkbox" /></td> -->
	</tr>
	<? } ?>
</table>

<!-- Add Payrate Modal -->
<div class="modal fade" id="addPayrate" tabindex="-1" role="dialog" aria-labelledby="addPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Pay rate</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/payrate/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter pay rate name">
				</div>
				<div class="form-group">
					<label for="staff_rate">Staff Rate</label>
					<input type="text" class="form-control" name="staff_rate" id="staff_rate" />
				</div>
				<div class="form-group">
					<label for="client_rate">Client Rate</label>
					<input type="text" class="form-control" name="client_rate" id="client_rate" />
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Payrate Modal -->
<div class="modal fade" id="editPayrate" tabindex="-1" role="dialog" aria-labelledby="editPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Pay rate</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/payrate/edit">
			<input type="hidden" name="payrate_id" id="payrate_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter pay rate name">
				</div>
				<div class="form-group">
					<label for="staff_rate_edit">Staff Rate</label>
					<input type="text" class="form-control" name="staff_rate" id="staff_rate_edit" />
				</div>
				<div class="form-group">
					<label for="client_rate_edit">Client Rate</label>
					<input type="text" class="form-control" name="client_rate" id="client_rate_edit" />
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
function delete_payrate(payrate_id)
{
	if(confirm('Are you sure you want to delete this pay rate?'))
	{
		window.location = '<?=base_url();?>attribute/payrate/delete/' + payrate_id;
	}
}
function edit_payrate(payrate_id, name, staff_rate, client_rate)
{
	$('#payrate_id').val(payrate_id);
	$('#name_edit').val(name);
	$('#staff_rate_edit').val(staff_rate);
	$('#client_rate_edit').val(client_rate);
	$('#editPayrate').modal('show');
}
</script>