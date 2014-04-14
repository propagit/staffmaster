<select name="<?=$field_name;?>" class="form-control select-sml push" id="<?=$field_name;?>">
	<option value="0">Select Department</option>
	<? foreach($departments as $dep) { ?>
	<option value="<?=$dep['user_clients_departments_id'];?>" <?=($field_value == $dep['user_clients_departments_id']) ? ' selected' : '';?>><?=$dep['department_name'];?></option>
	<? } ?>
</select>
<i class="fa fa-edit append-element-controls custom-hidden push"></i>
<i class="fa fa-trash-o append-element-controls custom-hidden push"></i>
