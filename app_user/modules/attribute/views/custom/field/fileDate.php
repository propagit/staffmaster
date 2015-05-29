<?php
	$label = json_decode($field['label']);
	#print_r($label);
	#exit;
?>
<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group">
		<div class="btn-delete-field" onclick="delete_field(<?=$field['field_id'];?>)">
			<span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>
		</div>
		<label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$label->file_label;?></label>
		<div class="controls" onclick="edit_field(<?=$field['field_id'];?>)">
			<input name="<?=$field['field_id'];?>" class="input-file" type="file" disabled />
		</div>
	</div>
    
    <div class="control-group push">
          <label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$label->date_label;?></label>
          <div class="form-group col-sm-6 remove-gutters" onclick="edit_field(<?=$field['field_id'];?>)">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Date">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
          </div>
      </div>
      <input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>" />
</div>