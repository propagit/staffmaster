<div class="staff-profile-detail-box">
	<h2> Personal Details </h2>
	<p>Please note <span class="text-danger">**</span> denotes a required field</p>
</div>
<form class="form-horizontal" role="form" id="form_update_staff_personal">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">Title</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_title', 'title', $staff['title']);?>
		</div>
        <label for="gender" class="col-md-2 control-label">Gender</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_genders', 'gender', $staff['gender']);?>
		</div>		
	</div>	
</div>
<div class="row">
	<div class="form-group">
		<div id="f_first_name">
			<label for="first_name" class="col-md-2 control-label">First Name <span class="text-danger">**</span></label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$staff['first_name'];?>" />
			</div>
		</div>
		<div id="f_last_name">
			<label for="last_name" class="col-md-2 control-label">Family Name <span class="text-danger">**</span></label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="last_name" name="last_name" value="<?=$staff['last_name'];?>" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">				
		<label for="dob" class="col-md-2 control-label">D.O.B(dd/mm/yy)</label>
		<div class="col-md-4">
			<?=modules::run('common/dropdown_dob', date('d',strtotime($staff['dob'])), date('m',strtotime($staff['dob'])),date('Y',strtotime($staff['dob'])));?>
		</div>
        <? if(!modules::run('auth/is_staff')){ ?>
        <label for="rating" class="col-md-2 control-label">Rating</label>
		<div class="col-md-4 wp-rating" id="wp_rating">
            <?=modules::run('common/field_rating', 'profile_rating', $staff['rating'],'basic','wp-rating',$staff['user_id'],true,false);?>
		</div>
        <? } ?>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="address" class="col-md-2 control-label">Address</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="address" name="address" value="<?=$staff['address'];?>" />
		</div>					
		<label for="suburb" class="col-md-2 control-label">Suburb</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$staff['suburb'];?>"  />
		</div>
        
	</div>
</div>
<div class="row">
	<div class="form-group">		
		<label for="postcode" class="col-md-2 control-label">Postcode</label>
		<div class="col-md-4">
			<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=$staff['postcode'];?>"  />
		</div>
        
        <label for="state" class="col-md-2 control-label">State</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_states', 'state', $staff['state']);?>
		</div>	
        
	</div>
</div>
<div class="row">
	<div class="form-group">				
		<label for="country" class="col-md-2 control-label">Country</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_countries', 'country', $staff['country']);?>
		</div>		
        
        <label for="mobile" class="col-md-2 control-label">Mobile Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="mobile" name="mobile" value="<?=$staff['mobile'];?>"  />
		</div>
        
	</div>
</div>
<div class="row">
	<div class="form-group">						
        <label for="phone" class="col-md-2 control-label">Telephone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="phone" name="phone" value="<?=$staff['phone'];?>"  />
		</div>
		<div id="f_email_address">
	        <label for="email_address" class="col-md-2 control-label">Email (Username) <span class="text-danger">**</span></label>
			<div class="col-md-4">
				<input type="text" class="form-control" id="email_address" name="email_address" value="<?=$staff['email_address'];?>" />
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="form-group">
		<label for="password" class="col-md-2 control-label">Password</label>
		<div class="col-md-4">
			<input type="password" class="form-control" id="password" name="password" value=""  />
		</div>	
        <label for="emergency_contact" class="col-md-2 control-label">Emergency Contact</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?=$staff['emergency_contact'];?>"  />
		</div>
		
	</div>				
</div>
<div class="row">
	<div class="form-group">
    	<label for="emergency_phone" class="col-md-2 control-label">Emergency Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?=$staff['emergency_phone'];?>" />
		</div>
        <label for="external_id" class="col-md-2 control-label">External Staff ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" value="<?=$staff['external_staff_id'];?>"  />
		</div>
    </div>
</div>
<? if(!modules::run('auth/is_staff')){ ?>	
<div class="row">
	<div class="form-group">
		<label for="status" class="col-md-2 control-label">Status</label>
		<div class="col-md-4">
			<?=modules::run('staff/field_select_status', 'status', (int)$staff['status']);?>
		</div>
	</div> 
</div>
<? } ?>
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
		$('.form-group').find('div[id^=f_]').removeClass('has-error');
		$('#form_update_staff_personal').find('input').tooltip('destroy');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_personal",
			data: $('#form_update_staff_personal').serialize(),
			success: function(data) {
				var title = $('#title').val();
				if (title) { $('#staff-title').html(title + ". "); }
				else { $('#staff-title').html(''); }
				$('#staff-name').html($('#first_name').val() + " " + $('#last_name').val());
				
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
					$('input[name="' + data.error_id + '"]').tooltip({
						title: data.msg,
						placement: 'bottom'
					});
					$('input[name="' + data.error_id + '"]').focus();
				} else {
					//$('#wp-rating').html(html);
					$('#msg-update-personal').removeClass('hide');
					setTimeout(function(){
						$('#msg-update-personal').addClass('hide');
					}, 2000);
				}
			}	
		})
	})
})
</script>