<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width custom-select select-gender">
	<option value="">Select Gender</option>
	<option value="m"<?=($field_value=='m') ? ' selected' : '';?>>Male</option>
	<option value="f"<?=($field_value=='f') ? ' selected' : '';?>>Female</option>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-gender');"><i class="fa fa-unsorted"></i></span>