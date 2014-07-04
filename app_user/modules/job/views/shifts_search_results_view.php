<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($shifts);?></b> results</p>
<? if (count($shifts) > 0) { ?>
<div id="nav_shifts">
<?
	# Action menu
	$data = array(
		array('value' => 'contact_staff', 'label' => '<i class="fa fa-envelope-o"></i> Contact Staff')
	);
	echo modules::run('common/menu_dropdown', $data, 'search-shift-action', 'Actions');

?>
	<div class="btn-group btn-nav pull-right">
		<ul class="nav nav-tabs tab-respond">
			<li class="pull-right"><a id="btn-print-day-shifts"><i class="fa fa-print"></i> &nbsp; Print List</a></li>
		</ul>
	</div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" id="list-shifts">
	<thead>
	<tr>
    	<th class="noprint center"><input type="checkbox" id="search_shift_select_all_shifts" /></th>
		<th class="center" width="80">Date &nbsp; <i onclick="sort_search_shifts('date')" class="fa fa-sort"></i></th>
		<? if (!modules::run('auth/is_client')) { ?>
		<th >Client &nbsp; <i onclick="sort_search_shifts('client')" class="fa fa-sort"></i></th>
		<? } ?>
		<th >Campaign Name &nbsp; <i onclick="sort_search_shifts('campaign')" class="fa fa-sort"></i></th>
		<th >Venue &nbsp; <i onclick="sort_search_shifts('venue')" class="fa fa-sort"></i></th>
		<th >Role &nbsp; <i onclick="sort_search_shifts('role')" class="fa fa-sort"></i></th>
		<th class="noprint center">Break</th>
		<th class="center" width="120">Start - Finish</th>
		<th >Staff Assigned &nbsp;<i onclick="sort_search_shifts('status')" class="fa fa-sort"></i></th>
		<th class="noprint center" width="40">View</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { $client = modules::run('client/get_client', $shift['client_id']); ?>
	<tr class="<?=modules::run('job/status_to_class', $shift['status']);?>
				<?=($shift['is_alert']) ? ' purple' : '';?>">
        <td class="noprint center"><? if($shift['status'] == SHIFT_CONFIRMED) {?><input type="checkbox" class="search_shift_selected_shifts" value="<?=$shift['shift_id'];?>" data-staff-user-id="<?=$shift['staff_id'];?>" /><?php }else { echo '&nbsp;';} ?></td>
		<td class="wp-date" width="70">
			<span class="wk_day"><?=date('D', strtotime($shift['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($shift['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($shift['job_date']));?></span>
		</td>
		<? if (!modules::run('auth/is_client')) { ?>
		<td ><?=$client['company_name'];?></td>
		<? } ?>
		<td ><?=$shift['job_name'];?></td>
		<td ><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></td>
		<td ><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td class="noprint center"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		<td class="center"><?=date('H:i', $shift['start_time']);?> - <?=date('H:i', $shift['finish_time']);?><?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="text-red">*</span>': '';?></td>
		<td>
			<? if($shift['staff_id']) { $staff = modules::run('staff/get_staff', $shift['staff_id']); 
				echo $staff['first_name'] . ' ' . $staff['last_name'];				
			?>
			<? } else { ?>
			No Staff Assigned
			<? } ?>
		</td>
		<td class="noprint center" width="40"><a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/all/<?=$shift['status'];?>"><i class="fa fa-eye"></i></a></td>
	</tr>
	<? } ?>
	</tbody>
</table>
</div>

<? } ?>

<!--email-->
<div id="ajax-email-shift-reminder-modal"></div>
<form id="shift-reminder-contact-email-form">
<div id="selected-shift-email-info"></div>
<input type="hidden" name="email_modal_header" value="Shift Reminder" />
<input type="hidden" name="email_template_id" value="<?=SHIFT_REMINDER_EMAIL_TEMPLATE_ID;?>" />
<?php $allowed_email_templates = array(SHIFT_REMINDER_EMAIL_TEMPLATE_ID);?>
<input type="hidden" name="allowed_template_ids" value="<?=json_encode($allowed_email_templates);?>" />
</form>
<!--end email-->

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
$(function(){
	$('#search_shift_select_all_shifts').click(function(){
		$('input.search_shift_selected_shifts').prop('checked', this.checked);		
	});	
	//contact staff
	$('#menu-search-shift-action ul li a[data-value="contact_staff"]').click(function(){
		var shift_selected = false;
		$('#selected-shift-email-info').html('');
		$('.search_shift_selected_shifts:checked').each(function(){
			shift_selected = true;
			$('#selected-shift-email-info').append('<input type="hidden" name="selected_module_ids[]" value="'+$(this).val()+'" />');
			$('#selected-shift-email-info').append('<input type="hidden" name="user_staff_selected_user_id[]" value="'+$(this).attr('data-staff-user-id')+'" />');

		});
		if (shift_selected) {
			$.ajax({
			  type: "POST",
			  url: "<?=base_url();?>email/ajax/get_send_email_modal",
			  data: $('#shift-reminder-contact-email-form').serialize(),
			  success: function(html) {
				  $('#ajax-email-shift-reminder-modal').html(html);
				  $('#email-modal').modal('show');	
			  }
		  });
		}
		
	});
	$('#btn-print-day-shifts').click(function(e){
		e.preventDefault();
		$('#waitingModal').modal('show');
		var content = JSON.stringify($('#list-shifts').html());
		$.ajax({
			type: "POST",
			async: false,
			url: "<?=base_url();?>job/ajax_shift/print_day_shifts",
			data: {content: content, date_from: $('input[name="date_from"]').val(), date_to: $('input[name="date_to"]').val()},
			success: function(html) {
				$('#waitingModal').modal('hide');
				window.open('<?=base_url() . UPLOADS_URL;?>/pdf/' + html, 'Shifts List');
			}
		})
	})
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
});
//this function is called from job/views/jobs_search_form.php
//this is because if included in this page an event listner will be added for each time a search request is made and multiple email request will be triggered
function email_shift_reminder(){
	//update_ckeditor() function in send_email_modal view file
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/email_shift_reminder",
		data: $('#send-email-modal-form').serialize(),
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);
			setTimeout(function(){
				$('#email-modal').modal('hide');
			}, 4000);
		}
	}); 
}
</script>