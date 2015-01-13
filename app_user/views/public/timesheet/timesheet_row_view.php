<?php
	$timesheet = modules::run('timesheet/get_timesheet',$timesheet_id);
	$client = modules::run('client/get_client', $timesheet['client_id']);
	$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
	$shift = $this->job_shift_model->get_job_shift($timesheet['shift_id']);
	
	$total_expenses = 0;
	$expenses = unserialize($timesheet['expenses']);
	if (is_array($expenses)) {
		foreach($expenses as $e) {
			$staff_cost = $e['staff_cost'];
			if ($e['tax'] == GST_ADD) {
				$staff_cost *= 1.1;
			}
			$total_expenses += $staff_cost;
		}
	}
	$paid_expenses = $this->expense_model->get_timesheet_expenses($timesheet_id);
	foreach($paid_expenses as $e) {
		$staff_cost = $e['staff_cost'];
		if ($e['tax'] == GST_ADD) {
			$staff_cost *= 1.1;
		}
		$total_expenses += $staff_cost;
	}
	$total_expenses = $total_expenses;
	
	$updatable = false;
	if ($timesheet['status'] < TIMESHEET_SUBMITTED || # Timesheet never been submitted
			($timesheet['status'] < TIMESHEET_APPROVED)) {
		$updatable = true;
	}
	?>
	<tr id="ts-r-<?=$timesheet_id;?>">
        <td>
            <? if ($updatable) { ?>
            <input type="checkbox" class="selected_timesheet" value="<?=$timesheet['timesheet_id'];?>" />
            <? } ?>
        </td>
        
        <td class="wp-date" width="80">
            <span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
            <span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
            <span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
        </td><!--date-->
        
        <td><?=$client['company_name'];?></td>
        
        <td>
            <? if ($timesheet['venue_id']) { ?>
            <i class="fa fa-map-marker"></i> &nbsp; <a data-toggle="modal" data-target="#modal_map" href="javascript:void(0);"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></a>
            <? } else { ?>
            Not Specified
            <? } ?>
        </td><!--venue-->
        
        <td><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td>
        
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
        </td><!--start - finish time -->
        
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
        </td><!-- break -->
        
        <td class="center"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
        
        <td class="center">
        <? if ($updatable) { ?>
        <a class="editable-click prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>pts/load_expenses_modal/<?=$timesheet['timesheet_id'];?>">
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
        </td><!--expenses-->
        
        <td class="center"><a class="editable-click prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>pts/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a></td>
        <td class="center"><button class="btn btn-success approve" data-ts="<?=$timesheet_id;?>"><i class="fa fa-check"></i>  Approve</button></td>
        <td class="center"><button class="btn btn-danger reject" data-ts="<?=$timesheet_id;?>"><i class="fa fa-times"></i>  Reject</button></td>
	</tr>   