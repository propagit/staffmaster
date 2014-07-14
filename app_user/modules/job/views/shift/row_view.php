<tr class="<?=modules::run('job/shift_status', $shift);?>
				<?=($shift['is_alert'] && !$is_client) ? ' purple': '';?>" id="shift_<?=$shift['shift_id'];?>">
	<td class="center"><input type="checkbox" class="selected_shifts" value="<?=$shift['shift_id'];?>" data-staff-user-id="<?=$shift['staff_id'];?>" /></td>
	<td class="wp-date" width="80">
		<span class="wk_day"><?=date('D', strtotime($shift['job_date']));?></span>
		<span class="wk_date"><?=date('d', strtotime($shift['job_date']));?></span>
		<span class="wk_month"><?=date('M', strtotime($shift['job_date']));?></span>
	</td>
	<td>			
		<a href="#" class="update_link shift_venue" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></a>
	</td>
	<td>
		<a href="#" class="update_link shift_role" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['role_id'];?>"><?=modules::run('attribute/role/display_role', $shift['role_id']);?></a>
	</td>
	
	<? if ($is_client) { ?>
	<td>
		<a href="#" class="update_link shift_uniform" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['uniform_id'];?>"><?=modules::run('attribute/uniform/display_uniform', $shift['uniform_id']);?></a>
	</td>
	<? } ?>
	
	<td class="center">
		<a href="#" class="update_link shift_start_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['start_time']);?>" data-title="Shift start date/time"><?=date('H:i', $shift['start_time']);?></a>
		-
		<a href="#" class="update_link shift_finish_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['finish_time']);?>" data-title="Shift finish date/time"><?=date('H:i', $shift['finish_time']);?></a> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="text-danger">*</span>': '';?>
	</td>
	<td class="center">
		<a id="shift_break_<?=$shift['shift_id'];?>" onclick="load_shift_breaks(this)" class="update_link shift_breaks editable-click" data-pk="<?=$shift['shift_id'];?>" data-toggle="popover"><?=modules::run('common/break_time', $shift['break_time']);?></a>
	</td>
	<? if (!$is_client) { ?>
	<td class="center"><a class="update_link shift_payrate" onclick="load_shift_payrate(this)" data-pk="<?=$shift['shift_id'];?>" data-toggle="popover"><?=modules::run('attribute/payrate/display_payrate', $shift['payrate_id']);?></a></td>
	<? } ?>
	<td class="staff_assigned">
		<?
		$staff_name = 'No Staff Assigned';
		if($shift['staff_id']) 
		{ 
			$staff = modules::run('staff/get_staff', $shift['staff_id']); 
			$staff_name = $staff['first_name'] . ' ' . $staff['last_name'];
		}
		?>
		
		<? if (!$is_client) { ?>
			<? if($shift['staff_id']) { ?>
			<i class="fa fa-clock-o staff_hours" data-toggle="popover" onclick="load_staff_hours(this)" data-pk="<?=$shift['staff_id'];?>" data-date="<?=$shift['job_date'];?>"></i> 
			<? } ?>
			<a id="shift_staff_<?=$shift['shift_id'];?>" data-toggle="popover" onclick="load_shift_staff(this)" class="update_link shift_staff editable-click" data-pk="<?=$shift['shift_id'];?>">
				<?=$staff_name;?>
			</a>
			
			<? if($shift['sms_sent']) { ?>
			<i class="fa fa-mobile"></i>
			<? } ?>
			
		<? } else { ?>
			<? if($shift['staff_id']) { ?>
			<a class="update_link editable-click" href="<?=base_url();?>staff/view/<?=$shift['staff_id'];?>" target="_blank">
				<?=$staff_name;?>
			</a>
			<? } else { echo $staff_name; } ?>
		<? } ?>
	</td>

	
	<? if (!$is_client) { ?>
	<td class="center" width="40"><a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax/search_staffs/<?=$shift['shift_id'];?>"><i class="fa fa-search"></i></a></td>
	<td class="center" width="40"><a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax/applied_staffs/<?=$shift['shift_id'];?>"><i class="fa fa-thumbs-o-up"></i></a></td>
	<? } else { ?>
	<td class="center" colspan="2"><a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax/applied_staffs/<?=$shift['shift_id'];?>"><i class="fa fa-thumbs-o-up"></i></a></td>
	<? } ?>
	
	
	
	<? if (!$is_client) { ?>
	<td class="center" width="40">
		<a href="#" class="update_link shift_supervisor" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['supervisor_id'];?>"><i class="fa fa-star"></i></a>
	</td>
	
	
	<td class="center" width="40">
		<a href="#" class="update_link shift_uniform" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['uniform_id'];?>"><i class="fa fa-male"></i></a>
	</td>
	<td class="center" width="40">
		<a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax_shift/load_add_brief_single_shift/<?=$shift['shift_id'];?>"><i class="fa fa-info-circle"></i></a>
	</td>
	<td class="center" width="40">
		<a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax_shift/load_add_shift_note_modal/<?=$shift['shift_id'];?>"><i class="fa fa-comment-o"></i></a>
	</td>
	<td class="center" width="40">
		<a class="update_link editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax_shift/load_expenses_modal/<?=$shift['shift_id'];?>"><i class="fa fa-dollar"></i></a>
	</td>
	<? } ?>
</tr>