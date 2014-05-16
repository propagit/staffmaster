<?
$user = modules::run('user/get_user', $log['user_id']);
$shift = modules::run('job/shift/get_shift', $log['object_id']);
$data = unserialize($log['description']);
$btn = '';
$action = '';
switch($data['status'])
{
	case SHIFT_REJECTED: $btn = 'danger'; $action = 'rejected';
		break;
	case SHIFT_CONFIRMED: $btn = 'success'; $action = 'confirmed';
		break;
}
?>
<span class="label label-<?=$btn;?>"><?=date('H:i', strtotime($log['created_on']));?></span>
&nbsp;
<?=$user['first_name'] . ' ' . $user['last_name'];?>
&nbsp; 
<?=$action;?> 
<b><?=$log['total'];?></b> 
<? if ($shift) { ?>
<a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>" target="_blank">
	shift<? if($log['total'] > 1) { echo 's'; } ?>
</a>
<? } else { ?>
	shift<? if($log['total'] > 1) { echo 's'; } ?>
<? } ?>