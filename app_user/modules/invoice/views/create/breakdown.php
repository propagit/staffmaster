<div class="col-md-12">
	<div class="wp-page-invoice">
		<table width="100%">
			<? foreach($items as $item) { 
			if ($item['include_timesheets']) {
			$job = modules::run('job/get_job', $item['job_id']);
			#$timesheets = modules::run('invoice/get_job_timesheets', $item['job_id'], INVOICE_READY);
			$timesheets = modules::run('invoice/get_invoice_timesheets', $item['invoice_id'], $item['job_id']);
			 ?>
			 
			<? if ($job) { ?>
			<tr>
				<td colspan="8"><h2><?=$job['name'];?></h2></td>
			</tr>
			<? } ?>
			
			<? if (count($timesheets) > 0) { ?>
			<tr>
				<td>Job Date</td>
				<td>Venue</td>
				<td>Start Time - Finish Time</td>
				<td>Break</td>
				<td>Hours</td>
				<td>Pay Rate</td>
				<td>Total</td>
			</tr>
			<? foreach($timesheets as $timesheet) { 
				$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
			?>
			<tr>
                <td width="10%"><?=date('d-m-Y', $timesheet['start_time']);?></td>
                <td width="30%"><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></td>
                <!-- <td width="15%"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></td> -->
                <td width="20%"><?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?> <?=(date('d', $timesheet['finish_time']) != date('d', $timesheet['start_time'])) ? '<span class="text-danger">*</span>': '';?></td>
                <td width="10%"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
                <td width="10%"><?=$timesheet['total_minutes']/60;?></td>
                <td width="10%"><?=modules::run('attribute/payrate/display_payrate', ($timesheet['client_payrate_id'] > 0) ? $timesheet['client_payrate_id'] : $timesheet['payrate_id']);?></td>
                <td width="10%">$<?=$timesheet['total_amount_client'];?></td>
            </tr>
			<? } } ?>
			<? } } ?>                       
        </table>
	</div>
</div>