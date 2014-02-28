<? if (count($clients) == 0) { ?>
	<div class="alert alert-warning">No billable works</div>
<? } else { ?>
<div id="nav_clients">
	<? #=modules::run('payrun/menu_dropdown_actions', 'action', 'Actions');?>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"></th>
		<th colspan="5">Client Name</th>
		<th class="center" width="120">Campaigns</th>
		<th class="center" width="40">
		</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($clients as $client) { ?>
	<tr id="jobs_client_<?=$client['user_id'];?>">
		<td><input type="checkbox" /></td>
		<td colspan="5"><?=$client['company_name'];?></td>
		<td class="center"><?=$client['total_jobs'];?></td>
		<td>
			<a class="wp-arrow" onclick="load_client_jobs(<?=$client['user_id'];?>)"><i class="fa fa-plus-square-o"></i></a>
		</td> 
	</tr>
	<? } ?>
	</tbody>
</table>
</div>

<script>
$(function(){
	//load_client_jobs(<?=$clients[0]['user_id'];?>);
});

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
function add_job_to_invoice(job_id, apply_all=false) {	
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
function remove_job_from_invoice(job_id, apply_all=false) {	
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
function refresh_row_timesheet(timesheet_id,loading=true) {
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
<? } ?>