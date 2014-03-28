
<?
$user = modules::run('user/get_user', $log['user_id']);
$staff = modules::run('user/get_user', $log['object_id']);
$btn = '';
switch($log['action']) {
	case 'delete': $btn = 'danger';
		break;
	case 'create': $btn = 'success';
		break;
	case 'update': $btn = 'warning';
		break;
}
?>
<span class="label label-<?=$btn;?>"><?=date('H:i', strtotime($log['created_on']));?></span>
&nbsp;
<?=$user['first_name'] . ' ' . $user['last_name'];?>
&nbsp; 
<? if ($log['total'] == 1) { ?>
<?=$log['action'];?>d staff
<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>" target="_blank">
<?=$staff['first_name'] . ' ' . $staff['last_name'];?></a>'s 
<? if($log['action'] == 'update') { ?>
<?=$log['description'];?>
<? } ?>

<? if ($log['action'] == 'create' || $log['action'] == 'delete') {
	echo 'account';
} ?>

<? } else { ?>
imported
<b><?=$log['total'];?></b> staff accounts
<? } ?>


