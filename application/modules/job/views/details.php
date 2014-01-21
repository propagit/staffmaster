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
						<label class="col-lg-3 control-label">Job Start Date</label>
						<div class="col-lg-4">
							<div class="input-group date" id="start_date">
								<input type="text" class="form-control" data-format="DD-MM-YYYY" name="job_date" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group" id="f_start_time">
						<label class="col-lg-3 control-label">Start Time</label>
						<div class="col-lg-3">
							<div class="input-group date" id="start_time">
								<input type="text" class="form-control" name="start_time" data-format="HH:mm" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group" id="f_finish_time">
						<label class="col-lg-3 control-label">Finish Time</label>
						<div class="col-lg-3">
							<div class="input-group date" id="finish_time">
								<input type="text" class="form-control" name="finish_time" data-format="HH:mm" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
					</div>
					<div class="form-group" id="f_break_start_at">
						<label class="col-lg-3 control-label">Break Length</label>
						<div class="col-lg-3">
							<div class="input-group date">
								<input type="text" class="form-control input_number_only" name="break_length" value="0" maxlength="3" />
								<span class="input-group-addon">min(s)</span>
							</div>
						</div>
						
						<label class="col-lg-2 control-label">Start At</label>
						<div class="col-lg-3">
							<div class="input-group date" id="break_start_time">
								<input type="text" class="form-control" name="break_start_at" data-format="HH:mm" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
							</div>
						</div>
						
					</div>
					<div class="form-group" id="f_venue">
						<label for="venue" class="col-lg-3 control-label">Venue</label>
						<div class="col-lg-9">
							<?=modules::run('attribute/venue/dropdown', 'venue');?>
						</div>
					</div>
					<div class="form-group">
						<label for="position" class="col-lg-3 control-label">Role</label>
						<div class="col-lg-9">
							<?=modules::run('attribute/role/dropdown', 'role_id');?>
						</div>
					</div>
					<div class="form-group" id="f_count">
						<label for="unisex" class="col-lg-3 control-label">Staff Required</label>
						<div class="col-lg-3">
							<div class="input-group">
								<input type="text" class="form-control input_number_only" name="count" value="1" />
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="uniform_id" class="col-lg-3 control-label">Uniform</label>
						<div class="col-lg-9">
							<?=modules::run('attribute/uniform/dropdown', 'uniform_id');?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="payrate" class="col-lg-3 control-label">Payrate</label>
						<div class="col-lg-4">
							<?=modules::run('attribute/payrate/dropdown', 'payrate_id');?>
						</div>
						<div class="col-lg-5">
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
						<div class="col-lg-offset-3 col-lg-8">
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
<script>
$(function(){
	load_job_shifts(<?=$job['job_id'];?>);
	$('#start_date').datetimepicker({
		pickTime: false,
		startDate: "<?=date('n/j/Y');?>"
	});
    
	$('#start_time').datetimepicker({
        pickDate: false,
        minuteStepping: 15,
    });
    $('#finish_time').datetimepicker({
	    pickDate: false,
	    minuteStepping: 15,
    });
    $('#break_start_time').datetimepicker({
	    pickDate: false,
	    minuteStepping: 15,
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
					load_job_shifts(<?=$job['job_id'];?>, data.job_date);
				}
				
			}			
		})
    })
})

</script>