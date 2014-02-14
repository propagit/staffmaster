<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($jobs);?></b> results</p>
<? if (count($jobs) > 0) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="65">Start </th>
		<th class="center" width="65">Finish </th>
		<th>Client &nbsp; <a onclick="sort_jobs('client_')"><i class="fa fa-sort"></i></a></th>
		<th>Campaign Name &nbsp; <a onclick="sort_jobs('campaign')"><i class="fa fa-sort"></i></a></th>
		<th class="center">Total Shifts</th>
		<th class="center">Unassigned</th>
		<th class="center">Unconfirmed</th>
		<th class="center">Confirmed</th>
		<th class="center">Billing Status</th>
		<th class="center" width="40">View</th>
		<th class="center" width="40">Delete</th>
	</tr>
	</thead>
	<? foreach($jobs as $job) { 
		$client = modules::run('client/get_client', $job['client_id']); 
		$start_time = modules::run('job/get_job_start_date', $job['job_id']);
		$finish_time = modules::run('job/get_job_finish_date', $job['job_id']);
		$shifts_count = modules::run('job/count_job_shifts', $job['job_id']);
		$unassign = modules::run('job/count_job_shifts', $job['job_id'], null, '0');
		$unconfirmed = modules::run('job/count_job_shifts', $job['job_id'], null, 1);
		$confirmed = modules::run('job/count_job_shifts', $job['job_id'], null, 2);
	?>
	<tr>
		<td width="65" class="center">
			<? if ($start_time) { ?>
			<span class="wk_day"><?=date('D', $start_time);?></span>
			<span class="wk_date"><?=date('d', $start_time);?></span>
			<span class="wk_month"><?=date('M', $start_time);?></span>
			<? } ?>
		</td>
		<td>
			<? if ($finish_time) { ?>
			<span class="wk_day"><?=date('D', $finish_time);?></span>
			<span class="wk_date"><?=date('d', $finish_time);?></span>
			<span class="wk_month"><?=date('M', $finish_time);?></span>
			<? } ?>	
		</td>
		<td><?=$client['company_name'];?></td>
		<td><?=$job['name'];?></td>
		<td class="center"><?=$shifts_count;?></td>
		<td class="center"><span class="badge"><?=$unassign;?></span></td>
		<td class="center"><span class="badge danger"><?=$unconfirmed;?></span></td>
		<td class="center"><span class="badge success"><?=$confirmed;?></span></td>
		<td></td>
		<td class="center"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>"><i class="fa fa-eye"></i></a></td>
		<td class="center">
			<a onclick="delete_job(<?=$job['job_id'];?>)"><i class="fa fa-times"></i></a>
		</td>
	</tr>
	<? } ?>
</table>
</div>
<? } ?>

<script>
function delete_job(job_id) {
	var title = 'Delete Job';
	var message ='All shifts and timesheet within this job will be deleted completely. Are you sure you want to delete this job?';
	help.confirm_delete(title,message,function(confirmed){
		if(confirmed){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>job/ajax/delete_job",
				data: {job_id: job_id},
				success: function(html) {
					search_jobs();
				}
			})
		}
	});
}
</script>