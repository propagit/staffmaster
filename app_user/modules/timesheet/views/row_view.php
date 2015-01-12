<tr class="<?=modules::run('timesheet/status_to_class', $timesheet['status'],$timesheet['timesheet_id']);?>" id="timesheet_<?=$timesheet['timesheet_id'];?>">
	<td><input type="checkbox" class="select_timesheet" value="<?=$timesheet['timesheet_id'];?>" /></td>
	<td class="wp-date" width="80">
		<span class="wk_day"><?=date('D', strtotime($timesheet['job_date']));?></span>
		<span class="wk_date"><?=date('d', strtotime($timesheet['job_date']));?></span>
		<span class="wk_month"><?=date('M', strtotime($timesheet['job_date']));?></span>
	</td>
	<td>
		<?=$client['company_name'];?>
        <?
			if($timesheet['reject_note']){
		?>
        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="<?=$timesheet['reject_note'];?>"><i class="fa fa-exclamation-circle text-danger"></i></a>
        <?php } ?>
    </td>
	<td><?=$job['name'];?></td>
	<td class="center">
		<a href="#" class="ts_start_time prim-color-to-txt-color" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('Y-m-d H:i', $timesheet['start_time']);?>" data-title="Time sheet start date/time">
			<? if ($timesheet['start_time'] != $shift['start_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['start_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['start_time']);?>
			<? } ?>
		</a>
		- 
		<a href="#" class="ts_finish_time prim-color-to-txt-color" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$timesheet['timesheet_id'];?>" data-value="<?=date('Y-m-d H:i', $timesheet['finish_time']);?>" title="Time sheet finish date/time">
			<? if ($timesheet['finish_time'] != $shift['finish_time']) { ?>
			<span class="text-red"><?=date('H:i', $timesheet['finish_time']);?></span>
			<? } else { ?>
			<?=date('H:i', $timesheet['finish_time']);?>
			<? } ?>
		</a> 
		<?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-red">*</span>': '';?> 
		(<?=($timesheet['finish_time'] - $timesheet['start_time']) / 3600;?>h)
	</td>
	<td class="center">
		<a id="ts_break_<?=$timesheet['timesheet_id'];?>" onclick="load_ts_breaks(this)" class="ts_breaks prim-color-to-txt-color prim-color-to-txt-color" data-pk="<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['break_time'] != $shift['break_time']) { ?>
			<span class="text-red"><?=modules::run('common/break_time', $timesheet['break_time']);?></span>
			<? } else { ?>
			<?=modules::run('common/break_time', $timesheet['break_time']);?>
			<? } ?>
		</a>
	</td>
	<td class="center">
		<a class="ts_payrate prim-color-to-txt-color" onclick="load_ts_payrate(this)" data-pk="<?=$timesheet['timesheet_id'];?>" data-toggle="popover">
			<? if ($timesheet['payrate_id'] != $shift['payrate_id']) { ?>
			<span class="text-red">
				<?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?>
			</span>
			<? } else { ?>
			<?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?>
			<? } ?>
			
			<? if($this->config_model->get('separate_client_payrate')) { 
				$shift_client_payrate_id = ($shift['client_payrate_id']) ? $shift['client_payrate_id'] : $shift['payrate_id'];
				$client_payrate_id = ($timesheet['client_payrate_id']) ? $timesheet['client_payrate_id'] : $timesheet['payrate_id']; 
				if ($shift_client_payrate_id != $client_payrate_id) { ?>
				<br /><span class="text-red"><?=modules::run('attribute/payrate/display_payrate', $client_payrate_id);?></span>
				<? } else { ?>
				<br /><span class="text-muted"><?=modules::run('attribute/payrate/display_payrate', $client_payrate_id);?></span>
				<? }
			} ?>
		</a>
	</td>
	<td>
		<a id="ts_staff_<?=$timesheet['timesheet_id'];?>" onclick="load_ts_staff(this)" class="ts_staff prim-color-to-txt-color prim-color-to-txt-color" data-pk="<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['staff_id'] != $shift['staff_id']) { ?>
			<span class="text-red"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></span>
			<? } else { ?>
			<?=$staff['first_name'] . ' ' . $staff['last_name'];?>
			<? } ?>
		</a>
	</td>
	<td class="center">
		<a class="prim-color-to-txt-color prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/load_expenses_modal/<?=$timesheet['timesheet_id'];?>">
			<? if ($timesheet['expenses'] != $shift['expenses']) { ?>
			<span class="text-red">$<?=money_format('%i', $total_expenses);?></span>
			<? } else { ?>
			$<?=money_format('%i', $total_expenses);?>
			<? } ?>
		</a>
	</td>
	<td class="center"><a class="prim-color-to-txt-color prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a></td>
	<td class="center"><a class="prim-color-to-txt-color" onclick="batch_timesheet(<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-share-square-o"></i></a></td>
	<td class="center"><a onclick="delete_timesheet(<?=$timesheet['timesheet_id'];?>)" class="prim-color-to-txt-color"><i class="fa fa-times"></i></a></td>
</tr>