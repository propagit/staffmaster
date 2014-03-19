<select name="<?=$field_name;?>" class="form-control auto-width custom-select select-<?=$field_name;?>" id="<?=$field_name;?>">
	<option value="">Please Select Template</option>
	<optgroup label="Single">
		<? foreach($single as $template) { ?>
		<option value="<?=$template['export_id'];?>">Single - <?=$template['name'];?></option>
		<? } ?>
	</optgroup>
	<optgroup label="Batched">		
		<? foreach($batched as $template) { ?>
		<option value="<?=$template['export_id'];?>">Batched - <?=$template['name'];?></option>
		<? } ?>
	</optgroup>
</select>
<span class="input-group-addon select-addon" onclick="help.open_select('.select-<?=$field_name;?>');"><i class="fa fa-unsorted"></i></span>