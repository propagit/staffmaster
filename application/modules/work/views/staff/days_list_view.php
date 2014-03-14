<? foreach($work_days as $day) { ?>
<div id="wp-<?=$day['job_date'];?>">
	<div class="row pointer" onclick="load_day_shifts('<?=$day['job_date'];?>')">
		<div class="col-md-1 col-xs-1 wp-date">
			<span class="wk_day"><?=date('D', strtotime($day['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($day['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($day['job_date']));?></span>
		</div>
		<div class="col-md-9 col-xs-8 wp-job">
			<span class="hidden-xs hidden-sm">Jobs available &nbsp; </span><a class="badge danger"><?=$day['shifts_count'];?></a>
			&nbsp;
			<? $applied = modules::run('work/work_staff/count_applied_shifts', $day['job_date']); ?>
			<? if ($applied > 0) { ?>
			<span class="hidden-xs hidden-sm">Job you have applied for &nbsp; </span><a class="badge success"><?=$applied;?></a>
			<? } ?>
		</div>
		<div class="col-md-1 col-xs-1 wp-arrow">
			<i class="fa fa-plus-square-o fa-1x"></i>
		</div>
	</div>
	<div class="day_shifts" id="day-<?=$day['job_date'];?>"></div>
</div>
<? } ?>
<script>
$(function() {
	<? $open_days = $this->session->userdata('open_days'); if ($open_days) foreach($open_days as $open_day) { ?>
	load_day_shifts('<?=$open_day;?>');
	<? } ?>
})

function load_day_shifts(date)
{
	preloading($('#day-' + date));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>work/ajax/load_day_shifts",
		data: {date: date},
		success: function(html) {
			loaded($('#day-' + date), html);
			$('#wp-' + date).find('.row').addClass('row-open');
			$('#wp-' + date).find('.row').attr('onclick', 'hide_day_shifts(\'' + date + '\')');
			$('#wp-' + date).find('.row .wp-arrow').html('<i class="fa fa-minus-square-o"></i></a>');
		}
	})
}
function hide_day_shifts(date)
{
	preloading($('#day-' + date));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>work/ajax/hide_day_shifts",
		data: {date: date},
		success: function(html) {
			$('#day-' + date).html('');
			$('#wp-' + date).find('.row').removeClass('row-open');
			$('#wp-' + date).find('.row').attr('onclick', 'load_day_shifts(\'' + date + '\')');
			$('#wp-' + date).find('.row .wp-arrow').html('<i class="fa fa-plus-square-o"></i></a>');
		}
	})	
}
</script>