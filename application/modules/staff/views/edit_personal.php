<p class="lg">Please note <span class="text-danger">**</span> denotes a required field</p>
<form class="form-horizontal" role="form" id="form_update_staff_personal">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Title</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_title', 'title', $staff['title']);?>
		</div>
		<label for="rating" class="col-md-2 control-label">Rating</label>
		<div class="col-md-4" id="wp_rating">
            <?=modules::run('common/field_rating', 'rating', $staff['rating']);?>
		</div>
	</div>	
</div>
<div class="row">
	<div class="form-group">
		<label for="first_name" class="col-md-2 control-label">First Name <span class="text-danger">**</span></label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$staff['first_name'];?>" tabindex="2" />
		</div>
		<label for="last_name" class="col-md-2 control-label">Last Name <span class="text-danger">**</span></label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="last_name" name="last_name" value="<?=$staff['last_name'];?>" tabindex="3" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="gender" class="col-md-2 control-label">Gender <span class="text-danger">**</span></label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_genders', 'gender', $staff['gender']);?>
		</div>
		
		<label for="dob" class="col-md-2 control-label">D.O.B(dd/mm/yy)</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_dob', 'dob');?>
			<? #=modules::run('common/dropdown_dob', set_value('dob_day'), set_value('dob_month'), set_value('dob_year'));?>
		</div>	
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="address" class="col-md-2 control-label">Address</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="address" name="address" value="<?=$staff['address'];?>" tabindex="8" />
		</div>					
		<label for="suburb" class="col-md-2 control-label">Suburb</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$staff['suburb'];?>" tabindex="9" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="city" class="col-md-2 control-label">City</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="city" name="city" value="<?=$staff['city'];?>" tabindex="10" />
		</div>
		<label for="postcode" class="col-md-2 control-label">Postcode</label>
		<div class="col-md-4">
			<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=$staff['postcode'];?>" tabindex="11" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="state" class="col-md-2 control-label">State</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_states', 'state', $staff['state']);?>
		</div>					
		<label for="country" class="col-md-2 control-label">Country</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_countries', 'country', $staff['country']);?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="email_address" class="col-md-2 control-label">Email <span class="text-danger">**</span></label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="email_address" name="email_address" value="<?=$staff['email_address'];?>" tabindex="14" />
		</div>
		
		<label for="phone" class="col-md-2 control-label">Mobile Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="phone" name="phone" value="<?=$staff['phone'];?>" tabindex="15" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="password" class="col-md-2 control-label">Password <span class="text-danger">**</span></label>
		<div class="col-md-4">
			<input type="password" class="form-control" id="password" name="password" value="" tabindex="20" />
		</div>
		<label for="external_staff_id" class="col-md-2 control-label">External ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" value="<?=$staff['external_staff_id'];?>" tabindex="21" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="department_id" class="col-md-2 control-label">Group</label>
		<div class="col-md-4">
			<?=modules::run('attribute/group/field_select','group_id', $staff['group_id']);?>
		</div>
	</div>				
</div>
<div class="row">
	<div class="form-group">
		<label for="emergency_contact" class="col-md-2 control-label">Emergency Contact</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?=$staff['emergency_contact'];?>" tabindex="18" />
		</div>
		<label for="emergency_phone" class="col-md-2 control-label">Emergency Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?=$staff['emergency_phone'];?>" tabindex="19" />
		</div>
	</div>				
</div>
			
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<div class="alert alert-success hide" id="msg-update-personal"><i class="fa fa-check"></i> &nbsp; Staff personal details has been updated successfully!</div>
			<button type="button" class="btn btn-core" id="btn_update_personal"><i class="fa fa-save"></i> Update Personal Details</button>
		</div>
	</div>
</div>


</form>
<script>
$(function(){
	$('#btn_update_personal').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_personal",
			data: $('#form_update_staff_personal').serialize(),
			success: function(html) {
				$('#wp_rating').html(html);
				$('#msg-update-personal').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-personal').addClass('hide');
				}, 2000);
			}	
		})
	})
})
</script>