<div class="col-md-12">
	<div class="box top-box">
		<h2>Your Dashboard</h2>
		<p>Welcome to your Staff Account dashboard. Your Dashboard will give you a quick overview of activity going on within [COMPANY PROFILE NAME]. Check back regularly to keep yourself up to date.</p>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<h2>Conversations</h2>
			<p>Join the conversation and get involved!</p>
		</div>
	</div>
	
	<div class="col-md-6">
		
        <?=modules::run('dashboard/dashboard_staff/activity_log');?>
		
	</div>
</div>

</div>