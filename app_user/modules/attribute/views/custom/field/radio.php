<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group" >
		<div class="btn-delete-field" onclick="delete_field(<?=$field['field_id'];?>)">
			<span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>
		</div>
		<label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$field['label'];?></label>
		<div class="controls" onclick="edit_field(<?=$field['field_id'];?>)">
		<?php
			$attrs = json_decode($field['attributes']);
			if ($attrs) {
				foreach($attrs as $attr) { ?>
				<label class="radio <?=($field['inline'] == 'true') ? 'inline' : '';?>">
					<input type="radio" name="<?=$field['field_id'];?>" value="<?=$attr;?>"> <?=$attr;?>
				</label>
				<?php }			
			}
		?>
		</div>
		<input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>" />		
	</div>
</div>