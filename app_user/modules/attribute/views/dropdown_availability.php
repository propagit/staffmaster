<select name="<?=$field_name;?>" class="form-control auto-width" id="<?=$field_name;?>">
	<option value="">Select Availability</option>
	<? foreach($availability as $one) { ?>
	<option value="<?=$one['availability_id'];?>"<?=($field_value == $one['availability_id']) ? ' selected' : '';?>><?=$one['name'];?></option>
	<? } ?>
</select>