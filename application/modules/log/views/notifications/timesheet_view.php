<?
$user = modules::run('user/get_user', $log['user_id']);
$timesheet = modules::run('timesheet/get_timesheet', $log['object_id']);
?>
<span class="activity-information"><i class="fa fa-check-square"></i> Time Sheet Submitted</span>
 - 
 <b><?=$user['first_name'] . ' ' . $user['last_name'];?></b> submitted 1 
<a href="<?=base_url();?>timesheet" target="_blank">timesheet</a>