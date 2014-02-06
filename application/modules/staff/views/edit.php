<h2>Edit Staff</h2>
<p>Edit staff using below form.</p>


<a href="<?=base_url();?>staff/search"><i class="fa fa-search"></i> Search Staff</a>
<br /><br />
<div class="panel panel-default">
	<div class="panel-heading">Edit Staff</div>
	<div class="panel-body">
		<ul class="nav nav-tabs" id="navStaff">
			<li class="active"><a href="#personal" data-toggle="tab">Personal Details</a></li>
			<li><a href="#financial" data-toggle="tab">Financial Details</a></li>
			<li><a href="#super" data-toggle="tab">Super Details</a></li>
			<li><a href="#availability" data-toggle="tab">Availability</a></li>
			<li><a href="#roles" data-toggle="tab">Roles</a></li>
			<li><a href="#payrate" data-toggle="tab">Pay Rate</a></li>
			<li><a href="#option" data-toggle="tab">Options</a></li>
			<li><a href="#location" data-toggle="tab">Location</a></li>
			<li><a href="#setting" data-toggle="tab">Settings</a></li>
			<li><a href="#document" data-toggle="tab">Documents</a></li>
            <li><a href="#picture" data-toggle="tab">Pictures</a></li>
		</ul>

		
		
		
		<form id="edit_form" class="form-horizontal" role="form" method="post" action="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>" onsubmit="" autocomplete="off" >
		<input type="hidden" name="tab_id" id="tab_id" />				
			<div class="tab-content">
				<div class="tab-pane active" id="personal">
                	<br />
					<p>Please note <span class="required">**</span> denotes a required field</p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="title" class="col-lg-4 control-label">Title</label>
								<div class="col-lg-8">
									<?=modules::run('common/dropdown_titles', 'title', $staff['title']);?>
								</div>
							</div>
							<div class="form-group<?=form_error('first_name')? ' has-error' : '';?>">
								<label for="first_name" class="col-lg-4 control-label">First Name <span class="required">**</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$staff['first_name'];?>" tabindex="2" />
								</div>
							</div>
							<div class="form-group<?=form_error('gender')? ' has-error' : '';?>">
								<label for="gender" class="col-lg-4 control-label">Gender <span class="required">**</span></label>
								<div class="col-lg-8">
									<?=modules::run('common/dropdown_genders', 'gender', $staff['gender']);?>
								</div>
							</div>
							<div class="form-group">
								<label for="address" class="col-lg-4 control-label">Address</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="address" name="address" value="<?=$staff['address'];?>" tabindex="8" />
								</div>
							</div>
							<div class="form-group">
								<label for="city" class="col-lg-4 control-label">City</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="city" name="city" value="<?=$staff['city'];?>" tabindex="10" />
								</div>
							</div>
							<div class="form-group">
								<label for="state" class="col-lg-4 control-label">State</label>
								<div class="col-lg-8">
									<?=modules::run('common/dropdown_states', 'state', $staff['state']);?>
								</div>
							</div>
							<div class="form-group<?=form_error('email_address')? ' has-error' : '';?>">
								<label for="email_address" class="col-lg-4 control-label">Email <span class="required">**</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="email_address" name="email_address" value="<?=$staff['email_address'];?>"/>
								</div>
							</div>
							<div class="form-group">
								<label for="department_id" class="col-lg-4 control-label">Department</label>
								<div class="col-lg-8">
									<?=modules::run('attribute/department/dropdown','department_id', $staff['department_id']);?>
								</div>
							</div>
							<div class="form-group">
								<label for="emergency_contact" class="col-lg-4 control-label">Emergency Contact</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?=$staff['emergency_contact'];?>" tabindex="18" />
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-lg-4 control-label">Password</label>
								<div class="col-lg-8">
									<input type="password" class="form-control" id="password" name="password" value="" tabindex="20" />
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="rating" class="col-lg-4 control-label">Rating</label>
								<div class="col-lg-8">									
                                    <?=modules::run('common/select_rating', 'rating',($staff['rating']==0) ? '0' : $staff['rating']);?>                                    
								</div>
							</div>
							<div class="form-group<?=form_error('last_name')? ' has-error' : '';?>">
								<label for="last_name" class="col-lg-4 control-label">Last Name <span class="required">**</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="last_name" name="last_name" value="<?=$staff['last_name'];?>" tabindex="3" />
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
									<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$staff['suburb'];?>" tabindex="9" />
								</div>
							</div>
							<div class="form-group">
								<label for="postcode" class="col-lg-4 control-label">Postcode</label>
								<div class="col-lg-8">
									<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=$staff['postcode'];?>" tabindex="11" />
								</div>
							</div>
							<div class="form-group">
								<label for="country" class="col-lg-4 control-label">Country</label>
								<div class="col-lg-8">
									<?=modules::run('common/dropdown_countries', 'country', $staff['country']);?>
								</div>
							</div>
							<div class="form-group">
								<label for="phone" class="col-lg-4 control-label">Mobile Phone</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="phone" name="phone" value="<?=$staff['phone'];?>" tabindex="15" />
								</div>
							</div>
							<div class="form-group">
								<label for="role" class="col-lg-4 control-label">Role</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="role" name="role" value="<?=$staff['role'];?>" tabindex="17" />
								</div>
							</div>
							<div class="form-group">
								<label for="emergency_phone" class="col-lg-4 control-label">Emergency Phone</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="emergency_phone" name="emergency_phone" value="<?=$staff['emergency_phone'];?>" tabindex="19" />
								</div>
							</div>
							<div class="form-group">
								<label for="external_staff_id" class="col-lg-4 control-label">External ID</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="external_staff_id" name="external_staff_id" value="<?=$staff['external_staff_id'];?>" tabindex="21" />
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="tab-pane" id="financial">
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-lg-5 control-label">Are you an Australian Resident?</label>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_aus_resident" value="1"<?=($staff['f_aus_resident']) ? ' checked' : '';?> /> Yes
									</div>
								</div>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_aus_resident" value="0"<?=($staff['f_aus_resident'] == 0) ? ' checked' : '';?> /> No
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-5 control-label">Do you want to claim the tax free threshold?</label>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_tax_free_threshold" value="1"<?=($staff['f_tax_free_threshold']) ? ' checked' : '';?> /> Yes
									</div>
								</div>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_tax_free_threshold" value="0"<?=($staff['f_tax_free_threshold'] == 0) ? ' checked' : '';?> /> No
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-5 control-label">Do you want to claim the Senior Australian Tax offset?</label>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_tax_offset" value="1"<?=($staff['f_tax_offset']) ? ' checked' : '';?> /> Yes
									</div>
								</div>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_tax_offset" value="0"<?=($staff['f_tax_offset'] == 0) ? ' checked' : '';?> /> No
									</div>
								</div>
							</div>
							
							<div class="form-group" id="f_senior_status">
								<label class="col-lg-5 control-label">Your senior couple status <span class="required">**</span></label>
								<div class="col-lg-1">
									<select name="f_senior_status" class="form-control auto-width">
										<option value="None" <?=($staff['f_senior_status']=="None") ? ' selected=selected' : '';?>>None</option>
										<option value="Member of couple" <?=($staff['f_senior_status']=="Member of couple") ? ' selected=selected' : '';?>>Member of couple</option>
										<option value="Member of illness-separated couple" <?=($staff['f_senior_status']=="Member of illness-separated couple") ? ' selected=selected' : '';?>>Member of illness-separated couple</option>
										<option value="Single" <?=($staff['f_senior_status']=="Single") ? ' selected=selected' : '';?>>Single</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-5 control-label">Do you have a HELP (higher education loan program) debt?</label>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_help_debt" value="1"<?=($staff['f_help_debt']) ? ' checked' : '';?> /> Yes
									</div>
								</div>
								<div class="col-lg-1">
									<div class="radio">
										<input type="radio" name="f_help_debt" value="0"<?=($staff['f_help_debt'] == 0) ? ' checked' : '';?> /> No
									</div>
								</div>
							</div>
							
							<div class="form-group" id="f_help_variation">
								<label class="col-lg-5 control-label">Your HELP variation <span class="required">**</span></label>
								<div class="col-lg-1">
									<select name="f_help_variation" class="form-control auto-width">
										<option value="HELP" <?=($staff['f_help_variation']=="HELP") ? ' selected=selected' : '';?>>HELP</option>
										<option value="SFSS" <?=($staff['f_help_variation']=="SFSS") ? ' selected=selected' : '';?>>SFSS</option>
										<option value="HELP + SFSS" <?=($staff['f_help_variation']=="HELP + SFSS") ? ' selected=selected' : '';?>>HELP + SFSS</option>
									</select>
								</div>
							</div>
							
						</div>
						
					</div>
					<br />
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="f_acc_name" class="col-lg-3 control-label">Account Name</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="f_acc_name" name="f_acc_name" value="<?=$staff['f_acc_name'];?>" tabindex="1" />
								</div>
							</div>
							<div class="form-group">
								<label for="f_bsb" class="col-lg-3 control-label">BSB</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="f_bsb" name="f_bsb" value="<?=$staff['f_bsb'];?>" tabindex="2" />
								</div>
							</div>
							<div class="form-group">
								<label for="f_acc_number" class="col-lg-3 control-label">Account Number</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" id="f_acc_number" name="f_acc_number" value="<?=$staff['f_acc_number'];?>" tabindex="3" />
								</div>
							</div>
                            <div class="form-group">
								<label class="col-lg-3 control-label">Employed As</label>
								<div class="col-lg-3">
									<div class="radio">
										<input type="radio" name="f_employed" value="0"<?=($staff['f_employed'] == 0) ? ' checked' : '';?> /> TFN
									</div>
								</div>
								<div class="col-lg-3">
									<div class="radio">
										<input type="radio" name="f_employed" value="1"<?=($staff['f_employed'] == 1) ? ' checked' : '';?> /> ABN
									</div>
								</div>
							</div>
                            
							<div class="form-group" id="f_tfn_number">
								<label for="f_tfn_1" class="col-lg-3 control-label">TFN Number</label>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_tfn_1" name="f_tfn_1" tabindex="4" value="<?=$staff['f_tfn_1'];?>" />
								</div>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_tfn_2" name="f_tfn_2" tabindex="5" value="<?=$staff['f_tfn_2'];?>" />
								</div>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_tfn_3" name="f_tfn_3" tabindex="6" value="<?=$staff['f_tfn_3'];?>" />
								</div>
							</div>
                            <div class="form-group" id="f_abn_number">
								<label for="f_tfn_1" class="col-lg-3 control-label">ABN Number</label>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_abn_1" name="f_abn_1" tabindex="7" value="<?=$staff['f_abn_1'];?>" />
								</div>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_abn_2" name="f_abn_2" tabindex="8" value="<?=$staff['f_abn_2'];?>" />
								</div>
								<div class="col-md-3">
									<input type="text" class="form-control" id="f_abn_3" name="f_abn_3" tabindex="9" value="<?=$staff['f_abn_3'];?>" />
								</div>
							</div>
                            <div class="form-group" id="f_gst">
								<label for="f_tfn_1" class="col-lg-3 control-label">Do you require GST?</label>
								<div class="col-md-6">
									<select name="f_require_gst" class="form-control auto-width">
										<option value="0" <?=($staff['f_require_gst']==0) ? ' selected=selected' : '';?>>NO</option>
										<option value="1" <?=($staff['f_require_gst']==1) ? ' selected=selected' : '';?>>YES</option>
									</select>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="super">
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-lg-4 control-label">Choice of superannuation fund</label>
								<div class="col-lg-4">
									<div class="radio">
										<input type="radio" name="s_choice" value="employer"<?=($staff['s_choice'] == 'employer') ? ' checked' : '';?> /> my employer's superannuation fund
									</div>
								</div>
								<div class="col-lg-4">
									<div class="radio">
										<input type="radio" name="s_choice" value="own"<?=($staff['s_choice'] == 'own') ? ' checked' : '';?> /> my own choice
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<br />
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_name" class="col-lg-4 control-label">Name</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_name" name="s_name" value="<?=$staff['s_name'];?>" />
								</div>
							</div>							
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_employee_id" class="col-lg-4 control-label">Employee ID number</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_employee_id" name="s_employee_id" value="<?=$staff['s_employee_id'];?>" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="s_tfn_1" class="col-lg-3 control-label">TFN Number</label>
								<div class="col-md-2">
									<input type="text" class="form-control" id="s_tfn_1" name="s_tfn_1" value="<?=($staff['s_tfn_1'] == '') ? $staff['f_tfn_1'] : $staff['s_tfn_1'];?>" />
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="s_tfn_2" name="s_tfn_2" value="<?=($staff['s_tfn_2'] == '') ? $staff['f_tfn_2'] : $staff['s_tfn_2'];?>" />
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="s_tfn_3" name="s_tfn_3" value="<?=($staff['s_tfn_3'] == '') ? $staff['f_tfn_3'] : $staff['s_tfn_3'];?>" />
								</div>
							</div>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-6">
							<div class="form-group<? //if(modules::run('common/check_super', $staff['s_fund_name'])) { echo ' has-success'; } else { echo '  has-warning'; } ?>">
								<label for="s_fund_name" class="col-lg-4 control-label">Super Fund Name</label>
								<div class="col-lg-8">
									<!--<input type="text" class="form-control" id="s_fund_name" name="s_fund_name" value="<?=$staff['s_fund_name'];?>" />-->
                                    <?=modules::run('common/dropdown_supers', 's_fund_name',$staff['s_fund_name']);?>

								</div>
							</div>
						</div>
						<div class="col-md-6">
							<? //if(!modules::run('common/check_super', $staff['s_fund_name'])) { echo '<span class="help-block"> &nbsp; &nbsp; Super fund name not found in our system</span>'; } ?>
						</div>
					</div>
					<div class="row" id="employer_choice">
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_product_id" class="col-lg-4 control-label">Super Product ID</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_product_id" name="s_product_id" value="<?=$staff['s_product_id'];?>" readonly="readonly"/>
								</div>
							</div>
							
							<div class="form-group">
								<label for="s_fund_phone" class="col-lg-4 control-label">Super Phone</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_phone" name="s_fund_phone" value="<?=$staff['s_fund_phone'];?>" readonly="readonly" />
								</div>
							</div>			
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_fund_website" class="col-lg-4 control-label">Super Fund Website</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_website" name="s_fund_website" value="<?=$staff['s_fund_website'];?>" readonly="readonly" />
								</div>
							</div>
						</div>						
					</div>
					
					<div class="row" id="own_choice">
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_membership" class="col-lg-4 control-label">Membership Number</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_membership" name="s_membership" value="<?=$staff['s_membership'];?>" />
								</div>
							</div>	
							
							<div class="form-group">
								<label for="s_fund_address" class="col-lg-4 control-label">Super Fund Address</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_address" name="s_fund_address" value="<?=$staff['s_fund_address'];?>" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="s_fund_postcode" class="col-lg-4 control-label">Postcode</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_postcode" name="s_fund_postcode" value="<?=$staff['s_fund_postcode'];?>" />
								</div>
							</div>
						</div>
						<div class="col-md-6">							
							<div class="form-group">
								<label for="s_fund_suburb" class="col-lg-4 control-label">Suburb</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_suburb" name="s_fund_suburb" value="<?=$staff['s_fund_suburb'];?>" />
								</div>
							</div>
							<div class="form-group">
								<label for="s_fund_website" class="col-lg-4 control-label">State</label>
								<div class="col-lg-8">
									<?=modules::run('common/dropdown_states', 's_fund_state', $staff['s_fund_state']);?>
								</div>
							</div>
						</div>						
					</div>
					
					
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">I have attached</label>
								<div class="col-lg-10">
									<ol type="a">
									<li>A letter from the trustee stating that this is a complying fund or retirement savings account (RSA) or, for a self managed superannuation fund, a copy of documentation from the ATO confirming the fund is regulated</li>
									<li>written evidence from the fund stating that they will accept contributions from my employer, and</li>
									<li>details about how my employer can make contributions to this fund.</li>
								</ol>					
								</div>
							</div>							
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label"></label>
								<div class="col-lg-10">
									<div class="row">
										<div class="col-md-1"><input type="checkbox" name="s_agree" value="1"<?=($staff['s_agree']) ? ' checked' : '';?> /> </div>
										<div class="col-md-11 label_checkbox">I have read and agreed to the above statements.</div>
									</div>
								</div>
							</div>				
						</div>					
					</div>						
				</div>
				
				<div class="tab-pane" id="availability">
					<br />
                    <div class="row">
						<div class="col-md-12">
							<h2> Your Availability </h2>
                            <p> Please let us know the times that you are available for work</p>
                            
                           <? //echo '<pre>'.print_r($staff_availability,true).'</pre>';?>
                            
                            <?=modules::run('common/set_availability','availability',$staff_availability);?>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="roles">
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Roles</label>
								<div class="col-lg-10">
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
					</div>
				</div>
				
				<div class="tab-pane" id="payrate">
					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Pay rate</label>
								<div class="col-lg-10">
									<? 
									$staff_payrates = array();
									if ($staff['payrates'])
									{
										$staff_payrates = json_decode($staff['payrates']);
									}
									$payrates = modules::run('attribute/payrate/get_payrates');
									foreach($payrates as $payrate) { ?>
									<div class="row">
										<div class="col-md-1"><input type="checkbox" name="payrates[]" value="<?=$payrate['payrate_id'];?>"<?=(in_array($payrate['payrate_id'], $staff_payrates)) ? ' checked' : '';?> /> </div>
										<div class="col-md-11 label_checkbox"><?=$payrate['name'];?></div>
										
										
									</div>
									<? } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="option">
					<br />
                    Options
				</div>
				
				<div class="tab-pane" id="location">
					<br />
                    <div class="row">
						<div class="col-md-12">
                        	To add locations that this staff can work in select from the drop down list
                            <br /><br />
							<div class="form-group">
								
                                <!--<label for="title" class="col-lg-2 control-label">Select Locations</label>-->
                                
								<!--<div class="col-lg-10">-->

                                    
									
									<?=modules::run('common/dropdown_location', 's_loc', $staff['locations']);?>
									<? 									
									$staff_locations = array();
									if ($staff['locations'])
									{
										$staff_locations = json_decode($staff['locations']);
										/*
										$locations = modules::run('attribute/location/get_locations');
										for ($i=0; $i<count($locations);$i = $i+2) { ?>
										<div class="row">
											<div class="col-md-1"><input type="checkbox" name="locations[]" value="<?=$locations[$i]['location_id'];?>"<?=(in_array($locations[$i]['location_id'], $staff_locations)) ? ' checked' : '';?> /> </div>
											<div class="col-md-4 label_checkbox"><?=$locations[$i]['state'] . ' - ' . $locations[$i]['name'];?></div>
											<? if (isset($roles[$i+1])) { ?>
											<div class="col-md-1"><input type="checkbox" name="locations[]" value="<?=$locations[$i+1]['location_id'];?>"<?=(in_array($locations[$i+1]['location_id'], $staff_locations)) ? ' checked' : '';?> /> </div>
											<div class="col-md-4 label_checkbox"><?=$locations[$i]['state'] . ' - ' . $locations[$i+1]['name'];?></div>
											<? } ?>
										</div>
										<? } */ ?>
                                    <? } ?>
								<!--</div>-->
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="setting">
					<br />
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="title" class="col-lg-4 control-label">Level Access</label>
								<div class="col-lg-8">
									<select class="form-control">
										<option>Staff</option>
										<option>Admin</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="title" class="col-lg-4 control-label">Conversations</label>
								<div class="col-lg-8">
									<select class="form-control">
										<option>Invited Conversations Only</option>
									</select>
								</div>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Induction Status</label>
								<div class="col-lg-10">
									<div class="alert alert-success media">
										<div class="pull-left">
											<i class="icon-ok"></i>
										</div>
										<div class="pull-right">
											<select class="form-control">
												<option>Induction Completed</option>
											</select>
										</div>
										<div class="media-body">
											<h4>Induction Completed</h4>
											<h6>Induction completed on 24/03/2013</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
                
				<div class="tab-pane" id="document">
					<br />
                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Document Name</label>
								<div class="col-lg-10">
									
								</div>
							</div>
						</div>
					</div>
					
				</div>
                
                <div class="tab-pane" id="picture">
					<div class="row">
						<div class="col-md-12">
                        	<h2> Your Images </h2>
                            <p> Upload photos of yourself so we have a visual refferance of you. 
                            	<br />Set your <b>primary profile image</b> by rolling over the images in your gallery and clicking the <i class="fa fa-heart"></i>
								<br />To <b>delete images</b>  roll over one of the images in your gallery and click the <i class="fa fa-times"></i>                        	
							</p>

                            <button type="button" class="btn btn-info" onclick="add_image(<?=$staff['staff_id']?>)"><i class="fa fa-upload"></i> Upload Image</button>
                            <br />
                            <br />
                            <div class="row">
                            	<div class="col-md-2" style="padding-left:0px;">
                                	<i class="fa fa-heart"></i> Profile Image <br /><br />
                                    <div class="profile_border">
                                    <? if($hero_photo){?> <img src="<?=base_url()?>uploads/staff/profile/<?=md5($staff['staff_id'])?>/thumbnail/<?=$hero_photo['name']?>"><? }else{?>
                                            <div class="no_photo">
                                                No Photo
                                            </div>
                                    <? } ?>
                                    </div>
                                    
                                </div>
                                <div class="col-md-10">
                                	<i class="fa fa-picture-o"></i> Your Gallery <br /><br />
                                     <? if($photos){?>
                                    <div id="carousel" class="flexslider gallery_staff">
                                      <ul class="slides popup-gallery">
                                       <?
                                            foreach($photos as $photo){
                                                $photo_src_full = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/'.$photo['name'];                                    
                                                $thumb_src = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/thumbnail/'.$photo['name'];
                                            ?>
                                                <li >
                                                	<a title="<?=$photo['name'];?>" href="<?=$photo_src_full?>"><img style="width:auto!important;" src="<?=$thumb_src;?>" /></a>
                                                	<div align="center" class="action_image" > 
                                                    	<a href="#" onclick="set_hero(<?=$photo['id']?>)"><div class="action_icon"><i class="fa fa-heart" <? if($photo['hero']==1){echo "style='color:#f00;'";}?> ></i></div></a>
                                                        <a href="#" onclick="delete_photo(<?=$photo['id']?>)"><div class="action_icon"><i class="fa fa-times"></i></div> </a>
                                                    </div>
                                                </li>
                                            <?
                                            }?>
                                         
                                        <!-- items mirrored twice, total of 12 -->
                                      </ul>
                                    </div>
                                    <? }?>
                                    <div style="clear:both;"></div>
                                </div>
                                
                            </div>
                            
						</div>
					</div>
					
				</div>
				
			</div>
			
                    <!-- Submit button -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-lg-offset-4 col-lg-8">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update Staff</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                </form>			
			
  
	</div>
