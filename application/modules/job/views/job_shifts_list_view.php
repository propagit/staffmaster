<h2>Jobs On Date</h2>
<p>All shifts for this job campaign are displayed below. Using the checkbox to select shifts will allow you to perform group functions such as delete, duplicate, assign staff, assign briefs or surveys and many other functions</p>

<!-- Split button -->

<br />
<div class="table_action">
	<?=modules::run('common/dropdown_actions','');?>
	<span onclick="load_job_shifts(<?=$job_id;?>)" class="btn btn-info">Total:  <?=$total_date;?> days and <?=modules::run('job/count_job_shifts', $job_id,null);?> shifts</span>
	<? foreach($job_dates as $date) { ?>
	<span onclick="load_job_shifts(<?=$job_id;?>,'<?=$date['job_date'];?>')" class="btn btn-day<?=($this->session->userdata('job_date') == $date['job_date']) ? '-active': '';?>">
		<?=date('d', strtotime($date['job_date']));?>
		<span class="month"><?=date('M', strtotime($date['job_date']));?></span>
		(<?=modules::run('job/count_job_shifts', $job_id, strtotime($date['job_date']));?>)
	</span>
	<? } ?>

	<span class="btn btn-info pull-right"><i class="fa fa-gears"></i> Settings</span>
</div>
<div class="table_settings">
	<form class="form-inline pull-left" role="form">
		<label>Search </label>
		<div class="form-group">
		<input type="text" class="form-control" placeholder="keywords...">
		</div>
	</form>

	<form class="form-inline pull-right" role="form">
		<label>Show Results</label>
		<div class="form-group">
			<select class="form-control">
				<option>10</option>
				<option>20</option>
			</select>
		</div>
	</form>

</div>
<table class="table table-bordered" width="100%">
<thead>
	<tr>
		<th class="center" width="5%"><input type="checkbox" /></th>
		<th>Venue</th>
		<th>Role</th>
		<th class="center">Start</th>
		<th class="center">Finish</th>
		<th class="center">Break</th>
		<th>Staff Assigned</th>
		<th class="center">Pay rate</th>
		<th class="center">Info</th>
		<th class="center">Copy</th>
		<th class="center" width="5%">Delete</th>
	</tr>
</thead>
<tbody>
	<? foreach($job_shifts as $shift) { ?>
	<tr>
		<td class="center"><input type="checkbox" /></td>
		<td><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></td>
		<td><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td class="center"><?=date('H:i', $shift['start_time']);?></td>
		<td class="center"><?=date('H:i', $shift['finish_time']);?></td>
		<td class="center"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		<td></td>
		<td></td>
		<td class="center"><i class="fa fa-edit"></i></td>
		<td class="center"><i class="fa fa-copy"></i></td>
		<td class="center"><i class="fa fa-trash-o"></i></td>
	</tr>
	<? } ?>
</tbody>
</table>