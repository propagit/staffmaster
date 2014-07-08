<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>">
	<? foreach($templates as $template) { ?>
	<option value="<?=$template['export_id'];?>"><?=$template['name'];?></option>
	<? } ?>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-<?=$field_name;?>');"><i class="fa fa-unsorted"></i></span>