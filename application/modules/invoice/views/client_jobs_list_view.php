<tr class="row-open job_client_<?=$user_id;?>">
	<td><input type="checkbox" /></td>
	<td>Campaign Name</td>
	<td class="center">Time Sheets</td>
	<td class="center">Expenses</td>
	<td class="center">Total Amount</td>
	<td class="center">Add To Invoice</td>
	<td></td>
</tr>
<? foreach($jobs as $job){ ?>
<tr class="success job_client_<?=$user_id;?>" id="job_client_<?=$job['job_id'];?>">
	<?=modules::run('invoice/row_client_job', $job['job_id']);?>
</tr>
<? } ?>