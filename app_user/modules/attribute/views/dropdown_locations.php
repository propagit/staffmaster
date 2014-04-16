<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Location</option>
	<? foreach($locations as $location) { ?>
	<option value="<?=$location['location_id'];?>"<?=($field_value == $location['location_id']) ? ' selected' : '';?>><?=$location['name'];?></option>
	<? } ?>
</select>