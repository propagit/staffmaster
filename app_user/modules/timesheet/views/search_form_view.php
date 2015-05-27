<form class="form-horizontal" role="form" id="form_search_timesheets">
<div class="row">
	<div class="form-group">
		<label for="client_id" class="col-md-2 control-label">Client</label>
		<div class="col-md-4">
			<?=modules::run('client/field_select', 'client_id');?>
		</div>
		<label class="col-md-2 control-label">Campaign Name</label>
		<div class="col-md-4">
			<input type="text" name="job_name" class="form-control" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Status</label>
		<div class="col-md-4">
			<?=modules::run('timesheet/field_select_status', 'status');?>
		</div>
		<label for="role_id" class="col-md-2 control-label">Role</label>
		<div class="col-md-4">
			<?=modules::run('attribute/role/field_select', 'role_id');?>
		</div>
	</div>
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
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Location</label>
		<div class="col-md-4">
			<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
		</div>
		<label for="payrate_id" class="col-md-2 control-label">Payrate</label>
		<div class="col-md-4">
			<?=modules::run('attribute/payrate/field_select', 'payrate_id');?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Shift Duration</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_shift_duration', 'shift_duration');?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<button type="button" class="btn btn-core" id="btn_search_timesheets"><i class="fa fa-search"></i> Search</button> &nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
		</div>
	</div>
</div>	
</form>
<script>
$(function(){
	$('#btn_search_timesheets').click(function(){
		search_timesheets();
	});
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
})
var sort_data = {
	'sort_by':'t.job_date',
	'sort_order':'asc'
};
function search_timesheets() {
	preloading($('#list_timesheets'));
	var data = $('#form_search_timesheets').serializeArray();
	data.push({name: 'sort_data', value: JSON.stringify(sort_data)});
	$.ajax({
		type: "POST",
		data: data,
		url: "<?=base_url();?>timesheet/ajax/search_timesheets",
		success: function(html) {
			loaded($('#list_timesheets'), html);
		}
	})
}
</script>