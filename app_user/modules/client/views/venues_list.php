<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
    	<th width="40" class="center"><input type="checkbox" name="check_all" /></th>
        <th class="left col-md-3">Venue Name <i class="fa fa-sort sort-table" sort-by="attribute_venues.name"></i></th>
        <th class="left">Address</th>
        <th class="left col-md-2">Suburb <i class="fa fa-sort sort-table" sort-by="attribute_venues.suburb"></i></th>
        <th class="center col-md-1">Post Code <i class="fa fa-sort sort-table" sort-by="attribute_venues.postcode"></i></th>
        <th class="center col-md-1">View Map</th>
    </tr>
    </thead>
    <tbody>
        <? foreach($venues as $venue) { $checked = ($venue['is_restricted'] == NULL) ? 'checked' : ''; ?>
        <tr>
        	<td class="center"><input type="checkbox" name="venue_id" value="<?=$venue['venue_id'];?>" <?=$checked;?> /></td>
            <td class="left"><?=$venue['name'];?></td>
            <td class="left"><?=$venue['address'];?></td>
            <td class="left"><?=$venue['suburb'];?></td>
            <td class="center"><?=$venue['postcode'];?></td>
            <td class="center"><a data-toggle="modal" data-target=".venue-map" href="<?=base_url();?>common/ajax/load_venue_map/<?=$venue['venue_id'];?>"><i class="fa fa-map-marker"></i></a></td>
        </tr>
        <? } ?>
    </tbody>
</table>

<!--end bottom box -->
<div class="modal fade venue-map" tabindex="-1" role="dialog" aria-hidden="true">

</div><!-- /.modal -->
<script>
$(function(){
	$('input[type="checkbox"][name="venue_id"]').click(function(){
		var venue_id = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/restrict_venue",
			data: {user_id: <?=$user_id;?>, venue_id: venue_id},
			success: function(html) { }
		})
	})
	$('input[type="checkbox"][name="check_all"]').click(function(){
		var check_all = $(this).is(':checked');
		preloading($('#list-client-venues'));
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/unrestrict_all",
			data: {user_id: <?=$user_id;?>, unrestrict_all: check_all},
			success: function(html) {
				$('input[type="checkbox"][name="venue_id"]').attr('checked', check_all);
				loaded($('#list-client-venues'));
			}
		})
	})
})
</script>