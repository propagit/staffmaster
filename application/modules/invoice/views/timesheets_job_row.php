<?
$total_amount = 0;
$total_minutes = 0;
$total_ready = 0;
$processing = true;
foreach($timesheets as $timesheet) {
	if ($timesheet['status_invoice_client'] == INVOICE_READY) {
		$total_ready++;
		$total_amount += $timesheet['total_amount_client'];
		$total_minutes += $timesheet['total_minutes'];
	} else {
		$processing = false;
	}
}
?>

<tr class="row-open" id="row-timesheets-job-<?=$job['job_id'];?>">
	<td width="20"></td>
	<td></td>
	<td><?=$job['name'];?></td>
	<td colspan="2" class="center">
		<? if (count($timesheets) == $total_ready) { ?>
		<span class="badge success"><?=$total_ready;?></span>
		<? } else if($total_ready == 0) { ?>
		<span class="badge danger"><?=count($timesheets);?></span> 
		<? } else { ?>
		<span class="badge danger"><?=count($timesheets) - $total_ready;?></span> 
		<span class="badge success"><?=$total_ready;?></span>
		<? } ?>
	</td>
	<td class="center"><?=$total_minutes/60;?></td>
	<td class="center">$<?=money_format('%i', $total_amount);?></td>
	<td></td>
	<td class="center">
		<div class="btn-group">
		<? if ($processing) { ?>
			<button type="button" onclick="add_job_to_invoice(<?=$job['job_id'];?>, true)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="remove_job_from_invoice(<?=$job['job_id'];?>, true)" class="btn btn-default btn-no">No</button>
		<? } else { ?>
			<button type="button" onclick="add_job_to_invoice(<?=$job['job_id'];?>, true)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="remove_job_from_invoice(<?=$job['job_id'];?>, true)" class="btn btn-danger btn-no">No</button>
		<? } ?>
		</div>
	</td>
</tr>