<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>">
	<? if ($title) { ?>
	<option value="">Please Select</option>
	<? } ?>
	<? foreach($data as $e) { ?>
	<option value="<?=$e['value'];?>"<?=($field_value === $e['value'] || $field_value == $e['label']) ? ' selected' : '';?>><?=$e['label'];?></option>
	<? } ?>
</select>

