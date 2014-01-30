<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width">
	<option value="1"<?=($field_value=='1') ? ' selected' : '';?>>Assigned</option>
	<option value="2"<?=($field_value=='2') ? ' selected' : '';?>>Confirmed</option>
	<option value="3"<?=($field_value=='3') ? ' selected' : '';?>>Rejected</option>
</select>