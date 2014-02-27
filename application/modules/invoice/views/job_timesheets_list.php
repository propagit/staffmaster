<div class="menu-with-tab">
	<ul class="pagination pull-right">
			<li><a href="#">&laquo;</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&raquo;</a></li>
		</ul>
		
	<? #=modules::run('payrun/menu_dropdown_actions', 'action', 'Actions');?>
	<ul class="nav nav-tabs tab-respond">
		<li class="active"><a><?=$client['company_name'];?></a></li>
		<li><a onclick="list_clients()">All Clients</a></li>
	</ul>

</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<?=modules::run('invoice/row_job', $job['job_id']);?>
	<? foreach($timesheets as $timesheet) { echo modules::run('invoice/row_timesheet', $timesheet['timesheet_id']); } ?>
</table>
</div>