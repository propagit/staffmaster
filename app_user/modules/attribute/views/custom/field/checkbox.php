<div class="push dropped" id="field_<?=$field['field_id'];?>">
	<div class="control-group">
		<label class="control-label" onclick="edit_field(<?=$field['field_id'];?>)"><?=$field['label'];?></label>
		<div class="controls" onclick="edit_field(<?=$field['field_id'];?>)">
		<?php
			$attrs = json_decode($field['attributes']);
			if ($attrs) {
				foreach($attrs as $attr) { ?>
				<label class="checkbox <?=($field['inline'] == 'true' ? 'inline' : '' );?>">
					<input type="checkbox" name="<?=$field['field_id'];?>" value="<?=$attr;?>"><?=$attr;?>
				</label>
				<?php }
			}
		?>
		</div>
		<input class="sort-index" type="hidden" value="<?=$field['field_order'];?>" data="<?=$field['field_id'];?>" />
	</div>
</div>