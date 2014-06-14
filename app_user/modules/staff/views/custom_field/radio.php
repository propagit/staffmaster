<div class="form-group">
	<label class="col-md-2 control-label"><?=$field['label'];?></label>
	<div class="col-md-10">
	<?php
	   	$attrs = json_decode($field['attributes']);
		if($attrs){
			foreach($attrs as $attr){ ?>
			<label class="radio <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
				<input type="radio" name="fields[<?=$field['field_id'];?>]" value="<?=$attr;?>" <?=($attr == $field['staff_value']) ? 'checked="checked"' : '';?> />	<?=$attr;?>
			</label>
	<?php 	}
		} ?>
	</div>
</div>