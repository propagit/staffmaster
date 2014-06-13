<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group">
		<div class="btn-delete-field" onclick="delete_field(<?=$field['field_id'];?>)">
			<span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>
		</div>
		<label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$field['label'];?></label>
		<div class="controls" onclick="edit_field(<?=$field['field_id'];?>)">
			<select name="<?=$field['field_id'];?>" class="form-control" <?=($field['multiple'] == 'true' ? 'multiple="multiple"' : '');?>>
			<?php
				$attrs = json_decode($field['attributes']);
				if ($attrs) {
					foreach ($attrs as $attr) { ?>
					<option value="<?=$attr;?>"><?=$attr;?></option>
					<?php }			
				}
			?>
			</select>
		</div>
		<input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>" />
	</div>
</div>
<script>
$(function(){
	init_select();
})
</script>