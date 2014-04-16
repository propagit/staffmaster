<form role="form" id="form_update_ts_breaks">
	<div id="list-breaks">
		<input type="hidden" name="timesheet_id" value="<?=$timesheet_id;?>" />
		<? if (count($breaks) > 0) foreach($breaks as $break) { ?>
		<div class="editable-breaks">
			<div class="wp_break_length">
				<div class="input-group">
					<input type="text" class="form-control input_number_only" name="break_length[]" value="<?=$break->length/60;?>" maxlength="3" size="5" /> 
					<span class="input-group-addon">minute(s)</span>
				</div>
			</div>
			<label class="control-label">Start At</label>
			<div class="wp_break_start_at">				
				<div class="input-group date break_start_at">
					<input type="text" class="form-control" name="break_start_at[]" readonly value="<?=date('d-m-Y H:i', $break->start_at);?>" />
					<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
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

<script>
$(function(){
	$('.break_start_at').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
        startDate: '<?=date('d-m-Y H:i', $timesheet['start_time']);?>',
        endDate: '<?=date('d-m-Y H:i', $timesheet['finish_time']);?>',
    });
})
</script>