<!--calendar nav-->
<div id="nav_month_shifts" class="company-calendar-nav-wrap">
	<div class="btn-group btn-nav">
		<ul class="nav nav-tabs tab-respond">
			<li class="active first-child"><a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp;</a></li>
			<li class="active mid-child"><a id="header-company-calendar-month"> &nbsp; </a></li>
			<li class="active last-child"><a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i> &nbsp;</a></li>
		</ul>
	</div>
</div>
<!-- end calendar nav-->
<div class="clearfix"></div>
<div id="company-calendar"></div>


<script>
$(function(){
	var options = {
		events_source:<?=$events_source;?>,
		view: 'month',
		tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/company_calendar/",
		tmpl_cache: false,
		day: '<?=date('Y-m-d',strtotime($custom_date));?>',
		onAfterViewLoad: function(view) {
			$('#header-company-calendar-month').text(this.getTitle());
		}
	};
	
	var calendar = $('#company-calendar').calendar(options);
	
	$('a[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
			get_month_data($('#header-company-calendar-month').html());
		});
	});

});//ready



</script>