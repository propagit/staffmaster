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
	
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
    	<th class="center"><input type="checkbox" id="search_shift_select_all_shifts" /></th>
		<th class="center" width="80">Date &nbsp; <i onclick="sort_search_shifts('date')" class="fa fa-sort"></i></th>
		<? if (!modules::run('auth/is_client')) { ?>
		<th>Client &nbsp; <i onclick="sort_search_shifts('client')" class="fa fa-sort"></i></th>
		<? } ?>
		<th>Campaign Name &nbsp; <i onclick="sort_search_shifts('campaign')" class="fa fa-sort"></i></th>
		<th>Venue &nbsp; <i onclick="sort_search_shifts('venue')" class="fa fa-sort"></i></th>
		<th>Role &nbsp; <i onclick="sort_search_shifts('role')" class="fa fa-sort"></i></th>
		<th class="center">Break</th>
		<th class="center" width="120">Start - Finish</th>
		<th>Staff Assigned &nbsp;<i onclick="sort_search_shifts('status')" class="fa fa-sort"></i></th>
		<th class="center" width="40">View</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { $client = modules::run('client/get_client', $shift['client_id']); ?>
	<tr class="<?=modules::run('job/status_to_class', $shift['status']);?>
				<?=($shift['is_alert']) ? ' purple' : '';?>">
        <td class="center"><? if($shift['status'] == SHIFT_CONFIRMED) {?><input type="checkbox" class="search_shift_selected_shifts" value="<?=$shift['shift_id'];?>" data-staff-user-id="<?=$shift['staff_id'];?>" /><?php }else { echo '&nbsp;';} ?></td>
		<td class="wp-date" width="70">
			<span class="wk_day"><?=date('D', strtotime($shift['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($shift['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($shift['job_date']));?></span>
		</td>
		<? if (!modules::run('auth/is_client')) { ?>
		<td><?=$client['company_name'];?></td>
		<? } ?>
		<td><?=$shift['job_name'];?></td>
		<td><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></td>
		<td><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td class="center"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		<td class="center"><?=date('H:i', $shift['start_time']);?> - <?=date('H:i', $shift['finish_time']);?><?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="text-red">*</span>': '';?></td>
		<td>
			<? if($shift['staff_id']) { $staff = modules::run('staff/get_staff', $shift['staff_id']); 
				echo $staff['first_name'] . ' ' . $staff['last_name'];				
			?>
			<? } else { ?>
			No Staff Assigned
			<? } ?>
		</td>
		<td class="center" width="40"><a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>"><i class="fa fa-eye"></i></a></td>
	</tr>
	<? } ?>
	</tbody>
</table>
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