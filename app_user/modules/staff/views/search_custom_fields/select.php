<div class="row" id="field_<?=$field['field_id'];?>">
	<div class="form-group">
		<label class="col-md-2 control-label"><?=$field['label'];?></label>
		<div class="col-md-4">
			<select name="custom_search_<?=$field['field_id'];?>" class="form-control" <?=($field['multiple'] == 'true' ? 'multiple="multiple"' : '');?>>
            <option value="0">All</option>
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
	</div>
</div>