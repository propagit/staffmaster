<tr class="row-open job_client_<?=$user_id;?>">
	<td><input type="checkbox" /></td>
	<td>Campaign Name</td>
	<td class="center" width="120">Billable</td>
	<td class="center" width="200">Time Sheets</td>
	<td class="center" width="120">Expenses</td>
	<td class="center" width="120">Amount</td>
	<td class="center" width="120">Add To Invoice</td>
	<td width="40"></td>
</tr>
<? foreach($jobs as $job){ ?>
<tr class="success job_client_<?=$user_id;?>" id="job_client_<?=$job['job_id'];?>">
	<?=modules::run('invoice/row_client_job', $job['job_id']);?>	
</tr>
<? } ?>