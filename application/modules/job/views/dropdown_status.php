<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control">
	<option value="Assigned"<?=($field_value=='0') ? ' selected' : '';?>>Assigned</option>
	<option value="Confirmed"<?=($field_value=='1') ? ' selected' : '';?>>Confirmed</option>
	<option value="Rejected"<?=($field_value=='-1') ? ' selected' : '';?>>Rejected</option>
</select>