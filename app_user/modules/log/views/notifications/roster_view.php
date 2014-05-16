<?
$user = modules::run('user/get_user', $log['user_id']);
$shift = modules::run('job/shift/get_shift', $log['object_id']);
$data = unserialize($log['description']);
?>
<? if ($data['status'] == SHIFT_REJECTED) { ?>
<span class="activity-warning"><i class="fa fa-exclamation-triangle"></i> Shift Rejected</span>
<? } else { ?>
<span class="activity-confirmation"><i class="fa fa-thumbs-o-up"></i> Shift Confirmed</span>
<? } ?>
 - 
<b><?=$user['first_name'] . ' ' . $user['last_name'];?></b> 
<? if ($data['status'] == SHIFT_REJECTED) { ?>
rejected 
<? } else { ?>
confirmed
<? } ?>
 a 
<? if ($shift) { ?>
<a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>" target="_blank">
shift
</a>
 on 
<?=date('jS F', $shift['start_time']);?>
<? } else { ?>
shift
<? } ?>
