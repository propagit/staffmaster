<div class="row" id="field_<?=$field['field_id'];?>">
	<div class="form-group" type="textinput">
		<label class="col-md-2 control-label"><?=$field['label'];?></label>
		<div class="col-md-10">
			<input id="textinput" name="custom_search_<?=$field['field_id'];?>" type="text" placeholder="<?=$field['placeholder'];?>" class="form-control" onclick="edit_field(<?=$field['field_id'];?>)" />
		</div>
	</div>
</div>
