<!-- end calendar nav-->
<div class="clearfix"></div>
<div id="company-calendar"></div>

<script>
$(function(){
	calendar = $('#company-calendar').calendar({
		events_source:<?=$events_source;?>,
		view: 'month',
		tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/company_calendar/",
		tmpl_cache: false,
		day: '<?=$custom_date;?>',
        first_day: 1,
		onAfterViewLoad: function(view) {
			$('#header-company-calendar-month').text(this.getTitle());
		}
	});
});
</script>
