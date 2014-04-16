<div id="nav_month_shifts">
	<div class="btn-group btn-nav">
		<ul class="nav nav-tabs tab-respond">
			<li class="pull-right"><a class="load_week_view"><i class="fa fa-list"></i></a></li>
			<li class="active"><a data-calendar-nav="today">Today</a></li>
			<li class="active first-child"><a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i></a></li>
			<li class="active mid-child"><a id="header-month"></a></li>
			<li class="active last-child"><a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i></a></li>
		</ul>
	</div>
</div>

<div class="clearfix"></div>
<div id="calendar"></div>


<script>
$(function(){
	var options = {
		events_source: <?=$events_source;?>,
		view: 'month',
		tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/tmpls/",
		tmpl_cache: false,
		day: '<?=date('Y-m-d', $custom_date);?>',
		onAfterViewLoad: function(view) {
			$('#header-month').text(this.getTitle());
		},
	};
	
	var calendar = $('#calendar').calendar(options);
	$('a[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
			$('*[data-cal-date]').parent().click(function() {
				load_job_shifts(<?=$job_id;?>, $(this).find('[data-cal-date]').data('cal-date'));
			});
		});
	});
	$('*[data-cal-date]').parent().click(function() {
		load_job_shifts(<?=$job_id;?>, $(this).find('[data-cal-date]').data('cal-date'));
	});
	
	
	$('.load_month_view').click(function(){
		load_month_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	$('.load_week_view').click(function(){
		load_week_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	
})
</script>