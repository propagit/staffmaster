<? 
$total_minutes = 0;
$total_amount = 0;
$from_date = 100000000000;
$to_date = 0;
$processing = true;
$total_ready = 0;
foreach($staff_timesheets as $timesheet) {
	$total_minutes += $timesheet['total_minutes'];
	$total_amount += $timesheet['total_amount_staff'];
	if ($from_date >= $timesheet['start_time']) {
		$from_date = $timesheet['start_time'];
	}
	if ($to_date <= $timesheet['finish_time']) {
		$to_date = $timesheet['finish_time'];
	}
	if ($timesheet['status_payrun_staff'] == PAYRUN_READY) {
		$total_ready++;
	} else {
		$processing = false;
	}
} ?>
	<td class="center"><input type="checkbox" class="payrun_staff" name="payrun_staffs[]" value="<?=$staff['user_id'];?>" <?=($checked) ? 'checked' : '';?> /></td>
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
	<td class="center">$<?=money_format('%i', $total_amount);?></td>
	<td class="center">
		<? if (count($staff_timesheets) == $total_ready) { ?>
		<span class="badge success"><?=$total_ready;?></span>
		<? } else if($total_ready == 0) { ?>
		<span class="badge danger"><?=count($staff_timesheets);?></span> 
		<? } else { ?>
		<span class="badge danger"><?=count($staff_timesheets) - $total_ready;?></span> 
		<span class="badge success"><?=$total_ready;?></span>
		<? } ?>
	</td>
	<td class="center">
		<div class="btn-group">
		<? if ($processing) { ?>
			<button type="button" onclick="process_staff_payruns(<?=$staff['user_id'];?>)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="unprocess_staff_payruns(<?=$staff['user_id'];?>)" class="btn btn-default btn-no">No</button>
		<? } else { ?>
			<button type="button" onclick="process_staff_payruns(<?=$staff['user_id'];?>)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="unprocess_staff_payruns(<?=$staff['user_id'];?>)" class="btn btn-danger btn-no">No</button>
		<? } ?>
		</div>
	</td>
	<td class="center">
		<? if($total_ready == 0) { ?>
		<a onclick="revert_staff_payruns(<?=$staff['user_id'];?>)"><i class="fa fa-times"></i></a>
		<? } ?>
	</td>
	<td class="center">
		<? if ($expanded) { ?>
		<a class="wp-arrow" onclick="collapse_staff_timesheets(<?=$staff['user_id'];?>)"><i class="fa fa-minus-square-o fa-1x"></i></a>
		<? } else { ?>
		<a class="wp-arrow" onclick="expand_staff_timehsheets(<?=$staff['user_id'];?>)"><i class="fa fa-plus-square-o fa-1x"></i></a>
		<? } ?>
	</td>