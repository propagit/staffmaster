<? if (count($staffs) == 0) { ?>
<div class="alert alert-warning">No time sheet is ready for pay run.</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="select_all_checkboxes" /></th>
		<th class="center" width="65">From</th>
		<th class="center" width="65">To</th>
		<th colspan="3">Staff</th>
		<th class="center" width="80">State</th>
		<th class="center" width="100">Total Hours</th>
		<th class="center" width="100">Amount</th>
		<th class="center" width="120">Time Sheets</th>
		<th class="center" width="120">Add to Pay Run</th>
		<th class="center" width="40">Revert</th>
		<th class="center" width="40">
			<a onclick="expand_all(this)"><i class="fa fa-plus-square-o"></i></a>
		</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($staffs as $staff) { if (isset($staff['user_id'])) echo modules::run('payrun/row_batched_staff', $staff['user_id']); } ?>
	</tbody>
</table>
</div>

<script>
$(function(){
	var selected_timesheets = new Array();
	
	$('#select_all_checkboxes').click(function(){			
		$('input.payrun_timesheet').prop('checked', this.checked);
	});
	
	$('#menu-action ul li a[data-value="revert"]').click(function(){
		selected_timesheets.length = 0;
		$('.payrun_timesheet:checked').each(function(){
			selected_timesheets.push($(this).val());
		});
		revert_selected_timesheets(selected_timesheets);
	});
	$('#menu-action ul li a[data-value="process"]').click(function(){
		selected_timesheets.length = 0;
		$('.payrun_timesheet:checked').each(function(){
			selected_timesheets.push($(this).val());
		});
		process_selected_timesheets(selected_timesheets);
	});
	$('#menu-action ul li a[data-value="unprocess"]').click(function(){
		selected_timesheets.length = 0;
		$('.payrun_timesheet:checked').each(function(){
			selected_timesheets.push($(this).val());
		});
		unprocess_selected_timesheets(selected_timesheets);
	});
})
function refresh_row_timesheets_staff(user_id) {
	var expanded = 0;
	if ($('.timesheets_staff_' + user_id).length) {
		expanded = 1;
	}
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/row_timesheets_staff",
		data: {user_id: user_id,expanded: expanded},
		success: function(html) {
			$('#timesheets_staff_' + user_id).replaceWith(html);
		}
	}).done(function() {
		$('.payrun_staff').click(function(){
			var user_id = $(this).val();
			alert(user_id);
			$('.timesheets_staff_' + user_id).find('.payrun_timesheet').prop('checked', this.checked);
		})
	});
}
function refresh_row_timesheet(timesheet_id, user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/row_timesheet",
		data: {timesheet_id: timesheet_id, user_id: user_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
		}
	})
}

function process_staff_payruns(user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/process_staff_payruns",
		data: {user_id: user_id},
		success: function(data) {
			data = $.parseJSON(data);
			for(var i=0; i < data.length; i++) {
				refresh_row_timesheet(data[i], user_id);
			}
			refresh_row_timesheets_staff(user_id);
			get_payrun_stats();
		}
	})
}
function process_selected_timesheets(timesheet_ids) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/process_selected_timesheets",
		data: {timesheet_ids: timesheet_ids},
		success: function(html) {
			location.reload();
		}
	})
}
function process_payrun(timesheet_id,user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/process_payrun",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refresh_row_timesheets_staff(user_id);
			refresh_row_timesheet(timesheet_id, user_id);
			get_payrun_stats();
		}
	})
}

function unprocess_staff_payruns(user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/unprocess_staff_payruns",
		data: {user_id: user_id},
		success: function(data) {
			data = $.parseJSON(data);
			for(var i=0; i < data.length; i++) {
				refresh_row_timesheet(data[i], user_id);
			}
			refresh_row_timesheets_staff(user_id);
			get_payrun_stats();
		}
	})
}
function unprocess_selected_timesheets(timesheet_ids) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/unprocess_selected_timesheets",
		data: {timesheet_ids: timesheet_ids},
		success: function(html) {
			location.reload();
		}
	})
}
function unprocess_payrun(timesheet_id,user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/unprocess_payrun",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refresh_row_timesheets_staff(user_id);
			refresh_row_timesheet(timesheet_id, user_id);
			get_payrun_stats();
		}
	})
}

function expand_all(obj) {
	<? foreach($staffs as $staff) { ?>
	expand_staff_timehsheets(<?=$staff['user_id'];?>);
	<? } ?>
	$('body').scrollTo('#timesheets_staff_' + <?=$staffs[0]['user_id'];?>, 500 );
	$(obj).attr('onclick','collapse_all(this)');
	$(obj).html('<i class="fa fa-minus-square-o"></i>');
}
function collapse_all(obj) {
	<? foreach($staffs as $staff) { ?>
	collapse_staff_timesheets(<?=$staff['user_id'];?>);
	<? } ?>
	$(obj).attr('onclick','expand_all(this)');
	$(obj).html('<i class="fa fa-plus-square-o"></i>');
}
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
				$('#timesheets_staff_' + user_id).replaceWith(data.parent);
				$('#timesheets_staff_' + user_id).after(data.children);
				$('#timesheets_staff_' + user_id).find('.wp-arrow').html('<i class="fa fa-minus-square-o"></i>');
				$('#timesheets_staff_' + user_id).find('.wp-arrow').attr('onclick', 'collapse_staff_timesheets(' + user_id + ')');
			}
			
		}
	})
}
function collapse_staff_timesheets(user_id) {
	$('.timesheets_staff_' + user_id).remove();
	$('#timesheets_staff_' + user_id).removeClass('row-open');
	$('#timesheets_staff_' + user_id).find('.wp-arrow').html('<i class="fa fa-plus-square-o"></i>');
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
					$('.timesheets_staff_' + user_id).remove();
				}
			})
		 }
	});
	
}
function revert_selected_timesheets(timesheet_ids) {
	var title = 'Revert Selected Time sheets';
	var message ='Are you sure you want to revert selected time sheets?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				type: "POST",
				url: "<?=base_url();?>payrun/ajax/revert_selected_timesheets",
				data: {timesheet_ids: timesheet_ids},
				success: function(html) {
					location.reload();
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
					$('#timesheet_' + timesheet_id).remove();
					if ($('.timesheets_staff_' + user_id).length > 0) {
						refresh_row_timesheets_staff(user_id);
					} else {
						$('#timesheets_staff_' + user_id).remove();
					}					
				}
			})
		 }
	});
}
</script>
<? } ?>