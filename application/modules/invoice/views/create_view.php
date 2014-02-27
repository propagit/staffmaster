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
function list_clients(client_id=null) {
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/list_clients",
		success: function(html) {
			loaded($('#list_clients'), html);
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