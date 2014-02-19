<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
			<a class="btn btn-core" href="<?=base_url();?>timesheet/generate">Generate Timesheets</a>
			&nbsp; 
			<a class="btn btn-danger" href="<?=base_url();?>timesheet/truncate">Clean Timesheeets</a>
		</div>
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become availble below for you to submit.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond">
				<li class="active"><a>Time Sheets</a></li>
				<li><a href="<?=base_url();?>payrun">Pay Run</a></li>
			</ul>
			<br />
			<h2>Find Time Sheets</h2>
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are diplayed red.</p>
			<br />
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
					<label for="position" class="col-md-2 control-label">Role</label>
					<div class="col-md-4">
						<?=modules::run('attribute/role/field_select', 'position');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="location" class="col-md-2 control-label">Location</label>
					<div class="col-md-4">
						<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
					</div>
					<label for="payrate" class="col-md-2 control-label">Payrate</label>
					<div class="col-md-4">
						<?=modules::run('attribute/payrate/field_select', 'payrate_id');?>
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
					<div class="col-md-offset-2 col-md-8">
						<button type="button" class="btn btn-core" id="btn_search_timesheets"><i class="fa fa-search"></i> Search</button> &nbsp; 
						<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
					</div>
				</div>
			</div>	
			</form>
			
			<div id="list_timesheets"></div>
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
var sort_data = {
	'sort_by':'t.job_date',
	'sort_order':'desc'
};
$(function(){
	list_timesheets();
})

function list_timesheets() {
	preloading($('#list_timesheets'));
	$.ajax({
		type: "POST",
		data:{params:JSON.stringify(sort_data)},
		url: "<?=base_url();?>timesheet/ajax/list_timesheets",
		success: function(html) {
			loaded($('#list_timesheets'), html);
		}
	})
}
</script>