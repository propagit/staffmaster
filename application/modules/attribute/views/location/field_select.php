<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>" onchange="load_areas()">
	<option value="">Please Select</option>
	<? foreach($parents as $parent) { 
		$locations = modules::run('attribute/location/get_locations', $parent['location_id']);
	?>
	<optgroup label="<?=$parent['name'];?>">
		<? foreach($locations as $location) { ?>
		<option value="<?=$location['location_id'];?>"><?=$location['name'];?></option>
		<? } ?>
	</optgroup>
	<? } ?>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-<?=$field_name;?>');"><i class="fa fa-unsorted"></i></span>

<div id="wp_field_select_areas"></div>

<script>
$(function(){
	load_areas();
})
function load_areas()
{
	var location_id = $('#<?=$field_name;?>').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>attribute/ajax/get_locations",
		data: {location_id: location_id},
		success: function(html) {
			$('#wp_field_select_areas').html(html);
		}
	})
}
</script>