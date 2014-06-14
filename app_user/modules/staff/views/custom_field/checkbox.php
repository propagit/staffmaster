<div class="form-group">
    <label class="col-md-2 control-label"><?=$field['label'];?></label>
    <div class="col-md-10">
   	<?php
   		$attrs = json_decode($field['attributes']);
		#print_r($attrs);
   		$values = array();
   		if ($field['staff_value']) {
	   		$values = json_decode($field['staff_value']);
   		}
		#print_r($values);
		if ($attrs) {
			foreach($attrs as $attr){ ?>
			<label class="checkbox <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
				<input type="checkbox" name="fields[<?=$field['field_id'];?>][]" value="<?=$attr;?>" <?=(in_array($attr, $values)) ? 'checked="checked"' : '';?>	/> <?=$attr;?>
			</label>
	<?php 	}
		} ?>
    </div>
</div>