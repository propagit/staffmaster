<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Time Sheet</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body" id="modal-timesheet">
			<div class="col-right">
				<h4>Staff Details</h4>
				
				<br /><br /><br /><br /><br /><br /><br /><br /><br />
				
				<h4>Expenses</h4>
			</div>
			<div class="col-left">
				<h4>Time Sheet Details</h4>
				<form class="form-horizontal" role="form" id="form_create_js">
				<div class="form-group" id="f_start_date">
					<label class="col-lg-4 control-label">Start Date/Time</label>
					<div class="col-lg-8">
						<div class="input-group date" id="start_date">
							<input type="text" class="form-control" name="job_date" value="<?=date('d-m-Y H:i', $timesheet['start_time']);?>" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
				
				<div class="form-group" id="f_finish_time">
					<label class="col-lg-4 control-label">Finish Date/Time</label>
					<div class="col-lg-8">
						<div class="input-group date" id="finish_time">
							<input type="text" class="form-control" name="finish_time" value="<?=date('d-m-Y H:i', $timesheet['finish_time']);?>" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
				
				<? $breaks = json_decode($timesheet['break_time']);
				foreach($breaks as $break) { ?>
				<div class="form-group">
					<label class="col-lg-4 control-label">Break Length</label>
					<div class="col-lg-5">
						<div class="input-group date">
							<input type="text" class="form-control input_number_only" value="<?=$break->length/60;?>" name="break_length" value="0" maxlength="3" />
							<span class="input-group-addon">minute(s)</span>
						</div>
					</div>
				</div>
				
				<div class="form-group" id="f_break_start_at">
					<label class="col-lg-4 control-label">Break Start At</label>
					<div class="col-lg-8">
						<div class="input-group date" id="break_start_time_<?=$break->start_at;?>">
							<input type="text" class="form-control" name="break_start_at" value="<?=date('d-m-Y H:i', $break->start_at);?>" readonly />
							<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
				<? } ?>
					
				<div class="form-group" id="f_venue">
					<label for="venue" class="col-lg-4 control-label">Venue</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/venue/field_input', 'venue', $timesheet['venue_id']);?>
					</div>
				</div>
				<div class="form-group">
					<label for="position" class="col-lg-4 control-label">Role</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/role/field_select', 'role_id', $timesheet['role_id']);?>
					</div>
				</div>
				<div class="form-group">
					<label for="uniform_id" class="col-lg-4 control-label">Uniform</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/uniform/field_select', 'uniform_id', $timesheet['uniform_id']);?>
					</div>
				</div>
				
				<div class="form-group">
					<label for="payrate" class="col-lg-4 control-label">Payrate</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/payrate/field_select', 'payrate_id', $timesheet['payrate_id']);?>
					</div>
				</div>
				
				<div class="form-group">
					<label for="supervisor_id" class="col-lg-4 control-label">Supervisor</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" name="supervisor_id" id="supervisor_id" />
					</div>
				</div>	
				
				<div class="form-group">
					<div class="col-lg-offset-4 col-lg-8">
						<a class="btn btn-core" id="btn_create_js"><i class="fa fa-pencil-square-o"></i> Update</a>
					</div>
				</div>	
				</form>
			</div>
			</div>	
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#start_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii'
    }).on('changeDate', function(e) {
    	var start_date = moment(e.date.valueOf() - 11*60*60*1000);
    	var finish_date = $('input[name="finish_time"]').val();
    	if (start_date > moment(finish_date, "DD-MM-YYYY HH:mm"))
    	{
	    	$('input[name="finish_time"]').val(start_date.format("DD-MM-YYYY HH:mm"));
    	}
    	$('#finish_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
    	$('div[id^=break_start_time]').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
    });
    $('#finish_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
    }).on('changeDate', function(e) {
    	var finish_date = moment(e.date.valueOf() - 11*60*60*1000);
    	$('div[id^=break_start_time]').datetimepicker('setEndDate', finish_date.format("DD-MM-YYYY HH:mm"));
    });
    $('div[id^=break_start_time]').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
    });
    
    
    
})
</script>