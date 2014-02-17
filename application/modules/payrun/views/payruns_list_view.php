<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" /></th>
		<th class="center" width="65">From</th>
		<th class="center" width="65">To</th>
		<th colspan="3">Staff</th>
		<th class="center">State</th>
		<th class="center">Total Hours</th>
		<th class="center">Amount</th>
		<th class="center">Time Sheets</th>
		<th class="center">Expand</th>
		<th class="center">Status</th>
		<th class="center" width="40">Revert</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($staffs as $staff) { ?>
	<tr id="timesheets_staff_<?=$staff['user_id'];?>">
		<?=modules::run('payrun/row_batched_staff', $staff['user_id']);?>
	</tr>
	<? } ?>
	</tbody>
</table>

<script>
function expand_staff_timehsheets(user_id) {
	$('.timesheets_staff_' + user_id).html('');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/expand_staff_timehsheets",
		data: {user_id: user_id},
		success: function(data) {
			var data = $.parseJSON(data);
			if (!data.children) {
				$('#timesheets_staff_' + user_id).remove();
				$('.timesheets_staff_' + user_id).remove();
			} else {				
				$('#timesheets_staff_' + user_id).addClass('row-open');
				$('#timesheets_staff_' + user_id).html(data.parent);
				$('#timesheets_staff_' + user_id).after(data.children);
				$('#timesheets_staff_' + user_id).find('.wp-arrow').html('<i class="fa fa-minus-square-o"></i></a>');
				$('#timesheets_staff_' + user_id).find('.wp-arrow').attr('onclick', 'collapse_staff_timesheets(' + user_id + ')');
			}
			
		}
	});
}

function collapse_staff_timesheets(user_id) {
	$('.timesheets_staff_' + user_id).remove();
	$('#timesheets_staff_' + user_id).removeClass('row-open');
	$('#timesheets_staff_' + user_id).find('.wp-arrow').html('<i class="fa fa-plus-square-o"></i></a>');
	$('#timesheets_staff_' + user_id).find('.wp-arrow').attr('onclick', 'expand_staff_timehsheets(' + user_id + ')');
}
function revert_staff_payruns(user_id) {
	var title = 'Revert Staff Pay Runs';
	var message ='Are you sure you want to revert this staff time sheets?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				type: "POST",
				url: "<?=base_url();?>payrun/ajax/revert_staff_payruns",
				data: {user_id: user_id},
				success: function(html) {
					$('#timesheets_staff_' + user_id).remove();
				}
			})
		 }
	});
	
}
function revert_payrun(user_id,timesheet_id) {
	var title = 'Revert Pay Run';
	var message ='Are you sure you want to revert this time sheet?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				type: "POST",
				url: "<?=base_url();?>payrun/ajax/revert_payrun",
				data: {timesheet_id: timesheet_id},
				success: function(html) {
					expand_staff_timehsheets(user_id);
				}
			})
		 }
	});
}
</script>