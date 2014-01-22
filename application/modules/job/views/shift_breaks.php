<input type="hidden" name="shift_id" value="<?=$shift_id;?>" />
<? foreach($breaks as $break) { ?>
<div class="editable-breaks">
	<div class="break_length">
		<div class="input-group">
			<input type="text" class="form-control input_number_only" name="break_length[]" value="<?=$break->length/60;?>" maxlength="3" /> 
			<span class="input-group-addon">min(s)</span>
		</div>
	</div>
	<div class="break_start_at">
		<div class="input-group break_start_at">
			<input type="text" class="form-control" name="break_start_at[]" data-format="HH:mm" value="<?=date('H:i', $break->start_at);?>" />
			<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
		</div>
	</div>
</div>
<? } ?>