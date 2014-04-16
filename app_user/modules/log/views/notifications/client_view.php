<?
$user = modules::run('user/get_user', $log['user_id']);
?>

<span class="activity-warning"><i class="fa fa-exclamation-triangle"></i> Delete Client</span>
 - 
<b><?=$user['first_name'] . ' ' . $user['last_name'];?></b> 
deleted
a client