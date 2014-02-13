<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
			<a class="btn btn-core" href="<?=base_url();?>timesheet/generate">Generate Timesheets</a>
			&nbsp; 
			<a class="btn btn-danger" href="<?=base_url();?>timesheet/truncate">Clean Timesheeets</a>
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
			<h2>Find Time Sheets</h2>
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are diplayed red.</p>
			<br />
			
			<?=$this->load->view('list_view', isset($data) ? $data : NULL);?>
		</div>
	</div>
</div>
<!--end bottom box -->