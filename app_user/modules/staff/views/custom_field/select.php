<div class="form-group">
    <label class="col-md-2 control-label"><?=$field['label'];?></label>
    <div class="col-md-4">
   		<select name="fields[<?=$field['field_id'];?>]<?=($field['multiple'] == 'true' ? '[]' : '');?>" class="form-control" <?=($field['multiple'] == 'true' ? 'multiple="multiple"' : '');?>>
   			<? $value = $field['staff_value'];
   			if ($field['multiple'] != "true") { ?>
   			<option value="">Select One</option>
   			<? } else { $value = json_decode($value);  } ?>
			<? $attrs = json_decode($field['attributes']);
			if($attrs) {
				foreach($attrs as $attr) { 
					$selected = '';
					if($field['multiple'] == "true") {
						if(in_array($attr, $value)){
                        	$selected = 'selected="selected"';
                        }
					} else { # Single value
						if($attr == $value) {
							$selected = 'selected="selected"';	
						}
					}
				?>
			<option value="<?=$attr;?>" <?=$selected;?>><?=$attr;?></option>
			<? }
			} ?>
		</select>
	</div>
</div>