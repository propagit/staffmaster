<h4>Applicant Information</h4>
<table cellpadding="0" cellspacing="10">
			<? $platform = $this->config_model->get('accounting_platform');
			foreach($applicant as $field) { ?>
				<? 
					$name = $field['name'];
					$value = $field['value'];
					if ($value) {
						if($name == 'dob') {
							$date = json_decode($value);
							$value = $date->day . '-' . $date->month . '-' . $date->year;
						} else if ($name == 'password') {
							$value = '******';
						} else if ($name == 'gender') {
							$value = ($value == 'm') ? 'Male' : 'Female';
						} else if ($name == 'email') {
							if ($user = modules::run('user/get_user_by_email', $value)) {
								$value .= ' <span class="text-danger"><i class="fa fa-times"></i> Email address is already used by <a href="' . base_url() . 'staff/edit/' . $user['user_id'] . '" target="_blank">a staff</a></span>';
							} else {
								$value .= ' <span class="text-success"><i class="fa fa-check"></i> Valid</span>';
							}
							
							
						} else if ($name == 's_fund_name' && $platform == 'myob') {
							$super_fund = modules::run('api/myob/connect', 'read_super_fund~' . $value);
							$value = $super_fund->Name;
						}
						else if ($name == 'location') {
							$value = modules::run('attribute/location/display_location', $value);
						} else if ($name == 'picture') {
							$pictures = json_decode($value);							
							$value = '';
							if (count($pictures) > 0) foreach($pictures as $picture) {
								$value .= '<img class="img-thumbnail" src="' . base_url() . UPLOADS_URL . '/tmp/' . $picture . '" href="' . base_url() . UPLOADS_URL . '/tmp/' . $picture . '" />';
							}
							
						} else if (is_array(json_decode($value))) {
							$values = json_decode($value);
							if ($name == 'availability') {
								$days = modules::run('common/array_day');
								$day_values = array();
								foreach($values as $day_number) {
									$day_values[] = $days[$day_number];
								}
								$values = $day_values;
							}
							else if ($name == 'role') {
								$role_values = array();
								foreach($values as $role_id) {
									$role_values[] = modules::run('attribute/role/display_role', $role_id);
								}
								$values = $role_values;
							}
							else if ($name == 'group') {
								$group_values = array();
								foreach($values as $group_id) {
									$group_values[] = modules::run('attribute/group/display_group', $group_id);
								}
								$values = $group_values;
							}
							$value = implode(', ', $values);
						}
					}
					if ($field['type'] == 'file') {
						$value = '<a href="' . base_url() . UPLOADS_URL . '/tmp/' . $value . '" target="_blank">' . $value . '</a>';
					}
					?>
				<tr valign="top">
					<td><?=$field['label'];?>&nbsp;</td>
					<td width="20"></td>
					<td><?=$value;?>&nbsp;</td>
				</tr>
			<? } ?>
</table>