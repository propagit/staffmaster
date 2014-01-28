<table class="table table-bordered table-hover">
	<thead>
	<tr class="heading">
		<td class="center" width="10%">Job ID</td>
		<td class="left">Job Group Name</td>
		<td class="left">Client</td>
		<td class="center">Date</td>
		<td class="center">Venue</td>
		<td class="center" width="10%">Total shifts</td>
		<td class="center" width="10%"><i class="icon-thumb-up"></i> Status</td>
		<td class="center" width="10%">View Job</td>
	</tr>
	</thead>
	<? foreach($jobs as $job) { $client = modules::run('client/get_client', $job['client_id']); ?>
	<tr>
		<td class="center"><?=sprintf('%03d', $job['job_id']);?></td>
		<td class="left">
			<?=$job['name'];?>
			<br />
			
		</td>
		<td class="left"><?=$client['company_name'];?></td>
		<td></td>
		<td class="center"></td>
		<td class="center"><?=modules::run('job/count_job_shifts', $job['job_id'],null);?></td>
		<td class="center"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>" class="btn btn-danger">Unconfirmed</a></td>
		<td class="center"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>"><i class="fa fa-eye"></i></a></td>
	</tr>
	<? } ?>
</table>
