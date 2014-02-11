<div class="table_action">
	<ul class="nav nav-tabs tab-respond pull-right">
		<li><a class="load_week_view">&nbsp; <i class="fa fa-list"></i></a></li>
		<li><a class="load_month_view">&nbsp; <i class="fa fa-calendar"></i></a></li>
	</ul>
	
	<ul class="nav nav-tabs nav-action tab-respond">
		<li><a class="active" data-calendar-nav="today">Today</a></li>
	</ul>
	
	<ul class="nav nav-tabs nav-group tab-respond">
		<li class="active"><a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp;</a></li>
		<li class="active"><a id="header-month"> &nbsp; </a></li>
		<li class="active"><a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i> &nbsp;</a></li>
	</ul>
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