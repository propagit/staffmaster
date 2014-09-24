
<?
$user = modules::run('user/get_user', $log['user_id']);
$staff = modules::run('user/get_user', $log['object_id']);
$btn = '';
$action = '';
switch($log['action']) {
	case 'delete': $btn = 'danger'; $action = 'deleted';
		break;
	case 'create': $btn = 'success'; $action = 'created';
		break;
	case 'update': $btn = 'warning'; $action = 'updated';
		break;
	case 'myob': $btn = 'purple'; $action = 'pushed to ' . strtoupper($log['action']);
		break;
	case 'shoebooks': $btn = 'primary'; $action = 'pushed to ' . ucwords($log['action']);
		break;
}
?>
<span class="label label-<?=$btn;?>"><?=date('H:i', strtotime($log['created_on']));?></span>
&nbsp;
<?=$user['first_name'] . ' ' . $user['last_name'];?>
&nbsp; 
<? if ($log['total'] == 1) { ?>
<?=$action;?> staff
<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>" target="_blank">
<?=$staff['first_name'] . ' ' . $staff['last_name'];?></a>'s 
<? if($log['action'] == 'update') { ?>
<?=$log['description'];?>
<? } ?>

<? if ($log['action'] == 'create' || $log['action'] == 'delete') {
	echo 'account';
} ?>

<? } else { ?>
<?=$log['action'];?>d
<b><?=$log['total'];?></b> staff accounts
<? } ?>


