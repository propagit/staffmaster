<input type="hidden" name="<?=$field_name;?>" />
<select class="form-control auto-width custom-select select-location_parent_id" id="location_parent_id" onchange="load_sub_locations()">
	<option value="">Please Select</option>
	<? foreach($parents as $parent) { 
		$locations = modules::run('attribute/location/get_locations', $parent['location_id']);
	?>
	<optgroup label="<?=$parent['name'];?>">
		<? foreach($locations as $location) { ?>
		<option value="<?=$location['location_id'];?>"<?=($field_value==$location['location_id']) ? ' selected' : '';?>><?=$location['name'];?></option>
		<? } ?>
	</optgroup>
	<? } ?>
</select>
<script>
$(function(){
	load_sub_locations();
})
function load_sub_locations() {
	var location_id = $('#location_parent_id').val();
	$('#location_parent_id').parent().find('input[name="<?=$field_name;?>"]').val(location_id);
}
</script>