<?
$total_amount = 0;
$total_expenses = 0;
$total_ready = 0;
$processing = true;
$billable = 0;
foreach($timesheets as $timesheet) {	
	$billable += $timesheet['total_amount_client'];
	if ($timesheet['status_invoice_client'] == INVOICE_READY) {
		$total_ready++;
		$total_amount += $timesheet['total_amount_client'];
		$total_expenses += $timesheet['expenses_client_cost'];
	} else {
		$processing = false;
	}
}
?>

<tr class="success job_client_<?=$job['client_id'];?>" id="job_client_<?=$job['job_id'];?>">
	<td width="20"><input type="checkbox" /></td>
	<td><?=$job['name'];?></td>
	<td class="center">$<?=money_format('%i', $billable);?></td>
	<td class="center">
		<? if (count($timesheets) == $total_ready) { ?>
		<span class="badge success"><?=$total_ready;?></span>
		<? } else if($total_ready == 0) { ?>
		<span class="badge danger"><?=count($timesheets);?></span> 
		<? } else { ?>
		<span class="badge danger"><?=count($timesheets) - $total_ready;?></span> 
		<span class="badge success"><?=$total_ready;?></span>
		<? } ?>
	</td>
	<td class="center">
		$<?=money_format('%i', $total_expenses);?>
	</td>
	<td class="center">$<?=money_format('%i', $total_amount);?></td>
	<td class="center">
		<div class="btn-group">
		<? if ($processing) { ?>
			<button type="button" onclick="add_job_to_invoice(<?=$job['job_id'];?>)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="remove_job_from_invoice(<?=$job['job_id'];?>)" class="btn btn-default btn-no">No</button>
		<? } else { ?>
			<button type="button" onclick="add_job_to_invoice(<?=$job['job_id'];?>)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="remove_job_from_invoice(<?=$job['job_id'];?>)" class="btn btn-danger btn-no">No</button>
		<? } ?>
		</div>
	</td>
	<td width="40">
		<a onclick="load_job_timesheets(<?=$job['job_id'];?>)"><i class="fa fa-plus-square-o"></i></a>
	</td>
</tr>