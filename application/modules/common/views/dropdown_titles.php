<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width">
	<option value="Mr"<?=($field_value=='Mr') ? ' selected' : '';?>>Mr</option>
	<option value="Miss"<?=($field_value=='Miss') ? ' selected' : '';?>>Miss</option>
	<option value="Mrs"<?=($field_value=='Mrs') ? ' selected' : '';?>>Mrs</option>
</select>