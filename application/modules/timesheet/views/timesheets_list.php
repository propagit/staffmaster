<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"></th>
		<th class="center">Date</th>
		<th>Campaign Name</th>
		<th>Venue</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Pay rate</th>
		<th>Staff Assigned</th>
		<th class="center">Expenses</th>
		<th class="center">Approve</th>
		<th class="center" width="40">View</th>
		<th class="center" width="40">Delete</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		$client = modules::run('client/get_client', $timesheet['client_id']);
		$staff = modules::run('staff/get_staff', $timesheet['staff_id']);  ?>
	<tr class="<?=modules::run('timesheet/status_to_class', $timesheet['status']);?>">
		<td><input type="checkbox" value="<?=$timesheet['shift_id'];?>" /></td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
		</td>
		<td><?=$client['company_name'];?></td>
		<td><?=$timesheet['job_name'];?></td>
		<td class="center"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
		<td class="center"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
		<td><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
		<td><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td>
		<td class="center"><a href="#"><i class="fa fa-dollar"></i></a></td>
		<td class="center"><a class="" onclick="approve_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-check"></i></a></td>
		<td class="center"><a href="#"><i class="fa fa-eye"></i></a></td>
		<td class="center"><a onclick="delete_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-times"></i></a></td>
	</tr>
	<? } ?>
</tbody>
</table>

<script>
function approve_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/approve_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			list_timesheets();
		}
	})
}
function delete_timesheet(timesheet_id) {
	var title = 'Delete Timesheet';
	var message ='This action will delete the timesheet and unlock the shift. Are you sure you want to do so?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				 type: "POST",
				 url: "<?=base_url();?>timesheet/ajax/delete_timesheet",
				 data: {timesheet_id: timesheet_id},
				 success: function(html) {
					 list_timesheets();
				 }
			 })
		 }
	});
}
</script>