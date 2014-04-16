<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Department</option>
	<? foreach($departments as $department) { ?>
	<option value="<?=$department['department_id'];?>"<?=($field_value == $department['department_id']) ? ' selected' : '';?>><?=$department['name'];?></option>
	<? } ?>
</select>