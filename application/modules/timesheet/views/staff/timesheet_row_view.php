<tr id="timesheet_<?=$timesheet['timesheet_id'];?>">
	<td><input type="checkbox" value="<?=$timesheet['shift_id'];?>" /></td>
	<td class="wp-date" width="80">
		<span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
		<span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
		<span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
	</td>
	<td><?=$client['company_name'];?></td>
	<td>
		<? if ($timesheet['venue_id']) { ?>
		<i class="fa fa-map-marker"></i> &nbsp; <a data-toggle="modal" data-target="#modal_map" href="<?=base_url();?>common/ajax/load_venue_map/<?=$timesheet['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></a>
		<? } else { ?>
		Not Specified
		<? } ?>
	</td>
	<td class="center"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
	<td class="center"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
	<td><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
	<td class="center"><a href="#"><i class="fa fa-dollar"></i></a></td>
	<td class="center"><a class="editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a></td>
	<td class="center">
		<? if ($timesheet['status'] < TIMESHEET_SUBMITTED) { ?>
		<button class="btn btn-core btn-block" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-arrow-right"></i> Submit</button>
		<? } else if ($timesheet['status'] == TIMESHEET_SUBMITTED) { ?>
		<button class="btn btn-warning btn-block"><i class="fa fa-check"></i>  Waiting for Approval</button>
		<? } else if ($timesheet['status'] == TIMESHEET_APPROVED) { ?>
		<button class="btn btn-success btn-block"><i class="fa fa-check"></i>  Approved</button>
		<? } ?>
	</td>
</tr>