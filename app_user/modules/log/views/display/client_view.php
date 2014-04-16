<?
$user = modules::run('user/get_user', $log['user_id']);
$client = modules::run('client/get_client', $log['object_id']);
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
<?=$log['action'];?>d client
<a href="<?=base_url();?>client/edit/<?=$client['user_id'];?>" target="_blank">
<?=$client['company_name'];?></a>'s 
<? if($log['action'] == 'update') { ?>
<?=$log['description'];?>
<? } ?>

<? if ($log['action'] == 'create' || $log['action'] == 'delete') {
	echo 'account';
} ?>