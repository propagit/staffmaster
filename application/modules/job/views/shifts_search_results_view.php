<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($shifts);?></b> results</p>
<? if (count($shifts) > 0) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="80">Date &nbsp; <a onclick="sort_search_shifts('date')"><i class="fa fa-sort"></i></a></th>
		<? if (!modules::run('auth/is_client')) { ?>
		<th>Client &nbsp; <a onclick="sort_search_shifts('client')"><i class="fa fa-sort"></i></a></th>
		<? } ?>
		<th>Campaign Name &nbsp; <a onclick="sort_search_shifts('campaign')"><i class="fa fa-sort"></i></a></th>
		<th>Venue &nbsp; <a onclick="sort_search_shifts('venue')"><i class="fa fa-sort"></i></a></th>
		<th>Role &nbsp; <a onclick="sort_search_shifts('role')"><i class="fa fa-sort"></i></a></th>
		<th class="center" width="120">Start - Finish</th>
		<th>Staff Assigned &nbsp; <a onclick="sort_search_shifts('status')"><i class="fa fa-sort"></i></a></th>
		<th class="center" width="40">View</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { $client = modules::run('client/get_client', $shift['client_id']); ?>
	<tr class="<?=modules::run('job/status_to_class', $shift['status']);?>">
		<td class="wp-date" width="70">
			<span class="wk_day"><?=date('D', strtotime($shift['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($shift['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($shift['job_date']));?></span>
		</td>
		<? if (!modules::run('auth/is_client')) { ?>
		<td><?=$client['company_name'];?></td>
		<? } ?>
		<td><?=$shift['job_name'];?></td>
		<td><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></td>
		<td><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td class="center"><?=date('H:i', $shift['start_time']);?> - <?=date('H:i', $shift['finish_time']);?><?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="text-red">*</span>': '';?></td>
		<td>
			<? if($shift['staff_id']) { $staff = modules::run('staff/get_staff', $shift['staff_id']); 
				echo $staff['first_name'] . ' ' . $staff['last_name'];				
			?>
			<? } else { ?>
			No Staff Assigned
			<? } ?>
		</td>
		<td class="center" width="40"><a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>"><i class="fa fa-eye"></i></a></td>
	</tr>
	<? } ?>
	</tbody>
</table>
<? } ?>