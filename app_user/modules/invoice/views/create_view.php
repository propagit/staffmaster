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
			var invoiceWindow = window.open('', 'Manual Invoice');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>invoice/ajax/create_manual_invoice",
				data: {client_id: client_id},
				success: function(html) {
					invoiceWindow.location.href = '<?=base_url();?>invoice/edit/' + html;
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
		async: false,
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
function load_client_jobs(user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/load_client_jobs",
		data: {user_id: user_id},
		success: function(html) {
			$('#jobs_client_' + user_id).after(html);
			$('#jobs_client_' + user_id).find('.wp-arrow').attr('onclick', 'hide_client_jobs(' + user_id + ')');
			$('#jobs_client_' + user_id).find('.wp-arrow').html('<i class="fa fa-minus-square-o"></i>');
		}
	})
}
function hide_client_jobs(user_id) {
	$('.job_client_' + user_id).remove();
	$('#jobs_client_' + user_id).find('.wp-arrow').attr('onclick', 'load_client_jobs(' + user_id + ')');
	$('#jobs_client_' + user_id).find('.wp-arrow').html('<i class="fa fa-plus-square-o"></i>');
}
function refresh_row_client_job(job_id) {
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/row_client_job",
		data: {job_id: job_id},
		success: function(html) {
			loaded($('#list_clients'));
			$('#job_client_' + job_id).replaceWith(html);
			list_temp_invoices();
		}
	})
}
function add_job_to_invoice(job_id, apply_all) {	
	var apply_all = apply_all || false;
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/add_job_to_invoice",
		data: {job_id: job_id, apply_all: apply_all},
		success: function(data) {
			refresh_row_client_job(job_id);
			if (apply_all)
			{				
				data = $.parseJSON(data);
				for(var i=0; i < data.length; i++) {
					refresh_row_timesheet(data[i], false);
				}
			}
			refresh_row_job(job_id);
			loaded($('#list_clients'));
		}
	})
}
function remove_job_from_invoice(job_id, apply_all) {	
	var apply_all = apply_all || false;
	preloading($('#list_clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/remove_job_from_invoice",
		data: {job_id: job_id, apply_all: apply_all},
		success: function(data) {
			refresh_row_client_job(job_id);
			if (apply_all)
			{				
				data = $.parseJSON(data);
				for(var i=0; i < data.length; i++) {
					refresh_row_timesheet(data[i], false);
				}
			}
			refresh_row_job(job_id);
			loaded($('#list_clients'));
		}
	})
}
function refresh_row_timesheet(timesheet_id,loading) {
	var loading = loading && true;
	if (loading) { preloading($('#list_clients')); }
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/row_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
			if (loading) { loaded($('#list_clients')); }
		}
	})
}
function refresh_row_job(job_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/row_job",
		data: {job_id: job_id},
		success: function(html) {
			$('#row-timesheets-job-' + job_id).replaceWith(html);
			list_temp_invoices();
		}
	})
}
function add_timesheet_to_invoice(timesheet_id, job_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/add_timesheet_to_invoice",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refresh_row_timesheet(timesheet_id);
			refresh_row_job(job_id);
		}
	})
}
function remove_timesheet_from_invoice(timesheet_id, job_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/remove_timesheet_from_invoice",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refresh_row_timesheet(timesheet_id);
			refresh_row_job(job_id);
		}
	})
}

</script>