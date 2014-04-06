<tr id="timesheet_<?=$timesheet['timesheet_id'];?>">
	<td>
		<? if ($timesheet['status'] < TIMESHEET_SUBMITTED) { ?>
		<input type="checkbox" class="selected_timesheet" value="<?=$timesheet['timesheet_id'];?>" />
		<? } ?>
	</td>
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
	<td><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td>
	<td class="center">
		<a href="#" class="ts_start_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('Y-m-d H:i', $timesheet['start_time']);?>" data-title="Time sheet start date/time">
			<? if ($timesheet['start_time'] != $shift['start_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['start_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['start_time']);?>
			<? } ?>
		</a>
		- 
		<a href="#" class="ts_finish_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('Y-m-d H:i', $timesheet['finish_time']);?>" title="Time sheet finish date/time">
			<? if ($timesheet['finish_time'] != $shift['finish_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['finish_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['finish_time']);?>
			<? } ?>
		</a> 
		<?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-red">*</span>': '';?>
	</td>
	<td class="center">
		<a id="ts_break_<?=$timesheet['timesheet_id'];?>" data-toggle="popover" onclick="load_ts_breaks(this)" class="ts_breaks editable-click" data-pk="<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['break_time'] != $shift['break_time']) { ?>
			<span class="text-red"><?=modules::run('common/break_time', $timesheet['break_time']);?></span>
			<? } else { ?>
			<?=modules::run('common/break_time', $timesheet['break_time']);?>
			<? } ?>
		</a>
	</td>
	<td class="center"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
	<td class="center">
		<a class="editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax_staff/load_expenses_modal/<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['expenses'] != $shift['expenses']) { ?>
			<span class="text-red">$<?=money_format('%i', $total_expenses);?></span>
			<? } else { ?>
			$<?=money_format('%i', $total_expenses);?>
			<? } ?>
		</a>
	</td>
	<td class="center"><a class="editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a></td>
	<td class="center">
		<? if ($timesheet['status'] < TIMESHEET_SUBMITTED) { ?>
		<button class="btn btn-core btn-block" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-arrow-right"></i> Submit</button>
		<? } else if ($timesheet['status'] == TIMESHEET_SUBMITTED) { ?>
		<button class="btn btn-warning btn-block"><i class="fa fa-check"></i>  Pending</button>
		<? } else if ($timesheet['status'] == TIMESHEET_APPROVED) { ?>
		<button class="btn btn-success btn-block"><i class="fa fa-check"></i>  Approved</button>
		<? } ?>
	</td>
</tr>