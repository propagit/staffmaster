<h4>Jobs On Month</h4>
<p>Below you can see a schedule of all the jobs you have on for the month for this job campaign.You can duplicate the months shifts to another month. Unconfirmed and confirmed shifts are indicated by red or green icon. </p>
<div class="table_action">
	<?=modules::run('common/dropdown_actions','');?>
	<div class="btn-group">
		<a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
		<span type="button" class="btn btn-info" id="header-month"> &nbsp; </span>
		<a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
	</div>
	
	<a data-calendar-nav="today" type="button" class="btn btn-primary">Today</a>
	<a type="button" class="btn btn-primary load_week_view"><i class="fa fa-list"></i></a>
	<a type="button" class="btn btn-primary load_month_view"><i class="fa fa-calendar"></i></a>

</div>
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
			//$('.btn-group button').removeClass('active');
			//$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
	};
	
	var calendar = $('#calendar').calendar(options);
	$('a[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});
	$('*[data-cal-date]').click(function() {
		load_job_shifts(<?=$job_id;?>, $(this).data('cal-date'), true);
		//var view = $(this).data('cal-view');
		//if(!self.options.views[view].enable) {
		//	return;
		//}
		//self.options.day = $(this).data('cal-date');
		//self.view(view);
	});
	
	
	$('.load_month_view').click(function(){
		load_month_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	$('.load_week_view').click(function(){
		load_week_view(<?=$job_id;?>, <?=$custom_date;?>);
	});
	
})
</script>