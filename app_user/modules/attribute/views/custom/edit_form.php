<div class="arrow"></div>
<h3 class="popover-title"><?=ucwords($field['type']);?></h3>
<form id="update-field-form">
<input type="hidden" name="field_id" value="<?=$field['field_id'];?>" />
<div class="popover-content">
	<div class="controls">
    	<?php
			# new file with date field added on 29 May, 2015
			if($field['type'] == 'fileDate'){
			$label = json_decode($field['label']);
		?>
        <input type="hidden" name="fileDate" value="1" />
       	<label class="control-label">File Label</label>
        <input class="form-control" type="text" name="file_label" value="<?=$label->file_label;?>" /> 
        
        <label class="control-label">Date Label</label>
        <input class="form-control" type="text" name="date_label" value="<?=$label->date_label;?>" /> 
        
        <label class="control-label">Date Placeholder</label>
        <input class="form-control" type="text" name="placeholder" value="<?=$field['placeholder'];?>" />
        <?php		
			}else{
		?>
    	
            <label class="control-label">Label</label>
            <input class="form-control" type="text" name="label" value="<?=$field['label'];?>" />
            <? if($field['type'] == 'text') { ?>
            <label class="control-label">Placeholder</label>
            <input class="form-control" type="text" name="placeholder" value="<?=$field['placeholder'];?>" />
            <? } ?>
            
            <? if( in_array($field['type'], array('radio','checkbox', 'select'))) { ?>
            <label class="control-label">Options</label>
            <textarea class="form-control" name="attributes" rows="4"><?
                $attrs = json_decode($field['attributes']);
                if ($attrs) {
                    foreach($attrs as $attr) { echo $attr . "\n"; }			
                }
            ?></textarea>
            <? } ?>
        
        <?php } # end fileDate else ?>
        
        
		<div class="clearfix"></div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="admin_only" <?=($field['admin_only']) ? 'checked' : '';?> /> Admin only
			</label>
		</div>
		<hr>
		<button class="btn btn-info" type="button" id="btn-update-field">Save</button>
		<button class="btn btn-danger" type="button" id="btn-close-popover">Cancel</button>
	</div>
</div>
</form>

<script>
$(function(){
	$('#btn-update-field').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax_custom/update_field",
			data: $('#update-field-form').serialize(),
			success: function(html) {
				$('.popover').hide();
				load_custom_fields();
			}
		})
	})
	$('#btn-close-popover').click(function(){
		$('.popover').hide();
	})
})
</script>