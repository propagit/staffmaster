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
	<? /*
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Conversations</label>
		<div class="col-md-4">
			<?
				$array = array(
					array('value' => 'Invited Conversations Only', 'label' => 'Invited Conversations Only')
				);
				echo modules::run('common/field_select', $array, 'conversation');
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Induction Status</label>
		<div class="col-md-10">
			<div class="alert alert-success media">
				<div class="pull-left">
					<i class="fa fa-check"></i>
				</div>
				<div class="pull-right">
					<?
						$array = array(
							array('value' => 'Induction Completed', 'label' => 'Induction Completed')
						);
						echo modules::run('common/field_select', $array, 'induction');
					?>
				</div>
				<div class="media-body">
					<h4>Induction Completed</h4>
					<h6>Induction completed on 24/03/2013</h6>
				</div>
			</div>
		</div>
	</div>
	*/ ?>
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
	})
})
</script>