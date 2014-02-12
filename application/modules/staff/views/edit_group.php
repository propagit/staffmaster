<div class="staff-profile-detail-box">
	<h2> Groups </h2>
	<p> Staff can choose the "Groups" </p>
</div>

<div class="row">
	<div class="form-group">
		<label for="department_id" class="col-md-2 control-label">Group</label>
		<div class="col-md-4">
			<?=modules::run('attribute/group/field_select','group_id', $staff['group_id']);?>
		</div>
	</div>				
</div>