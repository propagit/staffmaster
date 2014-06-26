<? if (count($clients) == 0) { ?>
	<div class="alert alert-warning">No billable works</div>
<? } else { ?>
<div id="nav_clients">
	<? #=modules::run('payrun/menu_dropdown_actions', 'action', 'Actions');?>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"></th>
		<th colspan="5">Client Name</th>
		<th class="center" width="120">Campaigns</th>
		<th class="center" width="40">
		</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($clients as $client) { ?>
	<tr id="jobs_client_<?=$client['user_id'];?>">
		<td><input type="checkbox" /></td>
		<td colspan="5"><?=$client['company_name'];?></td>
		<td class="center"><?=$client['total_jobs'];?></td>
		<td>
			<a class="wp-arrow" onclick="load_client_jobs(<?=$client['user_id'];?>)"><i class="fa fa-plus-square-o"></i></a>
		</td> 
	</tr>
	<? } ?>
	</tbody>
</table>
</div>

<script>
$(function(){
	//load_client_jobs(<?=$clients[0]['user_id'];?>);
});

</script>
<? } ?>