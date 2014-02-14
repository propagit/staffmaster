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
		<th class="center">Status</th>
		<th class="center" width="40">View</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		$client = modules::run('client/get_client', $timesheet['client_id']);
		$staff = modules::run('staff/get_staff', $timesheet['staff_id']);  ?>
	<tr>
		<td><input type="checkbox" value="<?=$timesheet['shift_id'];?>" /></td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
		</td>
		<td><?=$client['company_name'];?></td>
		<td>
			<? if ($timesheet['venue_id']) { ?>
			<i class="fa fa-map-marker"></i> &nbsp; <a data-toggle="modal" data-target="#modal_map" href="<?=base_url();?>roster/ajax/load_roster_venue/<?=$timesheet['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></a>
			<? } else { ?>
			Not Specified
			<? } ?>
		</td>
		<td class="center"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
		<td class="center"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
		<td><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
		<td class="center"><a href="#"><i class="fa fa-dollar"></i></a></td>
		<td class="center">
			<? if ($timesheet['status'] < TIMESHEET_SUBMITTED) { ?>
			<button class="btn btn-core" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-arrow-right"></i> Submit</button>
			<? } else if ($timesheet['status'] == TIMESHEET_SUBMITTED) { ?>
			<button class="btn btn-warning"><i class="fa fa-check"></i>  Waiting for Approval</button>
			<? } else if ($timesheet['status'] == TIMESHEET_APPROVED) { ?>
			<button class="btn btn-success"><i class="fa fa-check"></i>  Approved</button>
			<? } ?>
		</td>
		<td class="center"><a href="#"><i class="fa fa-eye"></i></a></td>
	</tr>
	<? } ?>
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
			list_timesheets();
		}
	})
}
</script>