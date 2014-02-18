<? foreach($timesheets as $timesheet) { ?>
<tr class="success timesheets_staff_<?=$user_id;?>">
	<td class="center"><input type="checkbox" /></td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $timesheet['start_time']);?></span>
		<span class="wk_date"><?=date('d', $timesheet['start_time']);?></span>
		<span class="wk_month"><?=date('M', $timesheet['start_time']);?></span>
	</td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $timesheet['finish_time']);?></span>
		<span class="wk_date"><?=date('d', $timesheet['finish_time']);?></span>
		<span class="wk_month"><?=date('M', $timesheet['finish_time']);?></span>
	</td>
	<td>
		<?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?>
	</td>
	<td><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
	<td><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
	<td></td>
	<td class="center"><?=$timesheet['total_minutes']/60;?></td>
	<td class="center">$<?=$timesheet['total_amount_staff'];?></td>
	<td class="center">
		<a href="#"><i class="fa fa-eye"></i></a>
	</td>
	<td class="center">
		<div class="btn-group">
			<? if ($timesheet['status'] == TIMESHEET_PROCESSING) { ?>
			<button type="button" onclick="process_payrun(this,<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="unprocess_payrun(this,<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-default btn-no">No</button>
			<? } else { ?>
			<button type="button" onclick="process_payrun(this,<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="unprocess_payrun(this,<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-danger btn-no">No</button>
			<? } ?>
		</div>
	</td>
	<td class="center">
		<a onclick="revert_payrun(<?=$timesheet['staff_id'];?>,<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-times"></i></a>
	</td>
	<td></td>
	
</tr>
<? } ?>
