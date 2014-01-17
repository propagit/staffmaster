<h2>Venues</h2>

<p>Manage your venues attribute.</p>

<a data-toggle="modal" href="#addVenue" ><i class="icon-plus-sign"></i> Add Venue</a>
<br /><br />


<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">Name <a href="<?=base_url();?>attribute/venue/sort"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="left">Address</td>
		<td class="left">Location</td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
	</tr>
	</thead>
	<? foreach($venues as $venue) { ?>
	<tr>
		<td class="left"><?=$venue['name'];?></td>
		<td class="left"><?=$venue['address'] . ', ' . $venue['suburb'] . ' ' . $venue['postcode'];?></td>
		<td class="left"><?=modules::run('attribute/location/display_location', $venue['location_id']);?></td>
		<td class="center"><a href="javascript:edit_venue(<?=$venue['venue_id'];?>,<?=$venue['location_id'];?>,'<?=$venue['name'];?>','<?=$venue['address'];?>','<?=$venue['suburb'];?>', '<?=$venue['postcode'];?>')"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="javascript:delete_venue(<?=$venue['venue_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
	</tr>
	<? } ?>
</table>

<!-- Add Venue Modal -->
<div class="modal fade" id="addVenue" tabindex="-1" role="dialog" aria-labelledby="addVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Venue</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/venue/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter venue name">
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" class="form-control" name="address" id="address" placeholder="Enter venue address">
				</div>
				<div class="form-group">
					<label for="suburb">Suburb</label>
					<input type="text" class="form-control" name="suburb" id="suburb" placeholder="Enter venue suburb">
				</div>
				<div class="form-group">
					<label for="postcode">Postcode</label>
					<input type="text" class="form-control auto-width" name="postcode" id="postcode" placeholder="Enter venue postcode">
				</div>
				<div class="form-group">
					<label>Location</label>
					<?=modules::run('attribute/location/dropdown', 'location_id');?>
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

<!-- Edit Venue Modal -->
<div class="modal fade" id="editVenue" tabindex="-1" role="dialog" aria-labelledby="editVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Venue</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/venue/edit">
			<input type="hidden" name="venue_id" id="venue_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter venue name" />
				</div>
				<div class="form-group">
					<label>Location</label>
					<?=modules::run('attribute/location/dropdown', 'location_id_edit');?>
				</div>
				<div class="form-group">
					<label for="address_edit">Address</label>
					<input type="text" class="form-control" name="address" id="address_edit" placeholder="Enter venue address">
				</div>
				<div class="form-group">
					<label for="suburb_edit">Suburb</label>
					<input type="text" class="form-control" name="suburb" id="suburb_edit" placeholder="Enter venue suburb">
				</div>
				<div class="form-group">
					<label for="postcode_edit">Postcode</label>
					<input type="text" class="form-control auto-width" name="postcode" id="postcode_edit" placeholder="Enter venue postcode">
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
function delete_venue(venue_id)
{
	if(confirm('Are you sure you want to delete this venue?'))
	{
		window.location = '<?=base_url();?>attribute/venue/delete/' + venue_id;
	}
}
function edit_venue(venue_id,location_id, name, address, suburb, postcode)
{
	$('#venue_id').val(venue_id);
	$('#location_id_edit').val(location_id);
	$('#name_edit').val(name);
	$('#address_edit').val(address);
	$('#suburb_edit').val(suburb);
	$('#postcode_edit').val(postcode);
	$('#editVenue').modal('show');
}
</script>