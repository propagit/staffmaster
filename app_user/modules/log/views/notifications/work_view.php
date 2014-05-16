<?
$user = modules::run('user/get_user', $log['user_id']);
$shift = modules::run('job/shift/get_shift', $log['object_id']);
$text = '';
switch($log['action'])
{
	case 'unapplied': $btn = 'danger'; $text = 'does not want to work';
		break;
	case 'applied': $btn = 'success'; $text = 'wants to work';
		break;
}

?>
<? if ($log['action'] == 'applied') { ?>
<span class="activity-confirmation"><i class="fa fa-thumbs-o-up"></i> Book Me </span>
<? } else { ?>
<span class="activity-warning"><i class="fa fa-thumbs-o-down"></i> Unbook Me</span>
<? } ?>
 - 
<b><?=$user['first_name'] . ' ' . $user['last_name'];?></b> 
<?=$text;?>
 a  
<? if ($shift) { ?> 
<a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>" target="_blank">
shift
</a>
<? } else { ?>
shift
<? } ?> 
 on  

<?=date('jS F', $shift['start_time']);?>