<div class="col-md-12">
	<div class="box top-box">
        <h2>Company Calendar</h2>
        <p>As you create jobs they will plot to the company calendar below. All jobs in all job campaigns are displayed and colour coded based on "Un-filled, "Un-confirmed" or "Confirmed". Active jobs campaigns are show in charcoal. Click the numbers to quick jump to those jobs</p>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	<div class="company-calendar-actions">
                <div class="btn-group btn-nav company-calender-filter">
                    <button type="button" class="btn btn-core menu-label">Filter By Client</button>
                    <button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li></li>
                   </ul>
                </div><!--end filter by client-->
                
                <div class="btn-group btn-nav company-calender-filter">
                    <button type="button" class="btn btn-core menu-label">Filter By State</button>
                    <button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li></li>
                   </ul>
                </div><!--end filter by state-->
                
                <!--calendar nav-->
                <div class="calendar-nav-wrap">
                    <ul class="nav nav-tabs nav-group tab-respond company-calendar-nav-tab">
                        <li class="active"><a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp;</a></li>
                        <li class="active"><a id="header-company-calendar-month"> &nbsp; </a></li>
                        <li class="active"><a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i> &nbsp;</a></li>
                    </ul>
                </div>
                <!-- end calendar nav-->
            </div>
        	<div class="clearfix"></div>
           <div id="company-calendar"></div>
        </div><!--inner box-->
	</div><!--box-->
</div>
<script>
<?php 
	$date = '2014-02-22';
	$event_date = strtotime($date) . '000';
?>
$(function(){
	load_company_calendar();
	
})

function load_company_calendar()
{
	var options = {
		events_source: [
        {
            "id": 293,
            "title": "Event 1",
            "url": "http://example.com",
            "class": "event-important",
            "start": <?=$event_date;?>, // Milliseconds
            "end": <?=$event_date;?> // Milliseconds
        }],
		view: 'month',
		tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/company_calendar/",
		tmpl_cache: false,
		day: '<?=date('Y-m-d');?>',
		onAfterViewLoad: function(view) {
			$('#header-company-calendar-month').text(this.getTitle());
		},
	};
	
	var calendar = $('#company-calendar').calendar(options);	
}
</script>



