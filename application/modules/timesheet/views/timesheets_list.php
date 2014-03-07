<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($timesheets);?></b> results</p>

<? if (count($timesheets) > 0) { ?>
<!-- Filter Menus -->
<div id="nav_payruns">
	<?=modules::run('timesheet/menu_dropdown_actions', 'action', 'Actions');?>			
</div><!-- End Filter Menus -->
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"></th>
		<th class="center">Date <i class="fa fa-sort sort-data" sort-by="t.job_date"></i></th>
		<th>Client</th>
		<th>Campaign Name</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Pay rate</th>
		<th>Staff Assigned</th>
		<th class="center">Expenses</th>
		<th class="center" width="40">Batch</th>
		<th class="center" width="40">View</th>
		<th class="center" width="40">Delete</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		echo modules::run('timesheet/row_timesheet', $timesheet['timesheet_id']); } ?>
</tbody>
</table>

<script>
$(function(){
	init_edit();
    
	$('.sort-data').on('click',function(){
		sort_data.sort_by = $(this).attr('sort-by');
		//toggle sort order data for next sort
		(sort_data.sort_order == 'asc' ? sort_data.sort_order = 'desc' : sort_data.sort_order = 'asc');	
		list_timesheets();
	});
})
function init_edit() {
	$('.ts_start_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
		url: '<?=base_url();?>timesheet/ajax/update_timesheet_start_time',
        success: function(response, newValue)
        {
	        if (response.status == 'error')
			{
				return response.msg;
			}
			else
			{
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });
    $('.ts_finish_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
        url: '<?=base_url();?>timesheet/ajax/update_timesheet_finish_time',
        success: function(response, newValue)
        {
	        if (response.status == 'error')
			{
				return response.msg;
			}
			else
			{
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });
    $('.ts_payrate').editable({
		url: '<?=base_url();?>timesheet/ajax/update_timesheet_payrate',
		name: 'payrate_id',
		title: 'Select Pay Rate',
		source: [<?=modules::run('attribute/payrate/get_payrates', 'data_source');?>],
		success: function(response, newValue)
        {
	        refrest_timesheet($(this).attr('data-pk'));
        }
	});
}
function refrest_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/refresh_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
			init_edit();
		}
	})
}
function batch_timesheet(timesheet_id) {	
	preloading($('#list_timesheets'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/batch_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			list_timesheets();
		}
	})
}
function delete_timesheet(timesheet_id) {
	var title = 'Delete Timesheet';
	var message ='This action will delete the timesheet and unlock the shift. Are you sure you want to do so?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				 type: "POST",
				 url: "<?=base_url();?>timesheet/ajax/delete_timesheet",
				 data: {timesheet_id: timesheet_id},
				 success: function(html) {
					 list_timesheets();
				 }
			 })
		 }
	});
}
</script>
<? } ?>