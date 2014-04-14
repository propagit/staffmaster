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
				<li class="mobile-tab disabled"><a>Financial Details</a></li>
				<li class="mobile-tab disabled"><a>Super Details</a></li>
				<li class="mobile-tab disabled"><a>Availability</a></li>
				<li class="mobile-tab disabled"><a>Roles</a></li>
				<li class="mobile-tab disabled"><a>Options</a></li>
				<li class="mobile-tab disabled"><a>Location</a></li>
				<li class="mobile-tab disabled"><a>Settings</a></li>
				<li class="mobile-tab disabled"><a>Documents</a></li>
			</ul>
        
	        <p class="lg">Please note <span class="text-danger">**</span> denotes a required field</p>
			<form class="form-horizontal" role="form" id="form_add_staff" method="post" action="<?=base_url();?>staff/add">
			
			<div class="row">
				<div class="form-group">
					<label for="title" class="col-md-2 control-label">Title</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_title', 'title', set_value('title'));?>
					</div>
					<label for="rating" class="col-md-2 control-label">Rating</label>
					<div class="col-md-4">
                        <?=modules::run('common/field_rating', 'rating');?>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="form-group<?=form_error('first_name')? ' has-error' : '';?>">
					<label for="first_name" class="col-md-2 control-label">First Name <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="first_name" name="first_name" value="<?=set_value('first_name');?>" tabindex="2" />
					</div>
					<label for="last_name" class="col-md-2 control-label">Last Name <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="last_name" name="last_name" value="<?=set_value('last_name');?>" tabindex="3" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group<?=form_error('gender')? ' has-error' : '';?>">
					<label for="gender" class="col-md-2 control-label">Gender <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_genders', 'gender', set_value('gender'));?>
					</div>
					
					<label for="dob" class="col-md-2 control-label">D.O.B(dd/mm/yy)</label>
					<div class="col-md-4">
						<?=modules::run('common/dropdown_dob', set_value('dob_day'), set_value('dob_month'), set_value('dob_year'));?>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="address" class="col-md-2 control-label">Address</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="address" name="address" value="<?=set_value('address');?>" tabindex="8" />
					</div>					
					<label for="suburb" class="col-md-2 control-label">Suburb</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="suburb" name="suburb" value="<?=set_value('suburb');?>" tabindex="9" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="city" class="col-md-2 control-label">City</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="city" name="city" value="<?=set_value('city');?>" tabindex="10" />
					</div>
					<label for="postcode" class="col-md-2 control-label">Postcode</label>
					<div class="col-md-4">
						<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=set_value('postcode');?>" tabindex="11" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="state" class="col-md-2 control-label">State</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_states', 'state', set_value('state'));?>
					</div>					
					<label for="country" class="col-md-2 control-label">Country</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_countries', 'country', set_value('country'));?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group<?=form_error('email_address')? ' has-error' : '';?>">
					<label for="email_address" class="col-md-2 control-label">Email <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="email_address" name="email_address" value="<?=set_value('email_address');?>" tabindex="14" />
					</div>
					
					<label for="phone" class="col-md-2 control-label">Mobile Phone</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone');?>" tabindex="15" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group<?=form_error('password')? ' has-error' : '';?>">
					<label for="password" class="col-md-2 control-label">Password <span class="text-danger">**</span></label>
					<div class="col-md-4">
						<input type="password" class="form-control" id="password" name="password" value="<?=set_value('password');?>" tabindex="20" />
					</div>
					<label for="external_staff_id" class="col-md-2 control-label">External ID</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" value="<?=set_value('external_staff_id');?>" tabindex="21" />
					</div>
				</div>
			</div>
            <?php if(0){ ?>
			<div class="row">
				<div class="form-group">
					<label for="department_id" class="col-md-2 control-label">Group</label>
					<div class="col-md-4">
						<?=modules::run('attribute/group/field_select','group_id', set_value('group_id'));?>
					</div>
				</div>				
			</div>
            <?php } ?>
			<div class="row">
				<div class="form-group">
					<label for="emergency_contact" class="col-md-2 control-label">Emergency Contact</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?=set_value('emergency_contact');?>" tabindex="18" />
					</div>
					<label for="emergency_phone" class="col-md-2 control-label">Emergency Phone</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?=set_value('emergency_phone');?>" tabindex="19" />
					</div>
				</div>				
			</div>
						
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="submit" class="btn btn-core" id="btn_add_staff"><i class="fa fa-plus"></i> Add Staff</button>
					</div>
				</div>
			</div>
		
		
			</form>
    	</div>
    </div>
</div>
<!--end bottom box -->

<script>
init_select();

/* $(function(){
	$('#btn_add_staff').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/add_staff",
			data: $('#form_add_staff').serialize(),
			success: function(html)
			{
				data = $.parseJSON(data);
			}
		})
	})
}) */
</script>