<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-states" id="<?=$field_name;?>">
	<option value="">Select State</option>
	<? foreach($states as $state) { ?>
	<option value="<?=$state['code'];?>"<?=($field_value == $state['code']) ? ' selected' : '';?>><?=$state['name'];?></option>
	<? } ?>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-states');"><i class="fa fa-unsorted"></i></span>