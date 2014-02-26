<div class="col-md-12">
	<div class="box top-box">
    	<div class="col-md-10 remove-left-padding">
        <h2>Company Calendar</h2>
        <p>As you create jobs they will plot to the company calendar below. All jobs in all job campaigns are displayed and colour coded based on "Un-filled, "Un-confirmed" or "Confirmed". Active jobs campaigns are show in charcoal. Click the numbers to quick jump to those jobs</p>
        </div>
        <div class="col-md-2 remove-left-padding">
        	<ul class="calendar-job-stat-legend">
            	<li>Active Job Campaigns <span class="badge badge-xs dark-grey-bg">1</span></li>
                <li>Unfilled Shifts <span class="badge badge-xs grey-bg">1</span></li>
                <li>Un-confirmed Shifts <span class="badge badge-xs danger">1</span></li>
                <li>Confirmed Shifts <span class="badge badge-xs success">1</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	<div class="company-calendar-actions">
                <div class="btn-group btn-nav company-calender-filter">
                    <button type="button" class="btn btn-core menu-label cc-filter-btn">Filter By Client</button>
                    <button type="button" class="btn btn-core dropdown-toggle cc-filter-btn" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li></li>
                   </ul>
                </div><!--end filter by client-->
                
                <div class="btn-group btn-nav company-calender-filter">
                    <button type="button" class="btn btn-core menu-label cc-filter-btn">Filter By State</button>
                    <button type="button" class="btn btn-core dropdown-toggle cc-filter-btn" data-toggle="dropdown">
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
$(function(){
	load_company_calendar(<?=$events_source?>);
})

function load_company_calendar(source)
{
	var options = {
		events_source:source,
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