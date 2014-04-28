<h2>Create Job Shifts</h2>
<p>Create a job via the below form. Jobs can be duplicated to other days. Jobs created will be viewable in the weeks schedule to the right. The weeks shifts can be duplicated.</p>

<form class="form-horizontal" role="form" id="form_create_js">
	<input type="hidden" name="job_id" value="<?=$job_id;?>" />
	<div class="form-group" id="f_start_date">
		<label class="col-lg-3 control-label">Start Date/Time</label>
		<div class="col-lg-6">
			<div class="input-group date" id="start_date">
				<input type="text" class="form-control" name="job_date" id="start_date" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
	
	<div class="form-group" id="f_finish_time">
		<label class="col-lg-3 control-label">Finish Date/Time</label>
		<div class="col-lg-6">
			<div class="input-group date" id="finish_time">
				<input type="text" class="form-control" name="finish_time" id="finish_time" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
	
	
	<div class="form-group">
		<label class="col-lg-3 control-label">Break Length</label>
		<div class="col-lg-4">
			<div class="input-group date">
				<input type="text" class="form-control input_number_only" name="break_length" value="0" maxlength="3" />
				<span class="input-group-addon">minute(s)</span>
			</div>
		</div>
	</div>
	
	<div class="form-group" id="f_break_start_at">
		<label class="col-lg-3 control-label">Break Start At</label>
		<div class="col-lg-6">
			<div class="input-group date" id="break_start_time">
				<input type="text" class="form-control" name="break_start_at" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
		
	<div class="form-group" id="f_venue">
		<label for="venue" class="col-lg-3 control-label">Venue</label>
		<div class="col-lg-6">
			<?=modules::run('attribute/venue/field_select', 'venue_id');?>
		</div>
		
		<? if (!$is_client) { ?>
		<div class="col-lg-3 help-block">
			<a><b><i class="fa fa-plus"></i></b></a> &nbsp; <a href="<?=base_url();?>attribute/venue/create">Create Venue</a>
		</div>
		<? } ?>
	</div>
	<div class="form-group">
		<label for="position" class="col-lg-3 control-label">Role</label>
		<div class="col-lg-6">
			<?=modules::run('attribute/role/field_select', 'role_id');?>
		</div>
		<? if (!$is_client) { ?>
		<div class="col-lg-3 help-block">
			<a><b><i class="fa fa-plus"></i></b></a> &nbsp; <a href="<?=base_url();?>attribute/role">Create Role</a>
		</div>
		<? } ?>
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
		<div class="col-lg-6">
			<?=modules::run('attribute/uniform/field_select', 'uniform_id');?>
		</div>
		<? if (!$is_client) { ?>
		<div class="col-lg-3 help-block">
			<a><b><i class="fa fa-plus"></i></b></a> &nbsp; <a href="<?=base_url();?>attribute/uniform">Create Uniform</a>
		</div>
		<? } ?>
	</div>
	
	<? if (!$is_client) { ?>
	<div class="form-group" id="f_payrate_id">
		<label for="payrate" class="col-lg-3 control-label">Payrate</label>
		<div class="col-lg-6">
			<?=modules::run('attribute/payrate/field_select', 'payrate_id');?>
		</div>
		
		<div class="col-lg-3 help-block">
			<a><b><i class="fa fa-plus"></i></b></a> &nbsp; <a href="<?=base_url();?>attribute/payrate" target="_blank">Create Pay rate</a>
		</div>
	</div>
	
	<div class="form-group" id="f_supervisor">
		<label for="supervisor" class="col-lg-3 control-label">Supervisor</label>
		<div class="col-lg-6">
			<?=modules::run('user/field_select', 'supervisor_id');?>
		</div>
	</div>	
	<? } ?>
	
	<div class="form-group">
		<div class="col-lg-offset-3 col-lg-8">
			<button type="button" class="btn btn-core" id="btn_create_js" data-loading-text="Creating shifts..." ><i class="fa fa-plus-circle"></i> Create Shifts</button>
			&nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset Form</button>
		</div>
	</div>
	
	
</form>
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
        format: 'dd-mm-yyyy hh:ii',
        //startDate: "<?=date('Y-m-d');?>"
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
        //startDate: "<?=date('Y-m-d');?>"
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
    	var btn = $(this);
		btn.button('loading');
    	$('.form-group').removeClass('has-error');
	    $.ajax({
	    	type: "POST",
	    	url: "<?=base_url();?>job/ajax/create_shifts",
	    	data: $('#form_create_js').serialize(),
			success: function(data)
			{
				btn.button('reset');
				data = $.parseJSON(data);
				if (!data.ok)
				{
					$('#f_' + data.error_id).addClass('has-error');
					$('#' + data.error_id).focus();
				}
				else
				{
					load_job_shifts(<?=$job_id;?>, data.job_date);
				}
				
			}			
		})
    });
})
</script>