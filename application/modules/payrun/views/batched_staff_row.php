<? 
$total_minutes = 0;
$total_amount = 0;
$from_date = 100000000000;
$to_date = 0;
foreach($staff_timesheets as $timesheet) {
	$total_minutes += $timesheet['total_minutes'];
	$total_amount += $timesheet['total_amount_staff'];
	if ($from_date >= $timesheet['start_time']) {
		$from_date = $timesheet['start_time'];
	}
	if ($to_date <= $timesheet['finish_time']) {
		$to_date = $timesheet['finish_time'];
	}
} ?>
	<td class="center"><input type="checkbox" /></td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $from_date);?></span>
		<span class="wk_date"><?=date('d', $from_date);?></span>
		<span class="wk_month"><?=date('M', $from_date);?></span>
	</td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $to_date);?></span>
		<span class="wk_date"><?=date('d', $to_date);?></span>
		<span class="wk_month"><?=date('M', $to_date);?></span>
	</td>
	<td colspan="3"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td>
	<td class="center"><?=$staff['state'];?></td>
	<td class="center"><?=$total_minutes / 60;?></td>
	<td class="center">$<?=$total_amount;?></td>
	<td class="center"><?=count($staff_timesheets);?></td>
	<td class="center">
		<a class="wp-arrow" onclick="expand_staff_timehsheets(<?=$staff['user_id'];?>)"><i class="fa fa-plus-square-o fa-1x"></i></a>
	</td>
	<td class="center">
		<div class="btn-group">
			<button type="button" class="btn btn-default">Yes</button>
			<button type="button" class="btn btn-danger">No</button>
		</div>
	</td>
	<td class="center">
		<a onclick="revert_staff_payruns(<?=$staff['user_id'];?>)"><i class="fa fa-times"></i></a>
	</td>
	
