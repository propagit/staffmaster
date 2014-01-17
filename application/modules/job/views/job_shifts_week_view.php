<h4>Jobs On Week</h4>
<p>Below you can see a schedule of all the jobs you have on for the week for this job campaign. You can duplicate the weeks shifts to another week. Unconfirmed and confirmed shifts are indicated by red or green. </p>

<div class="table_action">
	<div class="btn-group">
		<?
		if (date('D', $custom_date) == 'Mon')
		{
			$start_date = $custom_date;
		}
		else
		{
			$start_date = strtotime('this week last monday', $custom_date);
		}
		$end_date = $start_date + 6*24*60*60;
		?>
		
		<a onclick="load_job_week(<?=$job_id;?>,<?=$custom_date;?>,-1)" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
		<button type="button" class="btn btn-info"><?=date('d M', $start_date);?> - <?=date('d M', $end_date);?></button>
		<a onclick="load_job_week(<?=$job_id;?>,<?=$custom_date;?>,1)" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
	</div>

	<button type="button" class="btn btn-info">Duplicate this week</button>
	<button type="button" class="btn btn-primary"><i class="fa fa-list"></i></button>
	<button type="button" class="btn btn-primary"><i class="fa fa-calendar"></i></button>

</div>
<table class="table table-bordered" width="100%">
<thead>
	<tr>
		<th class="center" width="10%"><input type="checkbox" /></th>
		<th class="center" width="20%">Date</th>
		<th class="center">Job shifts</th>
		<th class="center">Allocated</th>
		<th class="center" width="5%">Copy</th>
		<th class="center" width="5%">Delete</th>
	</tr>
</thead>
<tbody>
<? for($i=0; $i < 7; $i++) { 
$date_ts = $start_date + 24*60*60*$i; 
$shifts_count = modules::run('job/count_job_shifts', $job_id, $date_ts);
?>
	<tr<?=($shifts_count > 0) ? ' class="active"' : '';?>>
		<td class="center"><input type="checkbox" /></td>
		<td>
			<span onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>')" class="btn btn-<?=($shifts_count == 0) ? 'default' : 'day'; ?><?=($this->session->userdata('job_date') == date('Y-m-d',$date_ts)) ? '-active': '';?> btn-block"><?=date('D d M', $date_ts);?></span>
		</td>
		<td class="center"><?=$shifts_count;?></td>
		<td></td>
		<td><i class="fa fa-copy"></i></td>
		<td><i class="fa fa-trash-o"></i></td>
	</tr>
<? } ?>
</tbody>
</table>