<h4>Jobs On Week</h4>
<p>Below you can see a schedule of all the jobs you have on for the week for this job campaign. You can duplicate the weeks shifts to another week. Unconfirmed and confirmed shifts are indicated by red or green. </p>

<div class="table_action">
	
	<?=modules::run('common/dropdown_actions','');?>
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
		
		<a step="-1" type="button" class="btn btn-info load_job_week"><i class="fa fa-arrow-left"></i></a>
		<button type="button" class="btn btn-info"><?=date('d M', $start_date);?> - <?=date('d M', $end_date);?></button>
		<a step="1" type="button" class="btn btn-info load_job_week"><i class="fa fa-arrow-right"></i></a>
	</div>
	
	<!-- <a type="button" class="btn btn-primary">Today</a> -->
	<a type="button" class="btn btn-primary load_week_view"><i class="fa fa-list"></i></a>
	<a type="button" class="btn btn-primary load_month_view"><i class="fa fa-calendar"></i></a>

</div>
<table class="table table-bordered table-hover" width="100%">
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
	<tr<? #=($shifts_count > 0) ? ' class="active"' : '';?>>
		<td class="center"><input type="checkbox" /></td>
		<td>
			<span onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', <?=($shifts_count > 0) ? 'true' : 'false';?>)" class="btn btn-<?=($shifts_count == 0) ? 'default' : 'day'; ?><?=($this->session->userdata('job_date') == date('Y-m-d',$date_ts) && ($shifts_count != 0)) ? '-active': '';?> btn-block"><?=date('D d M', $date_ts);?></span>
		</td>
		<td class="center"><?=($shifts_count > 0) ? $shifts_count : '';?></td>
		<td class="center">
			<? if ($shifts_count > 0) { ?>
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', true)"><span class="badge badge-success">0</span> &nbsp; 
			<span class="badge badge-danger"><?=$shifts_count;?></span></a>
			<? } ?>
		</td>
		<td class="center">
			<? if ($shifts_count > 0) { ?>
			<i class="fa fa-copy"></i>
			<? } ?>
		</td>
		<td class="center">
			<? if ($shifts_count > 0) { ?>
			<a class="day_shift_delete" data-date="<?=$date_ts;?>"><i class="fa fa-trash-o"></i></a>
			<? } ?>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<script>
$(function(){
	$('.load_job_week').click(function(){
		var step = $(this).attr('step');
		$.ajax({
			type: "POST",
			url: base_url + 'job/ajax/load_job_week',
			data: { date: <?=$custom_date;?>, step: step},
			success: function(html)
			{
				load_job_shifts(<?=$job_id;?>, html);
			}
		})
	});
	$('.load_month_view').click(function(){
		load_month_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	$('.load_week_view').click(function(){
		load_week_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	$('.day_shift_delete').click(function(){
		var date = $(this).attr('data-date');
		if (confirm('Are you sure you want to delele all shifts in this day?')) {
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>job/ajax/delete_day_shift",
				data: {job_id: <?=$job_id;?>, date: date},
				success: function(data) {
					data = $.parseJSON(data);
					load_job_shifts(data.job_id, data.job_date, false);
				}
			})
		}
	})
})
</script>