<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>">
	<option value="0">All Groups</option>
	<? foreach($data as $e) { ?>
	<option value="<?=$e['value'];?>"<?=($field_value === $e['value']) ? ' selected' : '';?>><?=$e['label'];?></option>
	<? } ?>
</select>
<?php if(1){ ?>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-<?=$field_name;?>');"><i class="fa fa-unsorted"></i></span>
<?php } ?>