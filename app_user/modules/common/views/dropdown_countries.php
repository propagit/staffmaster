<select name="<?=$field_name;?>" class="form-control auto-width custom-select" id="<?=$field_name;?>">
	<? foreach($countries as $country) { ?>
	<option value="<?=$country['code'];?>"<?=($field_value == $country['code']) ? ' selected' : '';?>><?=$country['name'];?></option>
	<? } ?>
</select>
