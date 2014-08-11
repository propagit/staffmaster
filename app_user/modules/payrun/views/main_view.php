<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Pay Run</h2>
		<p>Create a pay run and export it to your favourite accounts package. Time sheets have been batched together by staff name. Set the status of the time sheets you would like to process to “Pay Now”, and use the filters to create your pay run for export.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond" id="tab-payrun">
				<li class="active"><a href="#create-payrun" data-toggle="tab">Create Pay Run</a></li>
				<li><a href="#search-payrun" data-toggle="tab">Search Pay Run</a></li>
				<li><a href="#search-payslip" data-toggle="tab">Find Processed Time Sheets</a></li>
				<li class="pull-right">
					<a href="<?=base_url();?>invoice">Client Invoices</a>
				</li>
				<li class="pull-right"><a href="<?=base_url();?>expense">Staff Expenses</a></li>
				<li class="pull-right active"><a href="<?=base_url();?>payrun">Pay Run</a></li>
				<li class="pull-right">
					<a href="<?=base_url();?>timesheet">Time Sheets</a>
				</li>
			</ul>
			<br />
			
			<div class="tab-content">
				<!-- Begin tab create payrun -->
				<div class="tab-pane active" id="create-payrun">
					<?=modules::run('payrun/create_view');?>
				</div><!-- End tab create payrun -->
				
				<div class="tab-pane" id="search-payrun">
					<?=modules::run('payrun/search_payrun_view');?>
				</div><!-- End tab search payrun -->
				
				<div class="tab-pane" id="search-payslip">
					<?=modules::run('payrun/search_payslip_view');?>
				</div><!-- End tab search payslip -->
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are processing your request ...</p>
		</div>
	</div>
</div>

<script>
$(function() {
	$('#tab-payrun a[href="#<?=$tab;?>"]').tab('show');
})
</script>