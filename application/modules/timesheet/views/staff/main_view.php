<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become availble below for you to submit.</p>
		<br />
		<a class="btn btn-core" href="#">Generate Timesheets</a>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			
			<h2>Your Time Sheets</h2>
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are diplayed red.</p>
			<br />
			<? if (count($supervised_timesheets) > 0) { ?>
			<!-- <a class="btn btn-core">Your Supervised Timesheets</a> -->
			<? } ?>
			
			<div id="list_timesheets">
			</div>
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
$(function(){
	list_timesheets();
})

function list_timesheets() {
	preloading($('#list_timesheets'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/list_timesheets",
		success: function(html) {
			loaded($('#list_timesheets'), html);
		}
	})
}
</script>