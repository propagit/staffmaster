<div class="row" id="field_<?=$field['field_id'];?>">
	<div class="form-group" >
		<label class="col-md-2 control-label"><?=$field['label'];?></label>
		<div class="col-md-4">
		<?php
			$attrs = json_decode($field['attributes']);
			if ($attrs) {
				foreach($attrs as $attr) { ?>
				<label class="radio <?=($field['inline'] == 'true') ? 'custom-inline' : '';?>">
					<input type="radio" name="custom_search_<?=$field['field_id'];?>" value="<?=$attr;?>"> <?=$attr;?>
				</label>
				<?php }			
			}
		?>
		</div>	
	</div>
</div>
