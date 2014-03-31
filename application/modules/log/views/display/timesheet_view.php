<?
$user = modules::run('user/get_user', $log['user_id']);
$timesheet = modules::run('timesheet/get_timesheet', $log['object_id']);
?>
<span class="label label-info"><?=date('H:i', strtotime($log['created_on']));?></span>
&nbsp;
<?=$user['first_name'] . ' ' . $user['last_name'];?>
&nbsp; 
<?=$log['action'];?>ted
<b><?=$log['total'];?></b> 
<a href="<?=base_url();?>timesheet" target="_blank">
	timesheet
</a>