<form role="form" id="form_update_ts_staff">
	<div class="form-group pull-left" id="f_shift_staff">
		<input type="hidden" name="ts_staff_id" value="<?=$timesheet['staff_id'];?>" />
		<input type="hidden" name="timesheet_id" value="<?=$timesheet['timesheet_id'];?>" />
		<input type="text" class="ts_staff form-control" name="ts_staff" placeholder="Type staff name..." value="<?=($staff) ? $staff['first_name'] . ' ' . $staff['last_name'] : '';?>" />
	</div>
</form>

<div id="staff_quick_search_result">
	<a onclick="select_staff(this)" class="photo_staff photo_2 shift-search-pp" data-pk="<?=$staff['user_id'];?>" data-toggle="tooltip" data-original-title="<?=$staff['first_name'] . ' ' . $staff['last_name'];?>">
	<?=modules::run('staff/profile_image', $staff['user_id']);?>
	</a>
</div>

<button type="button" class="btn btn-primary btn-sm staff-submit">
	<i class="glyphicon glyphicon-ok"></i>
	</button>
<button type="button" class="btn btn-default btn-sm staff-cancel">
	<i class="glyphicon glyphicon-remove"></i>
</button>
