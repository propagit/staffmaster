<? if (count($staffs) == 0) { ?>
<div class="alert alert-warning">Cannot find staff to match this role</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="30">Image</th>
		<th>Name</th>
		<th class="center" width="100">Add To Shift</th>
	</tr>
</thead>
<tbody>
	<? foreach($staffs as $staff) { ?>
	<tr>
		<td class="center wp_photo_30">
			<?=modules::run('staff/profile_image', $staff['user_id']);?>
		</td>
		<td>
			<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>" target="_blank"><?=$staff['first_name'] . ' ' . $staff['last_name'];?></a>	
			<?=modules::run('common/field_rating', 'rating', $staff['rating'],true);?>
		</td>
		<td class="center"><a class="btn btn-core" onclick="add_staff_to_shift(<?=$staff['user_id'];?>)"><i class="fa fa-plus"></i> Add</a></td>
	</tr>
	<? } ?>
</tbody>
</table>
</div>
<? } ?>