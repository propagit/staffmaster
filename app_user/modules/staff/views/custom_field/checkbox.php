<div class="form-group">
    <label class="col-md-2 control-label"><?=$field['label'];?></label>
    <div class="col-md-10">
   	<?php
   		$attrs = json_decode($field['attributes']);
   		$values = array();
   		if ($field['staff_value']) {
	   		$values = json_decode($field['staff_value']);
   		}
		if ($attrs) {
			foreach($attrs as $attr){ ?>
			<label class="checkbox <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
				<input type="checkbox" name="fields[<?=$field['field_id'];?>][]" value="<?=$attr;?>" <?=(in_array($attr, $values)) ? ' checked' : '';?>	/> <?=$attr;?>
			</label>
	<?php 	}
		} ?>
    </div>
</div>