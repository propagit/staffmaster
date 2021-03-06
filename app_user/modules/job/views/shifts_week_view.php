<div id="nav_week_shifts">
	<?
	if (!$is_client)
	{
		# Action menu
		$data = array(
			array('value' => 'delete', 'label' => '<i class="fa fa-times"></i> Delete Shifts')
		);
		echo modules::run('common/menu_dropdown', $data, 'week-action', 'Actions');	
	}
	?>
	<div class="btn-group btn-nav">
		<ul class="nav nav-tabs tab-respond">
			<li class="pull-right"><a class="load_month_view"><i class="fa fa-calendar"></i></a></li>
			<li class="active first-child"><a step="-1" type="button" class="btn btn-info load_job_week"><i class="fa fa-arrow-left"></i> &nbsp;</a></li>
			<?
			if (date('D', $custom_date) == 'Mon') {
				$start_date = $custom_date;
			} else {
				$start_date = strtotime('this week last monday', $custom_date);
			}
			$end_date = $start_date + 6*24*60*60;
			?>
			<li class="active mid-child"><a><?=date('d M y', $start_date);?> - <?=date('d M y', $end_date);?></a></li>
			<li class="active last-child"><a step="1" type="button" class="btn btn-info load_job_week"><i class="fa fa-arrow-right"></i> &nbsp;</a></li>
		</ul>
	</div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<? if (!$is_client) { ?>
		<th class="center" width="20"><input type="checkbox" id="selected_all_days" /></th>
		<? } ?>
		<th class="center" width="80">Date</th>
		<th class="center">Unassigned</th>
		<th class="center">Unconfirmed</th>
		<th class="center">Rejected</th>
		<th class="center">Confirmed</th>
		<? if (!$is_client) { ?>
		<th class="center" colspan="2">Functions</th>
		<? } else { ?>
		<th class="center">Functions</th>
		<? } ?>
	</tr>
</thead>
<tbody>
<? for($i=0; $i < 7; $i++) { 
$date_ts = $start_date + 24*60*60*$i; 
#$shifts_count = modules::run('job/count_job_shifts', $job_id, $date_ts);
$unassign = modules::run('job/count_job_shifts', $job_id, $date_ts, '0');
$unconfirmed = modules::run('job/count_job_shifts', $job_id, $date_ts, SHIFT_UNCONFIRMED);
$rejected = modules::run('job/count_job_shifts', $job_id, $date_ts, SHIFT_REJECTED);
$confirmed = modules::run('job/count_job_shifts', $job_id, $date_ts, SHIFT_CONFIRMED);
$completed = modules::run('job/count_job_shifts', $job_id, $date_ts, SHIFT_FINISHED); 
$shifts_count = $unassign + $unconfirmed + $rejected + $confirmed;
$ids = modules::run('job/get_day_shifts', $job_id, $date_ts);
?>
	<tr>
		<? if (!$is_client) { ?>
		<td class="center">
			<? if ($shifts_count > 0) { ?>
			<input type="checkbox" class="selected_shift_days" value="<?=implode(',', $ids);?>" />
			<? } ?>
		</td>
		<? } ?>
		<td class="wp-date" width="80">
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', <?=($shifts_count > 0) ? 'true' : 'false';?>)" class="<?=($shifts_count == 0) ? 'default' : ''; ?><?=($this->session->userdata('job_date') == date('Y-m-d',$date_ts) && ($shifts_count != 0)) ? ' active': '';?>">
				<span class="wk_day"><?=date('D', $date_ts);?></span>
				<span class="wk_date"><?=date('d', $date_ts);?></span>
				<span class="wk_month"><?=date('M', $date_ts);?></span>
				
			</a>
		</td>
		<td class="center">
			<? if ($unassign > 0) { ?>
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', true)" class="badge"><?=$unassign;?></a>
			<? } ?>
		</td>
		<td class="center">
			<? if ($unconfirmed > 0) { ?>
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', true)" class="badge warning"><?=$unconfirmed;?></a>
			<? } ?>
		</td>
		<td class="center">
			<? if ($rejected > 0) { ?>
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', true)" class="badge danger"><?=$rejected;?></a>
			<? } ?>
		</td>
		<td class="center">
			<? if ($confirmed > 0) { ?>
			<a onclick="load_job_shifts(<?=$job_id;?>,'<?=date('Y-m-d', $date_ts);?>', true)" class="badge success"><?=$confirmed;?></a> 
			<? } ?>
		</td>
		<td class="center" width="40">
			<? if ($shifts_count > 0) { ?>
			<a class="day_shift_copy" data-toggle="modal" data-target="#copy_shift" href="<?=base_url();?>job/ajax/load_shifts_copy/<?=implode('~', $ids);?>"><i class="fa fa-copy"></i></a>
			<? } ?>
		</td>
		<? if (!$is_client) { ?>
		<td class="center" width="40">
			<? if ($shifts_count > 0) { ?>
			<a class="day_shift_delete" data-shifts="<?=implode(',', $ids);?>"><i class="fa fa-trash-o"></i></a>
			<? } ?>
		</td>
		<? } ?>
	</tr>
<? } ?>
</tbody>
</table>
</div>
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
	$('.day_shift_delete').confirmModal({
		confirmTitle: 'Delete this day shifts',
		confirmMessage: 'Are you sure you want to delete all shifts in this day?',
		confirmCallback: function(e){
			var shifts = $(e).attr('data-shifts');
			delete_shifts(shifts.split(','));
		}
	});
	var selected_shifts_day = new Array();
	var s = null;
	$('#selected_all_days').click(function(){
		$('input.selected_shift_days').prop('checked', this.checked);		
	});
	$('#menu-week-action ul li a[data-value="delete"]').confirmModal({
		confirmTitle: 'Delete days shifts',
		confirmMessage: 'Are you sure you want to delete all shifts in selected days?',
		confirmCallback: function(e) {
			selected_shifts_day.length = 0;
			$('.selected_shift_days:checked').each(function(){
				s = $(this).val();
				selected_shifts_day = $.merge(selected_shifts_day, s.split(','));
			});
			delete_shifts(selected_shifts_day);
		}
	});
})
</script>