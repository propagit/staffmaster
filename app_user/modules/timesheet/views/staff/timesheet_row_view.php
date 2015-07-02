<tr id="timesheet_<?=$timesheet['timesheet_id'];?>">
	<td>
		<? if ($updatable) { ?>
		<input type="checkbox" class="selected_timesheet" value="<?=$timesheet['timesheet_id'];?>" />
		<? } ?>
	</td>
	<td class="wp-date" width="80">
		<span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
		<span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
		<span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
	</td>
	<td><?=$client['company_name'];?>
   		<?
			if($timesheet['reject_note'] || $timesheet['note_update']){
				$msg = "";
				if ($timesheet['reject_note']) {
					$msg .= $timesheet['reject_note'] . "<br />";
				}
				$note_update = json_decode($timesheet['note_update']);
				foreach($note_update as $note) {
					$msg .= $note . "<br />";
				}
		?>
        <a class="note_tooltip" href="javascript:void(0);" data-toggle="tooltip" data-html="true"  data-placement="bottom" title="<?=$msg;?>"><i class="fa fa-exclamation-circle text-danger"></i></a>
        <?php } ?>
    </td>
	<td>
		<? if ($timesheet['venue_id']) { ?>
		<i class="fa fa-map-marker"></i> &nbsp; <a data-toggle="modal" data-target="#modal_map" href="<?=base_url();?>common/ajax/load_venue_map/<?=$timesheet['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></a>
		<? } else { ?>
		Not Specified
		<? } ?>
	</td>
	<td>
	<?=$staff['first_name'] . ' ' . $staff['last_name'];?>
    <!-- add note to timehseet-->
    <a class="add-ts-note" data-type="textarea" data-title="Note" data-placeholder="Enter your note here..." data-pk="<?=$timesheet['timesheet_id'];?>"><i class="fa fa-pencil"></i></a>
    <!-- note to timesheet-->
    
    </td>
	<td class="center staff_timesheet_time">
		<? if ($updatable) { ?>
		<a href="#" class="ts_start_time prim-color-to-txt-color" data-type="combodate" data-template="HH: mm" data-format="HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('H:i', $timesheet['start_time']);?>" data-title="Time sheet start date/time">
			<? if ($timesheet['start_time'] != $shift['start_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['start_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['start_time']);?>
			<? } ?>
		</a>
		-
		<a href="#" class="ts_finish_time prim-color-to-txt-color" data-type="combodate" data-template="HH: mm" data-format="HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('H:i', $timesheet['finish_time']);?>" title="Time sheet finish date/time">
			<? if ($timesheet['finish_time'] != $shift['finish_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['finish_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['finish_time']);?>
			<? } ?>
		</a>

		<? } else { ?>
			<? if ($timesheet['start_time'] != $shift['start_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['start_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['start_time']);?>
			<? } ?>
			-
			<? if ($timesheet['finish_time'] != $shift['finish_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['finish_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['finish_time']);?>
			<? } ?>
		<? } ?>
		<?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-red">*</span>': '';?>
	</td>
	<td class="center staff_timesheet_time">
		<? if ($updatable) { ?>
		<a id="ts_break_<?=$timesheet['timesheet_id'];?>" data-toggle="popover" onclick="load_ts_breaks(this)" class="ts_breaks editable-click prim-color-to-txt-color" data-pk="<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['break_time'] != $shift['break_time']) { ?>
			<span class="text-red"><?=modules::run('common/break_time', $timesheet['break_time']);?></span>
			<? } else { ?>
			<?=modules::run('common/break_time', $timesheet['break_time']);?>
			<? } ?>
		</a>
		<? } else { ?>
			<? if ($timesheet['break_time'] != $shift['break_time']) { ?>
			<span class="text-red"><?=modules::run('common/break_time', $timesheet['break_time']);?></span>
			<? } else { ?>
			<?=modules::run('common/break_time', $timesheet['break_time']);?>
			<? } ?>
		<? } ?>
	</td>
	<td class="center"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
	<td class="center">
		<? if ($updatable) { ?>
		<a class="editable-click prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax_staff/load_expenses_modal/<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['expenses'] != $shift['expenses']) { ?>
			<span class="text-red">$<?=money_format('%i', $total_expenses);?></span>
			<? } else { ?>
			$<?=money_format('%i', $total_expenses);?>
			<? } ?>
		</a>
		<? } else { ?>
			<? if ($timesheet['expenses'] != $shift['expenses']) { ?>
			<span class="text-red">$<?=money_format('%i', $total_expenses);?></span>
			<? } else { ?>
			$<?=money_format('%i', $total_expenses);?>
			<? } ?>
		<? } ?>
	</td>
	<td class="center"><a class="editable-click prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a></td>
	<td class="center">
		<? if ($timesheet['status'] < TIMESHEET_SUBMITTED) { ?>
			<? if($timesheet['reject_note']){ ?>
            <button class="btn btn-core btn-block btn-rt-padding" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)" style="background-color: #d9534f !important;border-color: #d43f3a;"><i class="fa fa-arrow-right"></i> Re-Submit</button>
            <? }else {?>
            <button class="btn btn-core btn-block btn-rt-padding" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-arrow-right"></i> Submit</button>
            <? }?>
		<? } else if ($timesheet['status'] == TIMESHEET_SUBMITTED) { ?>
			<? if ($updatable) { ?>
			<button class="btn btn-core btn-block btn-rt-padding" onclick="submit_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-arrow-right"></i> Submit</button>
			<? } else { ?>
			<button class="btn btn-warning btn-block btn-rt-padding"><i class="fa fa-check"></i>  Pending</button>
			<? } ?>
		<? } else if ($timesheet['status'] == TIMESHEET_APPROVED) { ?>
		<button class="btn btn-success btn-block btn-rt-padding"><i class="fa fa-check"></i>  Approved</button>
		<? } ?>
	</td>
</tr>
