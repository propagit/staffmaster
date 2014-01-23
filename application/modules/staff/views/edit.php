<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/rating/jRating.jquery.css" media="screen" />
<!-- jQuery files -->
<!--<script type="text/javascript" src="<?=base_url()?>assets/js/rating/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/rating/jRating.jquery.js"></script>-->
<script type="text/javascript">
//var $j = jQuery.noConflict();
jQuery(document).ready(function(){
      // simple jRating call
     /* $(".basic").jRating();
 
      // more complex jRating call
      $(".basic").jRating({
         step:true,
         length : 20, // nb of stars
         onSuccess : function(){
           alert('Success : your rate has been saved :)');
         }
       });
 
      // you can rate 3 times ! After, jRating will be disabled
      $(".basic").jRating({
         canRateAgain : true,
         nbRates : 3
       });
 */
      // get the clicked rate !
	/*jQuery(".basic").jRating({
		onClick : function(element,rate) {
	 	//alert(rate);
	 	jQuery('#rating').val(rate); 
		}
	});*/
	
});
</script>

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
		</ul>
		<br />
		
		
		<p>Please note <span class="required">**</span> denotes a required field</p>
		<form id="edit_form" class="form-horizontal" role="form" method="post" action="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>" onsubmit="">
		<input type="hidden" name="tab_id" id="tab_id" />
		<br />
		
			<div class="tab-content">
				<div class="tab-pane active" id="personal">
	
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
							<div class="form-group">
								<label for="email_address" class="col-lg-4 control-label">Email <span class="required">**</span></label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="email_address" name="email_address" value="<?=$staff['email_address'];?>" disabled />
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
									<!--
                                    <div class="rating pull-left">
										<span class="star"></span>
										<span class="star"></span>
										<span class="star"></span>
										<span class="star"></span>
										<span class="star"></span>
									</div>
                                    -->
                                    <div class="exemple"> 
                                       <!-- in this exemple, 12 is the average and 1 is the id of the line to update in DB -->
                                       <div class="basic" data-average="<?=$staff['rating']?>" data-id="1"></div>  
                                       <input type="hidden" name="rating" id="rating" value="<?=$staff['rating']?>">                                   
                                    </div>
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
										<option value="None">None</option>
										<option value="Member of couple">Member of couple</option>
										<option value="Member of illness-separated couple">Member of illness-separated couple</option>
										<option value="Single">Single</option>
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
										<option value="None">HELP</option>
										<option value="Member of couple">SFSS</option>
										<option value="Member of illness-separated couple">HELP + SFSS</option>
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
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="super">
				
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
									<input type="text" class="form-control" id="s_tfn_1" name="s_tfn_1" value="<?=$staff['s_tfn_1'];?>" />
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="s_tfn_2" name="s_tfn_2" value="<?=$staff['s_tfn_2'];?>" />
								</div>
								<div class="col-md-2">
									<input type="text" class="form-control" id="s_tfn_3" name="s_tfn_3" value="<?=$staff['s_tfn_3'];?>" />
								</div>
							</div>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-6">
							<div class="form-group<? if(modules::run('common/check_super', $staff['s_fund_name'])) { echo ' has-success'; } else { echo '  has-warning'; } ?>">
								<label for="s_fund_name" class="col-lg-4 control-label">Super Fund Name</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_name" name="s_fund_name" value="<?=$staff['s_fund_name'];?>" />
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<? if(!modules::run('common/check_super', $staff['s_fund_name'])) { echo '<span class="help-block"> &nbsp; &nbsp; Super fund name not found in our system</span>'; } ?>
						</div>
					</div>
					<div class="row" id="employer_choice">
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_product_id" class="col-lg-4 control-label">Super Product ID</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_product_id" name="s_product_id" value="<?=$staff['s_product_id'];?>" />
								</div>
							</div>
							
							<div class="form-group">
								<label for="s_fund_phone" class="col-lg-4 control-label">Super Phone</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_phone" name="s_fund_phone" value="<?=$staff['s_fund_phone'];?>" />
								</div>
							</div>			
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="s_fund_website" class="col-lg-4 control-label">Super Fund Website</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" id="s_fund_website" name="s_fund_website" value="<?=$staff['s_fund_website'];?>" />
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
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="title" class="col-lg-2 control-label">Availability</label>
								<div class="col-lg-10">
									<? 
									$staff_avail = array();
									if ($staff['availability'])
									{
										$staff_avail = json_decode($staff['availability']);
									}
									$avail = modules::run('attribute/availability/get_availability');
									foreach($avail as $one) { ?>
									<div class="row">
										<div class="col-md-1"><input type="checkbox" name="availability[]" value="<?=$one['availability_id'];?>"<?=(in_array($one['availability_id'], $staff_avail)) ? ' checked' : '';?> /> </div>
										<div class="col-md-11 label_checkbox"><?=$one['name'];?></div>
										
										
									</div>
									<? } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="roles">
					
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
					Options
				</div>
				
				<div class="tab-pane" id="location">
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

<script>
$(function(){
	 var availableTags = [
	<?=modules::run('common/list_supers');?>
	];
	$( "#s_fund_name" ).autocomplete({
		source: availableTags
	});
	
	$('#navStaff a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});
	// $('#navStaff a[href="#super"]').tab('show');
	
	load_s_choice();
	load_senior_couple_status();
	load_help_variation();
	$('input[name="s_choice"]').change(function(){
		load_s_choice();
	});
	$('input[name="f_tax_offset"]').change(function(){
		load_senior_couple_status();
	});
	$('input[name="f_help_debt"]').change(function(){
		load_help_variation();
	})
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
function load_s_choice()
{
	var s_choice = $('input[name="s_choice"]:checked').val();
	if (s_choice == "own") {
		$('#own_choice').show();
		$('#employer_choice').hide();
	}
	else
	{		
		$('#employer_choice').show();
		$('#own_choice').hide();
	}
}

</script>