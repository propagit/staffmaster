<h2>Add Staff</h2>
<p>Add staff using below form or import multiple staff.</p>


<a href="<?=base_url();?>staff/search"><i class="icon-plus-sign"></i> Search Staff</a>
<br /><br />
<div class="panel">
	<div class="panel-heading">Add New Staff</div>
	<div class="panel-body">
		<ul class="nav nav-pills">
			<li class="active"><a href="#">Personal Details</a></li>
			<li class="disabled"><a href="#">Financial Details</a></li>
			<li class="disabled"><a href="#">Super Details</a></li>
			<li class="disabled"><a href="#">Availability</a></li>
			<li class="disabled"><a href="#">Roles</a></li>
			<li class="disabled"><a href="#">Pay Rate</a></li>
			<li class="disabled"><a href="#">Options</a></li>
			<li class="disabled"><a href="#">Location</a></li>
			<li class="disabled"><a href="#">Settings</a></li>
			<li class="disabled"><a href="#">Documents</a></li>
		</ul>
		<br />
		<p>Please note <span class="required">**</span> denotes a required field</p>
		<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>staff/add">
		<br />
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="title" class="col-lg-4 control-label">Title</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_titles', 'title', set_value('title'));?>
					</div>
				</div>
				<div class="form-group<?=form_error('first_name')? ' has-error' : '';?>">
					<label for="first_name" class="col-lg-4 control-label">First Name <span class="required">**</span></label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="first_name" name="first_name" value="<?=set_value('first_name');?>" tabindex="2" />
					</div>
				</div>
				<div class="form-group<?=form_error('gender')? ' has-error' : '';?>">
					<label for="gender" class="col-lg-4 control-label">Gender <span class="required">**</span></label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_genders', 'gender', set_value('gender'));?>
					</div>
				</div>
				<div class="form-group">
					<label for="address" class="col-lg-4 control-label">Address</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="address" name="address" value="<?=set_value('address');?>" tabindex="8" />
					</div>
				</div>
				<div class="form-group">
					<label for="city" class="col-lg-4 control-label">City</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="city" name="city" value="<?=set_value('city');?>" tabindex="10" />
					</div>
				</div>
				<div class="form-group">
					<label for="state" class="col-lg-4 control-label">State</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_states', 'state', set_value('state'));?>
					</div>
				</div>
				<div class="form-group<?=form_error('email_address')? ' has-error' : '';?>">
					<label for="email_address" class="col-lg-4 control-label">Email <span class="required">**</span></label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="email_address" name="email_address" value="<?=set_value('email_address');?>" tabindex="14" />
					</div>
				</div>
				<div class="form-group">
					<label for="department_id" class="col-lg-4 control-label">Department</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/department/dropdown','department_id', set_value('department_id'));?>
					</div>
				</div>
				<div class="form-group">
					<label for="emergency_contact" class="col-lg-4 control-label">Emergency Contact</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?=set_value('emergency_contact');?>" tabindex="18" />
					</div>
				</div>
				<div class="form-group<?=form_error('password')? ' has-error' : '';?>">
					<label for="password" class="col-lg-4 control-label">Password <span class="required">**</span></label>
					<div class="col-lg-8">
						<input type="password" class="form-control" id="password" name="password" value="<?=set_value('password');?>" tabindex="20" />
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="rating" class="col-lg-4 control-label">Rating</label>
					<div class="col-lg-8">
						<div class="rating pull-left">
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
						</div>
					</div>
				</div>
				<div class="form-group<?=form_error('last_name')? ' has-error' : '';?>">
					<label for="last_name" class="col-lg-4 control-label">Last Name <span class="required">**</span></label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="last_name" name="last_name" value="<?=set_value('last_name');?>" tabindex="3" />
					</div>
				</div>
				<div class="form-group">
					<label for="dob" class="col-lg-4 control-label">D.O.B(dd/mm/yy)</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_dob', set_value('dob_day'), set_value('dob_month'), set_value('dob_year'));?>
					</div>					
				</div>
				<div class="form-group">
					<label for="suburb" class="col-lg-4 control-label">Suburb</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="suburb" name="suburb" value="<?=set_value('suburb');?>" tabindex="9" />
					</div>
				</div>
				<div class="form-group">
					<label for="postcode" class="col-lg-4 control-label">Postcode</label>
					<div class="col-lg-8">
						<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=set_value('postcode');?>" tabindex="11" />
					</div>
				</div>
				<div class="form-group">
					<label for="country" class="col-lg-4 control-label">Country</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_countries', 'country', set_value('country'));?>
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="col-lg-4 control-label">Mobile Phone</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone');?>" tabindex="15" />
					</div>
				</div>
				<div class="form-group">
					<label for="role" class="col-lg-4 control-label">Role</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="role" name="role" value="<?=set_value('role');?>" tabindex="17" />
					</div>
				</div>
				<div class="form-group">
					<label for="emergency_phone" class="col-lg-4 control-label">Emergency Phone</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?=set_value('emergency_phone');?>" tabindex="19" />
					</div>
				</div>
				<div class="form-group">
					<label for="external_staff_id" class="col-lg-4 control-label">External ID</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" value="<?=set_value('external_staff_id');?>" tabindex="21" />
					</div>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="col-lg-offset-4 col-lg-8">
						<button type="submit" class="btn btn-info"><i class="icon-plus-sign"></i> Add Staff</button>
					</div>
				</div>
			</div>
		</div>
		
		
		</form>
	</div>
</div>