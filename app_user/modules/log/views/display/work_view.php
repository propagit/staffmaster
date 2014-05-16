<?
$user = modules::run('user/get_user', $log['user_id']);
$shift = modules::run('job/shift/get_shift', $log['object_id']);
$btn = '';
switch($log['action'])
{
	case 'unapplied': $btn = 'danger';
		break;
	case 'applied': $btn = 'success';
		break;
}
?>
<span class="label label-<?=$btn;?>"><?=date('H:i', strtotime($log['created_on']));?></span>
&nbsp;
<?=$user['first_name'] . ' ' . $user['last_name'];?>
&nbsp; 
<?=$log['action'];?> 
<b><?=$log['total'];?></b> 
<? if ($shift) { ?>
<a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>" target="_blank">
	shift<? if($log['total'] > 1) { echo 's'; } ?>
</a>
<? } else { ?>
	shift<? if($log['total'] > 1) { echo 's'; } ?>
<? } ?>