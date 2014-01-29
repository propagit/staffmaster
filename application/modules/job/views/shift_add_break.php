<div class="editable-breaks">
	<div class="wp_break_length">
		<div class="input-group">
			<input type="text" class="form-control input_number_only" name="break_length[]" value="0" maxlength="3" size="5" /> 
			<span class="input-group-addon">minute(s)</span>
		</div>
	</div>
	<label class="control-label">Start At</label>
	<div class="wp_break_start_at">
		<div class="input-group date break_start_at">
			<input type="text" class="form-control" name="break_start_at[]" readonly />
			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
	</div>
</div>
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
        startDate: '<?=date('d-m-Y H:i', $shift['start_time']);?>',
        endDate: '<?=date('d-m-Y H:i', $shift['finish_time']);?>',
    });
})
</script>