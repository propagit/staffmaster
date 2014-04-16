<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
			<a class="btn btn-core" href="<?=base_url();?>timesheet/generate">Generate Timesheets</a>
		</div>
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become availble below for you to submit.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond">
				<li class="active"><a>Search Time Sheets</a></li>
				<li class="pull-right"><a href="<?=base_url();?>invoice">Client Invoices</a></li>
				<li class="pull-right"><a href="<?=base_url();?>expense">Staff Expenses</a></li>
				<li class="pull-right"><a href="<?=base_url();?>payrun">Pay Run</a></li>
				<li class="pull-right active"><a>Time Sheets</a></li>
			</ul>
			<br />
			<h2>Find Time Sheets</h2>
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are diplayed red.</p>
			<br />
			
			<?=modules::run('timesheet/search_form');?>
			
			<div id="list_timesheets"></div>
		</div>
	</div>
</div>
<!--end bottom box -->