<h2>Locations</h2>

<p>Manage your locations attribute.</p>

<a data-toggle="modal" href="#addLocation" ><i class="icon-plus-sign"></i> Add Location</a>
<br /><br />


<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">State <a href="<?=base_url();?>attribute/location/sort/state"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="left">Location <a href="<?=base_url();?>attribute/location/sort/name"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
		<!-- <td class="center"><i class="icon-check"></i> Check</td> -->
	</tr>
	</thead>
	
</table>


<!-- Add Location Modal -->
<div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocationLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Location</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/location/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter location name">
				</div>
				<div class="form-group">
					<label for="name">State</label>
					<?=modules::run('common/dropdown_states', 'state');?>
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

<!-- Edit Location Modal -->
<div class="modal fade" id="editLocation" tabindex="-1" role="dialog" aria-labelledby="editLocationLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Location</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/location/edit">
			<input type="hidden" name="location_id" id="location_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter department name">
				</div>
				<div class="form-group">
					<label for="name">State</label>
					<?=modules::run('common/dropdown_states', 'state_edit');?>
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
function delete_location(location_id)
{
	if(confirm('Are you sure you want to delete this location?'))
	{
		window.location = '<?=base_url();?>attribute/location/delete/' + location_id;
	}
}
function edit_location(location_id, name, state)
{
	$('#location_id').val(location_id);
	$('#name_edit').val(name);
	$('#state_edit').val(state);
	$('#editLocation').modal('show');
}
</script>