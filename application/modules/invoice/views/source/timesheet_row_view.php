<tr class="success" id="timesheet_<?=$timesheet['timesheet_id'];?>">
	<td width="20"><input type="checkbox" /></td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $timesheet['start_time']);?></span>
		<span class="wk_date"><?=date('d', $timesheet['start_time']);?></span>
		<span class="wk_month"><?=date('M', $timesheet['start_time']);?></span>
	</td>
	<td>
		<?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?>
	</td>
	<td class="center">
		<?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?>
		</td>
	<td class="center">
		<?=modules::run('common/break_time', $timesheet['break_time']);?>
	</td>
	<td width="60" class="center"> <?=$timesheet['total_minutes']/60;?></td>
	<td class="center" width="120">
		<? if($timesheet['expenses_client_cost'] > 0) { ?>
			$<?=$timesheet['expenses_client_cost'];?>
		<? } ?>
	</td>
	<td class="center" width="120">$<?=$timesheet['total_amount_client'];?></td>
	<td class="center" width="120">
		<div class="btn-group">
			<? if ($timesheet['status_invoice_client'] == INVOICE_READY) { ?>
			<button type="button" onclick="add_timesheet_to_invoice(<?=$timesheet['timesheet_id'];?>, <?=$timesheet['job_id'];?>)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="remove_timesheet_from_invoice(<?=$timesheet['timesheet_id'];?>, <?=$timesheet['job_id'];?>)" class="btn btn-default btn-no">No</button>
			<? } else { ?>
			<button type="button" onclick="add_timesheet_to_invoice(<?=$timesheet['timesheet_id'];?>, <?=$timesheet['job_id'];?>)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="remove_timesheet_from_invoice(<?=$timesheet['timesheet_id'];?>, <?=$timesheet['job_id'];?>)" class="btn btn-danger btn-no">No</button>
			<? } ?>
		</div>
	</td>
	<td class="center" width="40">
		<a class="editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a>
	</td>
</tr>