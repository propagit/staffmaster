<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>" onchange="load_areas()">
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
<span class="input-group-addon select-addon" onclick="help.open_select('.select-<?=$field_name;?>');"><i class="fa fa-unsorted"></i></span>

<div class="wp_field_select_areas"></div>
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
		data: {location_id: location_id,child_selected:<?=($child_value != '' ? $child_value : 0);?>},
		success: function(html) {
			if (html) {
				$('#<?=$field_name;?>').css('margin-bottom', '15px');
			} else {
				$('#<?=$field_name;?>').css('margin-bottom', '0');
			}
			$('.wp_field_select_areas').html(html);
		}
	});
}
</script>