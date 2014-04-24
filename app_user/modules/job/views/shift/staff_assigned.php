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
	<i class="fa fa-clock-o staff_hours" data-toggle="popover" onclick="load_staff_hours(this)" data-pk="<?=$shift['staff_id'];?>"></i> 
	<? } ?>
	<a id="shift_staff_<?=$shift['shift_id'];?>" data-toggle="popover" onclick="load_shift_staff(this)" class="update_link shift_staff editable-click" data-pk="<?=$shift['shift_id'];?>">
		<?=$staff_name;?>
	</a>
<? } else { ?>
	<? if($shift['staff_id']) { ?>
	<a class="update_link editable-click" href="<?=base_url();?>staff/view/<?=$shift['staff_id'];?>" target="_blank">
		<?=$staff_name;?>
	</a>
	<? } else { echo $staff_name; } ?>
<? } ?>