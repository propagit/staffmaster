<select name="<?=$field_name;?>" class="form-control auto-width" id="<?=$field_name;?>">
	<option value="">Select State</option>
	<? foreach($states as $state) { ?>
	<option value="<?=$state['code'];?>"<?=($field_value == $state['code']) ? ' selected' : '';?>><?=$state['name'];?></option>
	<? } ?>
</select>