<h2>Work Summary</h2>
<p>Quick stats on whats up soon</p>
<div class="dash-daily-stats-row">
    <div class="counter small">
        <span class="completed-shift-count"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
    <div class="counter-label">
        Completed Shifts 
        <span class="pull">
            <button class="btn btn-core dash-ts-btn generate-timesheet-admin" type="button">Generate Timesheets Now</button>
        </span>
    </div>
</div>
<div class="dash-daily-stats-row">
    <div class="counter small">
        <span><?=$active_jobs;?></span>
    </div>
    <div class="counter-label">
        Active Campaigns (Today)
        <span class="pull">
        	<!-- <a href="<?=base_url();?>job/calendar"><i class="fa fa-calendar-o dash-stats-fa-icons"></i></a> -->
        	<a href="<?=base_url();?>dashboard/active_campaigns"><i class="fa fa-bars dash-stats-fa-icons"></i></a>
        </span>
    </div>
</div>
<div class="dash-daily-stats-row">
    <div class="counter small">
        <span><?=$today_shifts;?></span>
    </div>
    <div class="counter-label">
        Shifts On (Today) 
        <span class="pull">
        	<!-- <a href="<?=base_url();?>job/calendar"><i class="fa fa-calendar-o dash-stats-fa-icons"></i></a> -->
        	<a href="<?=base_url();?>dashboard/today_shifts"><i class="fa fa-bars dash-stats-fa-icons"></i></a>
        </span>
    </div>
</div>
<div class="dash-daily-stats-row">
    <div class="counter small">
        <span><?=$this_week_shifts;?></span>
    </div>
    <div class="counter-label">
        Shifts On (Week) 
        <span class="pull">
        	<!-- <a href="<?=base_url();?>job/calendar"><i class="fa fa-calendar-o dash-stats-fa-icons"></i></a> -->
        	<a href="<?=base_url();?>dashboard/this_week_shifts"><i class="fa fa-bars dash-stats-fa-icons"></i></a>
        </span>
    </div>
</div>
<div class="dash-daily-stats-row">
    <div class="counter small">
        <span><?=$this_month_shifts;?></span>
    </div>
    <div class="counter-label">
        Shifts On (Month) 
        <span class="pull">
        	<a href="<?=base_url();?>job/calendar"><i class="fa fa-calendar-o dash-stats-fa-icons"></i></a>
        	<a href="<?=base_url();?>dashboard/this_month_shifts"><i class="fa fa-bars dash-stats-fa-icons"></i></a>
        </span>
    </div>
</div>
