<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group">
		<label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$field['label'];?></label>
		<div class="controls" onclick="edit_field(<?=$field['field_id'];?>)">
			<input name="<?=$field['field_id'];?>" class="input-file" type="file" disabled />
		</div>
		<input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>"  />
	</div>
</div>