</div>


<style>
.action_image{
	height: 220px;position: absolute;top: 0px;width: 220px;background:#000; opacity:0.5; display:none;
}
.action_image :hover{display:block;line-height:35px;}
.gallery_staff{border:1px solid #cdcdcd; padding:10px!important; padding-left:25px!important; padding-right:25px!important; border-radius:4px; margin-bottom:20px!important;}
.profile_border{border:1px solid #cdcdcd; padding:10px;border-radius:4px; background:#fff;width:-moz-max-content}
.no_photo{width:200px; height:200px; border:1px solid #000; color:#000; background:#c3c3c3; text-align:center; line-height:200px;}
.popup-gallery li:hover .action_image{ display:block;}
.action_icon{border:1px solid #ccc;background:#f9f9f9;width:35px; height:35px;text-align:center;line-height:35px; float:right;}
</style>

<!-- Add Image Modal -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="editVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Image</h4>
			</div>
			
			<div class="modal-body">
				<?=modules::run('common/upload_picture', 'staff_id',$staff['staff_id']);?>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function(){		
	
	$('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 230,
		itemMargin: 5,
		asNavFor: '#slider'
    });
	
	$('#navStaff a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	// $('#navStaff a[href="#super"]').tab('show');
	
	
	
	
	load_s_choice();
	load_senior_couple_status();
	load_help_variation();
	load_f_employed();
	$('input[name="s_choice"]').change(function(){
		load_s_choice();
	});
	$('input[name="f_tax_offset"]').change(function(){
		load_senior_couple_status();
	});
	$('input[name="f_help_debt"]').change(function(){
		load_help_variation();
	})
	$('input[name="f_employed"]').change(function(){
		load_f_employed();
	})
	
	//$( "#s_fund_name" ).autocomplete({
		//source: availableTags
	//});
	//var availableTags = [
	//<? //=modules::run('common/list_supers');?>
	//];
});

function load_senior_couple_status()
{
	var is_tax_offset = $('input[name="f_tax_offset"]:checked').val();
	
	if (is_tax_offset == 1) {
		$('#f_senior_status').show();
	} else
	{
		$('#f_senior_status').hide();
	}
}
function load_help_variation()
{
	var is_help_debt = $('input[name="f_help_debt"]:checked').val();
	
	if (is_help_debt == 1) {
		$('#f_help_variation').show();
	} else
	{
		$('#f_help_variation').hide();
	}
}
function load_f_employed()
{
	var is_f_empoyed = $('input[name="f_employed"]:checked').val();
	
	if (is_f_empoyed == 1) {
		$('#f_tfn_number').show();
		$('#f_abn_number').show();
		$('#f_gst').show();
	} else
	{
		$('#f_tfn_number').show();
		$('#f_abn_number').hide();
		$('#f_gst').hide();
	}
}
function load_s_choice()
{
	var s_choice = $('input[name="s_choice"]:checked').val();
	if (s_choice == "own") {
		$('#own_choice').show();
		$('input[name="s_fund_name"]').prop('readonly',false);
		$('#employer_choice').hide();
	}
	else
	{		
		$('#employer_choice').show();
		$('input[name="s_fund_name"]').attr('readonly','readonly');
		$('#own_choice').hide();
	}
}

function set_hero(id)
{
	$.ajax({
		url: '<?=base_url()?>common/setherophoto/',
		type: 'POST',
		data: ({staff_id:<?=$staff['staff_id']?>,photo_id:id}),
		dataType: "html",
		success: function(html) {			
			location.reload();
		}
	})		
}

function delete_photo(id)
{

	$.ajax({
		url: '<?=base_url()?>common/deletephoto/',
		type: 'POST',
		data: ({staff_id:<?=$staff['staff_id']?>,photo_id:id}),
		dataType: "html",
		success: function(html) {			
			location.reload();
		}
	})		
}
function add_image()
{
	$('#addImage').modal('show');
}
</script>

<link rel="stylesheet" href="<?=base_url()?>assets/js/flexjs/flexslider.css" type="text/css" media="screen" />
<script src="<?=base_url()?>assets/js/flexjs/modernizr.js"></script>
<script defer src="<?=base_url()?>assets/js/flexjs/jquery.flexslider.js"></script>             
<!-- Syntax Highlighter -->
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shCore.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shBrushXml.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/flexjs/shBrushJScript.js"></script>

<!-- Optional FlexSlider Additions -->
<script src="<?=base_url()?>assets/js/flexjs/jquery.easing.js"></script>
<script src="<?=base_url()?>assets/js/flexjs/jquery.mousewheel.js"></script>
<!--<script defer src="<?=base_url()?>assets/js/flexjs/demo.js"></script>   -->
