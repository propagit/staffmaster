<div class="modal-dialog modal-lg modal-applicant">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title" id="myModalLabel">Applicant Information</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body">
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
					if ($field['type'] == 'fileDate') {
						if(file_exists(UPLOADS_URL . '/tmp/' . $value)){
							$value = '<a href="' . base_url() . UPLOADS_URL . '/tmp/' . $value . '" target="_blank">' . $value . '</a>';
						}
					}
					?>
				<div class="col-md-3 text-muted"><?=$field['label'];?>&nbsp;</div>
				<div class="col-md-9"><?=$value;?>&nbsp;</div>
			<? } ?>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-success" onclick="accept_applicant(<?=$applicant_id;?>, <?=STAFF_ACTIVE;?>, this)" data-loading-text="Please wait..."><i class="fa fa-check"></i> Approve to Staff</button>
			<button class="btn btn-warning" onclick="accept_applicant(<?=$applicant_id;?>, <?=STAFF_PENDING;?>, this)" data-loading-text="Please wait...">Add to Pending</button>
			<button class="btn btn-danger" onclick="reject_applicant(<?=$applicant_id;?>, this)" data-loading-text="Please wait...">Reject</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>

	$('.img-thumbnail').magnificPopup({
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
</script>
