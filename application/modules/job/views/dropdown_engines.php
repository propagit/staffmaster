<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width">
	<option value="Manual"<?=($field_value=='Manual') ? ' selected' : '';?>>Manual</option>
	<option value="Auto"<?=($field_value=='Auto') ? ' selected' : '';?>>Auto</option>
	<option value="Import"<?=($field_value=='Import') ? ' selected' : '';?>>Import</option>
</select>