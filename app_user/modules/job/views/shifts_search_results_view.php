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
<input type="hidden" id="email-selected-staff-ids" name="user_staff_selected_user_id[]" value="" />
<input type="hidden" name="email_modal_header" value="Invoice Client" />
<input type="hidden" name="email_template_id" value="<?=SHIFT_REMINDER_EMAIL_TEMPLATE_ID;?>" />
<input type="hidden" id="email-selected-module-ids" name="selected_module_ids[]" value="" />
<?php $allowed_email_templates = array(SHIFT_REMINDER_EMAIL_TEMPLATE_ID);?>
<input type="hidden" name="allowed_template_ids" value="<?=json_encode($allowed_email_templates);?>" />
</form>
<!--end email-->

<script>
$(function(){
	$('#search_shift_select_all_shifts').click(function(){
		$('input.search_shift_selected_shifts').prop('checked', this.checked);		
	});	
	var search_shift_selected_shifts = new Array();
	var shift_user_id_selected_shifts = new Array();
	//contact staff
	$('#menu-search-shift-action ul li a[data-value="contact_staff"]').click(function(){
		search_shift_selected_shifts.length = 0;
		$('.search_shift_selected_shifts:checked').each(function(){
			search_shift_selected_shifts.push($(this).val());
			shift_user_id_selected_shifts.push($(this).attr('data-staff-user-id'));
		});
		if (search_shift_selected_shifts.length > 0) {
			$('#email-selected-module-ids').val(search_shift_selected_shifts);
			$('#email-selected-staff-ids').val(shift_user_id_selected_shifts);
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
</script>