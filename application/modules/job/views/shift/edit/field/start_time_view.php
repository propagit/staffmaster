<div class="row">
	<div class="form-group" id="f_edit_start_date">
		<label class="col-lg-3 control-label">Start Date/Time</label>
		<div class="col-lg-9">
			<div class="input-group date" id="edit_start_date">
				<input type="text" class="form-control" name="job_date" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-lg-3 col-lg-offset-3">
			<button type="button" class="btn btn-core" id="btn-edit-shifts"><i class="fa fa-save"></i> Update All</button>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#edit_start_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 0,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
        //startDate: "<?=date('Y-m-d');?>"
    });
})
</script>