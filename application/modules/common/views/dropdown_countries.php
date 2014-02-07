<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-country" id="<?=$field_name;?>">
	<? foreach($countries as $country) { ?>
	<option value="<?=$country['code'];?>"<?=($field_value == $country['code']) ? ' selected' : '';?>><?=$country['name'];?></option>
	<? } ?>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-country');"><i class="fa fa-unsorted"></i></span>