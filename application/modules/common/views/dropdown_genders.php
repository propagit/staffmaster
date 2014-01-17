<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width">
	<option value="">Select Gender</option>
	<option value="m"<?=($field_value=='m') ? ' selected' : '';?>>Male</option>
	<option value="f"<?=($field_value=='f') ? ' selected' : '';?>>Female</option>
</select>