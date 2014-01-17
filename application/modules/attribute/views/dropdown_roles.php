<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Role</option>
	<? foreach($roles as $role) { ?>
	<option value="<?=$role['role_id'];?>"<?=($field_value == $role['role_id']) ? ' selected' : '';?>><?=$role['name'];?></option>
	<? } ?>
</select>