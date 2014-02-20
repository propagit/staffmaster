<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Invoices</h2>
		<p>Create invoices and issue them to your clients. As time sheets are approved and batched they will be available to add to client invoice.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond">
				<li><a href="<?=base_url();?>timesheet">Time Sheets</a></li>
				<li class="active"><a>Client Invoices</a></li>
				<li><a href="<?=base_url();?>payrun">Pay Run</a></li>
			</ul>
			<br />
			<h2>Create Invoices</h2>
			<p>Add campaigns or time sheets in a campaign to create a client invoice. Generating the invoice will archive the invoice which can be exported to your favourite accounts program via the search Invoice page.</p>
			<div id="list_invoices"></div>
			
			
			<!-- List Clients -->
			<div id="list_clients"></div><!-- End List Clients -->
		</div>
	</div>
</div>

<script>
$(function() {
	list_clients();
	list_invoices();
})
function list_clients() {
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_clients",
		success: function(html) {
			loaded($('#list_clients'), html);
		}
	})
}
function list_invoices() {
	preloading($('#list_invoices'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_invoices",
		success: function(html) {
			loaded($('#list_invoices'), html);
		}
	})
}
function load_job_timesheets(job_id) {
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/load_job_timesheets",
		data: {job_id: job_id},
		success: function(html) {
			loaded($('#list_clients'), html);
		}
	})
}
</script>