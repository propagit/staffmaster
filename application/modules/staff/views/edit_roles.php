<div class="staff-profile-detail-box">
	<h2> Roles </h2>
	<p> Roles can be created in the edit attributes section. Assigning roles to your staff will allow you to search for staff by role. <br />Staff can also apply for jobs for roles they are allocated to below. </p>
</div>

<form class="form-horizontal" role="form" id="form_update_staff_roles">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Roles</label>
		<div class="col-md-10">
			<? 
			$staff_roles = array();
			if ($staff['roles'])
			{
				$staff_roles = json_decode($staff['roles']);
			}
			$roles = modules::run('attribute/role/get_roles');
			$n = count($roles);
			for ($i=0; $i<$n; $i = $i+2) { ?>
			<div class="row">
				<div class="col-md-1"><input type="checkbox" name="roles[]" value="<?=$roles[$i]['role_id'];?>"<?=(in_array($roles[$i]['role_id'], $staff_roles)) ? ' checked' : '';?> /> </div>
				<div class="col-md-4 label_checkbox"><?=$roles[$i]['name'];?></div>
				<? if (isset($roles[$i+1])) { ?>
				<div class="col-md-1"><input type="checkbox" name="roles[]" value="<?=$roles[$i+1]['role_id'];?>"<?=(in_array($roles[$i+1]['role_id'], $staff_roles)) ? ' checked' : '';?> /> </div>
				<div class="col-md-4 label_checkbox"><?=$roles[$i+1]['name'];?></div>
				<? } ?>
			</div>
			<? }  ?>
		</div>
	</div>
</div>
</form>
<script>
$(function(){
	$('#form_update_staff_roles input[type="checkbox"]').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_roles",
			data: $('#form_update_staff_roles').serialize(),
			success: function(html) {
			}
		})
	})
})
</script>