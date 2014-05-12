<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
			<a class="btn btn-core mobile-tab" id="btn-generate">Generate Time Sheets</a>
		</div>
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become available below for you to submit.</p>
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
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are displayed red.</p>
			<br />
			
			<?=modules::run('timesheet/search_form');?>
			
			<div id="list_timesheets"></div>
		</div>
	</div>
</div>
<!--end bottom box -->
<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			Please wait a moment while we are generating time sheets ...
		</div>
	</div>
</div>
<script>
$(function(){
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
	$('#btn-generate').click(function(){
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>timesheet/ajax/generate_timesheets",
			success: function(html) {
				search_timesheets();
				setTimeout(function() {
					$('#waitingModal').modal('hide');
				}, 2000);				
			}
		})
	})
})
</script>