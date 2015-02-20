<div class="staff-profile-detail-box">
	<h2>Settings</h2>
</div>
<form class="form-horizontal" role="form" id="form-level-access">
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Level Access</label>
		<div class="col-md-4">
			<?
				$value = 'staff';
				if ($staff['is_admin'])
				{
					$value = 'admin';
				}
				$array = array(
					array('value' => 'staff', 'label' => 'Staff'),
					array('value' => 'admin', 'label' => 'Admin')
				);
				echo modules::run('common/field_select', $array, 'level_access', $value);
			?>
		</div>
	</div>
	<div class="form-group hide" id="msg-update-setting">
		<div class="col-md-4 col-md-offset-2">
			<div class="alert alert-success">Staff Level Access has been updated!</div>
		</div>
	</div>
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Induction Completed</label>
		<div class="col-md-10" id="list-inductions">

		</div>
	</div>
</div>

<script>
$(function(){
	$('#level_access').change(function(){
		preloading($('#form-level-access'));
		var level = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_level_access",
			data: {user_id: <?=$staff['user_id']?>, level: level},
			success: function(html) {
				loaded($('#form-level-access'));
				$('#msg-update-setting').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-setting').addClass('hide');
				}, 2000);
			}
		})
	});
	get_induction(<?=$staff['user_id']?>);
})
function get_induction(user_id) {
	preloading($('#list-inductions'));
	$.ajax({
		type: "GET",
		url: "<?=base_url();?>staff/ajax/get_inductions/" + user_id,
		success: function(html) {
			loaded($('#list-inductions'), html);
		}
	})
}
</script>
