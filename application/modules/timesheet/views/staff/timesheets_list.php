<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"></th>
		<th class="center">Date</th>
		<th>Client</th>
		<th>Venue</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Pay rate</th>
		<th class="center">Expenses</th>
		<th class="center" width="40">View</th>
		<th class="center" width="200">Status</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet['timesheet_id']); 
	} ?>
</tbody>
</table>

<script>
$(function() {
	
})
function submit_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/submit_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refrest_timesheet(timesheet_id);
		}
	})
}
function init_edit() {
	
}
function refrest_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/refresh_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
			init_edit();
		}
	})
}
</script>