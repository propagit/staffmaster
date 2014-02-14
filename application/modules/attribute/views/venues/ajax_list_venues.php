 <table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left col-md-2">Venue Name <i class="fa fa-sort sort-table" sort-by="attribute_venues.name"></i></th>
        <th class="left col-md-3">Address</th>
        <th class="left col-md-1">Suburb <i class="fa fa-sort sort-table" sort-by="attribute_venues.suburb"></i></th>
        <th class="center col-md-1">Post Code <i class="fa fa-sort sort-table" sort-by="attribute_venues.postcode"></i></th>
        <th class="left col-md-2">Location <i class="fa fa-sort sort-table" sort-by="attribute_locations.name"></i></th>
        <th class="center col-md-1">View Map</th>
        <th class="center col-md-1">Edit Venue</th>
        <th class="center col-md-1">Delete Venue</th>
    </tr>
    </thead>
    <tbody>
        <? foreach($venues as $venue) { ?>
        <tr>
            <td class="left"><?=$venue['name'];?></td>
            <td class="left"><?=$venue['address'];?></td>
            <td class="left"><?=$venue['suburb'];?></td>
            <td class="center"><?=$venue['postcode'];?></td>
            <td class="left"><?=modules::run('attribute/location/display_location', $venue['location_id']);?></td>
            <td class="center"><a data-toggle="modal" data-target=".venue-map" href="<?=base_url();?>common/ajax/load_venue_map/<?=$venue['venue_id'];?>"><i class="fa fa-map-marker"></i></a></td>
            <td class="center"><a class="edit-venue" edit-data-venue-id="<?=$venue['venue_id'];?>" edit-data-location-id="<?=$venue['location_id'];?>" edit-data-location-parent-id="<?=$venue['location_parent_id']?>" edit-data-venue-name="<?=$venue['name'];?>" edit-data-venue-address="<?=$venue['address'];?>" edit-data-venue-suburb="<?=$venue['suburb']?>"  edit-data-venue-postcode="<?=$venue['postcode'];?>"><i class="fa fa-pencil"></i></a></td>
            <td class="center"><a class="delete-venue" delete-data-id="<?=$venue['venue_id'];?>"><i class="fa fa-times"></i></a></td>
        </tr>
        <? } ?>
    </tbody>
</table>
<!--end bottom box -->
<div class="modal fade venue-map" tabindex="-1" role="dialog" aria-hidden="true">

</div><!-- /.modal -->

<script>
$(function(){
	
	//sort data
	help.sort_list('.sort-table',params);
	
	$('.edit-venue').on('click',function(){
		var venue_id = $(this).attr('edit-data-venue-id');
		var location_id = $(this).attr('edit-data-location-id');
		var location_parent_id = $(this).attr('edit-data-location-parent-id');
		var venue_name = $(this).attr('edit-data-venue-name');
		var venue_address = $(this).attr('edit-data-venue-address');
		var venue_suburb = $(this).attr('edit-data-venue-suburb');
		var venue_postcode = $(this).attr('edit-data-venue-postcode');
		open_edit_modal(venue_id,location_id,location_parent_id,venue_name, venue_address, venue_suburb, venue_postcode);
	});
	
	$('.delete-venue').on('click',function(){
		var title = 'Delete Venue';
		var message ='Are you sure you would like to delete this "Venue"';
		var venue_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_venue(venue_id);
				 help.load_content(params);
			 }
		});
	});
});
</script>