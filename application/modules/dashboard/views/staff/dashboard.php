<div class="col-md-12">
	<div class="box top-box">
		<h2>Your Dashboard</h2>
		<p>Welcome to your Staff Account dashboard. Your Dashboard will give you a quick overview of activity going on within <?=$company['company_name']?>. Check back regularly to keep yourself up to date.</p>
	</div>
</div>


<div class="col-md-12">
	<div class="box bottom-box">
        
        <div class="col-md-6 white-box">
            <?=modules::run('dashboard/dashboard_staff/conversation');?>
        </div>
        
        <div class="col-md-6 white-box">		
            <?=modules::run('dashboard/dashboard_staff/activity_log');?>		
        </div>
        
	</div>
</div>
