<form class="form-horizontal" role="form" id="form_search_expenses">
<div class="row">
	<div class="form-group">
		<label for="staff_name" class="col-md-2 control-label">Staff Name</label>
		<div class="col-md-4">
			<?=modules::run('staff/field_select', 'staff_id');?>
		</div>
		<label for="description" class="col-md-2 control-label">Description</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="description" name="description" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="client_id" class="col-md-2 control-label">Client</label>
		<div class="col-md-4">
			<?=modules::run('client/field_select', 'client_id');?>
		</div>
		<label for="job_name" class="col-md-2 control-label">Campaign Name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="job_name" name="job_name" placeholder="enter campaign name..." />
		</div>
	</div>
</div>
<div class="row">
	
</div>
<div class="row">
	<div class="form-group">
		<label for="date_from" class="col-md-2 control-label">Date From</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_from">
				<input type="text" class="form-control" name="date_from" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
		<label for="date_to" class="col-md-2 control-label">Date To</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_to">
				<input type="text" class="form-control" name="date_to" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
</div>
<? if (isset($timesheet_id)) { ?>
<input type="hidden" name="timesheet_id" value="<?=$timesheet_id;?>" />
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Status</label>
		<div class="col-md-4">
			<?=modules::run('expense/field_select_status', 'status', EXPENSE_PAID);?>
		</div>
	</div>
</div>
<? } else { ?>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Status</label>
		<div class="col-md-4">
			<?=modules::run('expense/field_select_status', 'status', EXPENSE_UNPAID);?>
		</div>
	</div>
</div>
<? } ?>

<div class="row hide" id="paid_date_range">
	<div class="form-group">
		<label for="paid_date_from" class="col-md-2 control-label">Paid Date From</label>
		<div class="col-md-4">
			<div class="input-group date" id="paid_date_from">
				<input type="text" class="form-control" name="paid_date_from" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
		<label for="paid_date_to" class="col-md-2 control-label">Paid Date To</label>
		<div class="col-md-4">
			<div class="input-group date" id="paid_date_to">
				<input type="text" class="form-control" name="paid_date_to" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<button type="button" class="btn btn-core" id="btn-search-expenses"><i class="fa fa-search"></i> Search</button> &nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
		</div>
	</div>
</div>
</form>

<div id="invoice-search-results">
</div>

<script>
$(function(){
    $('#btn-search-expenses').click(function() {
	    search_expenses();
    });
    init_paid_date_range();
    $('#status').change(function(){
	    init_paid_date_range();
    })
	$('#date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
    $('#paid_date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#paid_date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#paid_date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#paid_date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
});
function init_paid_date_range() {
	var status = $('#status').val();
	if (status == <?=EXPENSE_PAID;?>) {
		$('#paid_date_range').removeClass('hide');
	} else {
		$('#paid_date_range').addClass('hide');
	}
}
</script>