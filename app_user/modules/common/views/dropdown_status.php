<select name="<?=$field_name;?>" class="form-control auto-width" id="<?=$field_name;?>">
	<option value="">Select Status</option>
	<option value="1">Active</option>
	<option value="0"<?=($field_value === 0) ? ' selected' : '';?>>Inactive</option>
</select>