<div class="modal-dialog modal-lg modal-applicant">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title" id="myModalLabel">Applicant Information</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body">
			<? foreach($applicant as $field) { ?>
				<? 
					$name = $field['name'];
					$value = $field['value'];
					if($name == 'dob') {
						$date = json_decode($value);
						$value = $date->day . '-' . $date->month . '-' . $date->year;
					} else if ($name == 'password') {
						$value = '******';
					} else if ($name == 'gender') {
						$value = ($value == 'm') ? 'Male' : 'Female';
					} else if ($name == 'location') {
						$value = modules::run('attribute/location/display_location', $value);
					} else if ($name == 'picture') {
						$pictures = json_decode($value);
						if (isset($pictures[0])) {
							$pictures = json_decode($pictures[0]);
							$value = '';
							foreach($pictures as $picture) {
								$value .= '<img class="img-thumbnail" src="' . base_url() . UPLOADS_URL . '/tmp/' . $picture . '" />';
							}
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
					?>
				<div class="col-md-3 text-muted"><?=$field['label'];?>&nbsp;</div>
				<div class="col-md-9"><?=$value;?>&nbsp;</div>
			<? } ?>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-core" onclick="accept_applicant(<?=$applicant_id;?>)">Add to Staff</button>
			<button class="btn btn-danger" onclick="reject_applicant(<?=$applicant_id;?>)">Reject</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->