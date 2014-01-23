<form role="form" id="form_update_shift_breaks">
	<div id="list-breaks">
		<input type="hidden" name="shift_id" value="<?=$shift_id;?>" />
		<? if (count($breaks) > 0) foreach($breaks as $break) { ?>
		<div class="editable-breaks">
			<div class="wp_break_length">
				<div class="input-group">
					<input type="text" class="form-control input_number_only" name="break_length[]" value="<?=$break->length/60;?>" maxlength="3" /> 
					<span class="input-group-addon">min(s)</span>
				</div>
			</div>
			<label class="control-label">Start At</label>
			<div class="wp_break_start_at">
				<div class="input-group break_start_at">
					<input type="text" class="form-control" name="break_start_at[]" data-format="HH:mm" value="<?=date('H:i', $break->start_at);?>" />
					<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
				</div>
			</div>
		</div>
		<? } ?>		
	</div>
	<button type="button" class="btn btn-success btn-sm break-add">
		<i class="glyphicon glyphicon-plus"></i> Add break
	</button>
	<button type="button" class="btn btn-primary btn-sm break-submit">
		<i class="glyphicon glyphicon-ok"></i>
		</button>
	<button type="button" class="btn btn-default btn-sm break-cancel">
		<i class="glyphicon glyphicon-remove"></i>
	</button>
</form>