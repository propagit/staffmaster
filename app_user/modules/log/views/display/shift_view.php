
<?
$user = modules::run('user/get_user', $log['user_id']);
$shift = modules::run('job/shift/get_shift', $log['object_id']);
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
<?=$log['action'];?>d
<b><?=$log['total'];?></b> 
<a href="<?=base_url();?>job/details/<?=$shift['job_id'];?>/<?=$shift['job_date'];?>" target="_blank">
	shift<? if($log['total'] > 1) { echo 's'; } ?>
	
</a><? if ($log['action'] == 'update') {
	echo '\'s ';
	$desc = unserialize($log['description']);
	$k = 0;
	foreach($desc as $field => $value) {
		if ($k > 0) 
		{  
			echo ', ';
		}
		switch($field) {
			case 'status':	echo 'status to <b>' . modules::run('job/shift/status_to_text', $value) . '</b>';
				break;
			case 'start_time': echo 'start time to <b>' . date('H:i', $value) . '</b>';
				break;
			case 'finish_time': echo 'finish time to <b>' . date('H:i', $value) . '</b>';
				break;
			case 'role_id': echo 'role to <b>' . modules::run('attribute/role/display_role', $value). '</b>';
				break;
			case 'venue_id': echo 'venue to <b>' . modules::run('attribute/venue/display_venue', $value). '</b>';
				break;
			case 'payrate_id': echo 'pay rate to <b>' . modules::run('attribute/payrate/display_payrate', $value) . '</b>';
				break;
			case 'uniform_id': echo 'uniform to <b>' . modules::run('attribute/uniform/display_uniform', $value) . '</b>';
				break;
			case 'break_time': echo 'break time to <b>' . modules::run('common/break_time', $value) . '</b>';
				break;
			case 'staff_id': 
					$staff = modules::run('user/get_user', $value);
					echo 'staff to <b>' . $staff['first_name'] . ' ' . $staff['last_name'] . '</b>';
				break;
			case 'supervisor_id': 
					$supervisor = modules::run('user/get_user', $value);
					echo 'supervisor to <b>' . $supervisor['first_name'] . ' ' . $supervisor['last_name'] . '</b>';
				break;
			case 'expenses':
					echo 'expenses to <b>$' . modules::run('common/calculate_expenses', $value) . '</b>';
				break;
		}
		$k++;
	}
} ?>