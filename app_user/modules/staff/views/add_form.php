<?=modules::run('wizard/main_view', 'staff');?>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Add Staff</h2>
		 <p>Add staff using below form or import multiple staff.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            
            <ul class="nav nav-tabs tab-respond">
            	<li class="pull-right"><a href="<?=base_url();?>staff/import">Import Staff</a></li>
				<li class="mobile-tab active"><a>Personal Details</a></li>
				<li class="mobile-tab disabled"><a>Pictures</a></li>
				<li class="mobile-tab disabled"><a>Financial Details</a></li>
				<li class="mobile-tab disabled"><a>Super Details</a></li>
				<li class="mobile-tab disabled"><a>Roles</a></li>
				<li class="mobile-tab disabled"><a>Availability</a></li>
				<li class="mobile-tab disabled"><a>Locations</a></li>
				<li class="mobile-tab disabled"><a>Groups</a></li>
				<li class="mobile-tab disabled"><a>Attributes</a></li>
				<li class="mobile-tab disabled"><a>Documents</a></li>
				<li class="mobile-tab disabled"><a>Settings</a></li>
			</ul>
        
	        <p class="lg">Please note <span class="text-danger">**</span> denotes a required field</p>
			<form class="form-horizontal" role="form" id="form_add_staff">
			
			<div class="row">
				<div class="form-group">
					<div id="f_title">
						<label for="title" class="col-md-2 control-label">Title</label>
						<div class="col-md-4">
							<?=modules::run('common/field_select_title', 'title');?>
						</div>
					</div>
					<label for="rating" class="col-md-2 control-label">Rating</label>
					<div class="col-md-4">
                        <?=modules::run('common/field_rating', 'rating');?>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="form-group">
					<div id="f_first_name">
						<label for="first_name" class="col-md-2 control-label">First Name <span class="text-danger">**</span></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="first_name" name="first_name" />
						</div>
					</div>
					<div id="f_last_name">
						<label for="last_name" class="col-md-2 control-label">Last Name <span class="text-danger">**</span></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="last_name" name="last_name" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="gender" class="col-md-2 control-label">Gender</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_genders', 'gender');?>
					</div>
					
					<label for="dob" class="col-md-2 control-label">D.O.B(dd/mm/yy)</label>
					<div class="col-md-4">
						<?=modules::run('common/field_dob', 'dob');?>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="address" class="col-md-2 control-label">Address</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="address" name="address" />
					</div>					
					<label for="suburb" class="col-md-2 control-label">Suburb</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="suburb" name="suburb" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-md-2 control-label">City</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="city" name="city" />
					</div>
					<label for="postcode" class="col-md-2 control-label">Postcode</label>
					<div class="col-md-4">
						<input type="text" class="form-control auto-width" id="postcode" name="postcode" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="state" class="col-md-2 control-label">State</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_states', 'state');?>
					</div>					
					<label for="country" class="col-md-2 control-label">Country</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_countries', 'country');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div id="f_email_address">
						<label for="email_address" class="col-md-2 control-label">Email <span class="text-danger">**</span></label>
						<div class="col-md-4">
							<input type="text" class="form-control" id="email_address" name="email_address" />
						</div>
					</div>
					<label for="phone" class="col-md-2 control-label">Mobile Phone</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="phone" name="mobile" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<div id="f_password">
						<label for="password" class="col-md-2 control-label">Password <span class="text-danger">**</span></label>
						<div class="col-md-4">
							<input type="password" class="form-control" id="password" name="password" />
						</div>
					</div>
					<label for="external_staff_id" class="col-md-2 control-label">External ID</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="form-group">
					<label for="department_id" class="col-md-2 control-label">Group</label>
					<div class="col-md-4">
						<?=modules::run('attribute/group/field_select','group_id');?>
					</div>
				</div>				
			</div>
			
			<div class="row">
				<div class="form-group">
					<label for="emergency_contact" class="col-md-2 control-label">Emergency Contact</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" />
					</div>
					<label for="emergency_phone" class="col-md-2 control-label">Emergency Phone</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" />
					</div>
				</div>				
			</div>
						
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="button" class="btn btn-core" id="btn_add_staff" data-loading-text="Adding staff..."><i class="fa fa-plus"></i> Add Staff</button>
					</div>
				</div>
			</div>
		
		
			</form>
    	</div>
    </div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$('#btn_add_staff').click(function(){
		var btn = $(this);
		btn.button('loading');
		$('.form-group').find('div[id^=f_]').removeClass('has-error');
		$('#form_add_staff').find('input').tooltip('destroy');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/add_staff",
			data: $('#form_add_staff').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					btn.button('reset');
					$('#f_' + data.error_id).addClass('has-error');
					$('input[name="' + data.error_id + '"]').tooltip({
						title: data.msg,
						placement: 'bottom'
					});
					$('input[name="' + data.error_id + '"]').focus();
				} else {
					window.location = '<?=base_url();?>staff/edit/' + data.user_id;
				}
			}
		})
	})
})
</script>