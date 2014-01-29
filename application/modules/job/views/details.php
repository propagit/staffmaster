<h2><?= $job['name']; ?>  
<small><?= $client['company_name']; ?></small></h2>
<br />
<div class="row">
	<div class="col-md-6">
		<h4>Create Job Shifts</h4>
		<p>Create a job via the below form. Jobs can be duplicated to other days. Jobs created will be viewable in the weeks schedule to the right. The weeks shifts and the entire campaign can be duplicated.</p>
		<div class="panel panel-default">
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="form_create_js">
					<input type="hidden" name="job_id" value="<?=$job['job_id'];?>" />
					<div class="form-group" id="f_start_date">
						<label class="col-lg-4 control-label">Start Date/Time</label>
						<div class="col-lg-8">
							<div class="input-group date" id="start_date">
								<input type="text" class="form-control" name="job_date" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					
					<div class="form-group" id="f_finish_time">
						<label class="col-lg-4 control-label">Finish Date/Time</label>
						<div class="col-lg-8">
							<div class="input-group date" id="finish_time">
								<input type="text" class="form-control" name="finish_time" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					
					
					<div class="form-group" id="f_break_start_at">
						<label class="col-lg-4 control-label">Break Length</label>
						<div class="col-lg-4">
							<div class="input-group date">
								<input type="text" class="form-control input_number_only" name="break_length" value="0" maxlength="3" />
								<span class="input-group-addon">minute(s)</span>
							</div>
						</div>
					</div>
					
					<div class="form-group" id="f_break_start_time">
						<label class="col-lg-4 control-label">Break Start At</label>
						<div class="col-lg-8">
							<div class="input-group date" id="break_start_time">
								<input type="text" class="form-control" name="break_start_at" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
						
					<div class="form-group" id="f_venue">
						<label for="venue" class="col-lg-4 control-label">Venue</label>
						<div class="col-lg-8">
							<?=modules::run('attribute/venue/dropdown', 'venue');?>
						</div>
					</div>
					<div class="form-group">
						<label for="position" class="col-lg-4 control-label">Role</label>
						<div class="col-lg-8">
							<?=modules::run('attribute/role/dropdown', 'role_id');?>
						</div>
					</div>
					<div class="form-group" id="f_count">
						<label for="unisex" class="col-lg-4 control-label">Staff Required</label>
						<div class="col-lg-3">
							<div class="input-group">
								<input type="text" class="form-control input_number_only" name="count" value="1" />
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="uniform_id" class="col-lg-4 control-label">Uniform</label>
						<div class="col-lg-8">
							<?=modules::run('attribute/uniform/dropdown', 'uniform_id');?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="payrate" class="col-lg-4 control-label">Payrate</label>
						<div class="col-lg-4">
							<?=modules::run('attribute/payrate/dropdown', 'payrate_id');?>
						</div>
						<div class="col-lg-4">
								<div class="col-lg-5">
									<div class="radio">
										<input type="radio" checked name="payrate_type" value="tfn" /> TFN
									</div>
								</div>
								<div class="col-lg-3">
									<div class="radio">
										<input type="radio" name="payrate_type" value="abn" /> ABN
									</div>
								</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-8">
							<a class="btn btn-info" id="btn_create_js"><i class="fa fa-plus-circle"></i> Create Job Shifts</a>
							&nbsp; 
							<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset Form</button>
						</div>
					</div>
					
					
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div id="wrapper_calendar">
		</div>
	</div>
	
</div>

<div id="wrapper_js">
</div>
<!-- Modal -->
<div class="modal fade" id="copy_shift" tabindex="-1" role="dialog" aria-hidden="true">
</div><!-- /.modal -->
<script>
$(function(){
	load_job_shifts(<?=$job['job_id'];?>);
	$('#start_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
        startDate: "<?=date('Y-m-d');?>"
    }).on('changeDate', function(e) {
    	var start_date = moment(e.date.valueOf() - 11*60*60*1000);
    	var finish_date = $('input[name="finish_time"]').val();
    	if (start_date > moment(finish_date, "DD-MM-YYYY HH:mm"))
    	{
	    	$('input[name="finish_time"]').val(start_date.format("DD-MM-YYYY HH:mm"));
    	}
    	$('#finish_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
    	$('#break_start_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
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
        startDate: "<?=date('Y-m-d');?>"
    }).on('changeDate', function(e) {
    	var finish_date = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#break_start_time').datetimepicker('setEndDate', finish_date.format("DD-MM-YYYY HH:mm"));
    });
    $('#break_start_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
    });
    
    
    $('#btn_create_js').click(function(){
    	$('.form-group').removeClass('has-error');
	    $.ajax({
	    	type: "POST",
	    	url: "<?=base_url();?>job/ajax/create_job_shifts",
	    	data: $('#form_create_js').serialize(),
			success: function(data)
			{
				data = $.parseJSON(data);
				if (!data.ok)
				{
					$('#f_' + data.error_id).addClass('has-error');
				}
				else
				{
					load_job_shifts(<?=$job['job_id'];?>);
				}
				
			}			
		})
    });
    $('#copy_shift').on('hidden.bs.modal', function (e) {
		$(this).removeData('bs.modal');
	})
})

</script>