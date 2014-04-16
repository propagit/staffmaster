<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Uniform</option>
	<? foreach($uniforms as $uniform) { ?>
	<option value="<?=$uniform['uniform_id'];?>"<?=($field_value == $uniform['uniform_id']) ? ' selected' : '';?>><?=$uniform['name'];?></option>
	<? } ?>
</select>