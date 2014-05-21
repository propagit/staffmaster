<div class="pull-right col-md-4 remove-right-padding">
	<div class="col-md-7" id="f_client_id"><?=modules::run('client/field_select', 'invoice_client_id');?></div>
	<button class="btn btn-core col-md-5" id="btn-manual-invoice">Create Manual Invoice</button>
</div>
<h2>Create Invoices</h2>
<p>Add campaigns or time sheets in a campaign to create a client invoice. Generating the invoice will archive the invoice which can be exported to your favourite accounts program via the search Invoice page.</p>
<!-- Begin List of temporary invoices -->
<div id="list_temp_invoices"></div><!-- End of temporary invoices -->

<h2>Billable Works</h2>
<!-- Begin List Clients -->
<div id="list_clients"></div><!-- End List Clients -->


<script>
$(function() {
	list_temp_invoices();
	list_clients();
	$('#btn-manual-invoice').click(function(){
		$('#f_client_id').removeClass('has-error');
		var client_id = $('#invoice_client_id').val();
		if (!client_id) {
			$('#f_client_id').addClass('has-error');
		} else {			
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>invoice/ajax/create_manual_invoice",
				data: {client_id: client_id},
				success: function(html) {
					window.open('<?=base_url();?>invoice/edit/' + html);
				}
			})
		}
	})
})
function list_temp_invoices() {
	preloading($('#list_invoices'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_temp_invoices",
		success: function(html) {
			loaded($('#list_temp_invoices'), html);
		}
	})
}
function list_clients(client_id) {
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_clients",
		success: function(html) {
			loaded($('#list_clients'), html);
		}
	}).done(function(){
		if (client_id != null) {
			setTimeout(function() {
				// Do something after 2 seconds
				load_client_jobs(client_id);
			}, 500);
			
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