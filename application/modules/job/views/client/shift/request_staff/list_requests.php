<? if (count($staffs) > 0) { ?>
<div class="clearfix"></div>
<div class="table-responsive">                     
<table class="table table-bordered table-middle" width="100%">
<tbody>
	<? foreach($staffs as $staff) { 
		$user = modules::run('user/get_user', $staff['staff_id']);
	?>
	<tr>
		<td>
			<a class="wp_photo_30 pull-left">
				<?=modules::run('staff/profile_image', $user['user_id']);?>
			</a>
			<a><?=$user['first_name'];?> <?=$user['last_name'];?></a>
		</td>
		<? if (modules::run('auth/is_client')) { ?>
		<td width="120">
			<a class="btn btn-core" onclick="remove_request(<?=$staff['shift_id'];?>, <?=$user['user_id'];?>)">Remove request</a>
		</td>
		<? } else { ?>
		<td width="50">
			<a onclick="assign_new_staff(<?=$user['user_id'];?>)" class="btn btn-core"><i class="fa fa-plus"></i> Assign</a>
		</td>
		<? } ?>
	</tr>
	<? } ?>
</tbody>
</table>
</div>
<? } ?>