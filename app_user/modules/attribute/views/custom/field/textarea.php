<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group" type="textarea">
		<div class="btn-delete-field" onclick="delete_field(<?=$field['field_id'];?>)">
			<span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>
		</div>
		<label class="control-label" id="textarea-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$field['label'];?></label>
		<div class="controls">                     
			<textarea id="textarea" name="<?=$field['field_id'];?>" class="form-control" onclick="edit_field(<?=$field['field_id'];?>)"></textarea>
		</div>
		<input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>" />
	</div>
</div>