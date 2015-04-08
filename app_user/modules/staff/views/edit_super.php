<div class="staff-profile-detail-box">
	<h2> Super Details </h2>
</div>
<form class="form-horizontal" role="form" id="form_update_staff_super">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Superannuation choice</label>
		<div class="col-md-4">
			<div class="radio">
				<input type="radio" name="s_choice" id="employer" value="employer"<?=($staff['s_choice'] == 'employer') ? ' checked' : '';?> /> my employer's superannuation fund
			</div>
		</div>
		<div class="col-md-2">
			<div class="radio">
				<input type="radio" name="s_choice" id="own" value="own"<?=($staff['s_choice'] == 'own') ? ' checked' : '';?> /> my own choice
			</div>
		</div>
	</div>
</div>
<? $platform = $this->config_model->get('accounting_platform');
if ($platform == 'xero') {
	$id = modules::run('setting/superinformasi', 'super_fund_external_id');
	if ($id) {
		$super_fund = modules::run('api/xero/get_superfund', $id);
	}
?>
<div class="row" id="employer_choice">
	<? if (isset($super_fund)) { ?>
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<label class="col-md-4 control-label">
			<?=$super_fund['Name'];?>
			<? if (isset($super_fund['EmployerNumber'])) { ?>
			<br />Employer Membership Number: <?=$super_fund['EmployerNumber'];?>
			<? } ?>
		</label>
	</div>
	<? } else { ?>
	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			No company super fund is currently set up.
			<? if(!modules::run('auth/is_staff')){ ?>
			<br />To set up a default company super fund go to "System Settings" > "Company Profile"
			<? } ?>
		</div>
	</div>
	<? } ?>
</div>
<div class="row" id="own_choice">
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_xero_super_fund', 's_external_id', $staff['s_external_id']);?>
		</div>
		<div class="col-md-6">
			<span class="help-block">If you cant find your super fund in the list please <a href="<?=base_url();?>support">contact us</a></span>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="s_employee_id" class="col-md-2 control-label">Staff Membership Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_employee_id" name="s_employee_id" value="<?=$staff['s_employee_id'];?>" />
		</div>
	</div>
</div>


<? } else if ($platform == 'myob') {
	$id = modules::run('setting/superinformasi', 'super_fund_external_id');
	if ($id) {
		$super_fund = modules::run('api/myob/connect', 'read_super_fund~' . $id);
	}
?>
<div class="row" id="employer_choice">
	<? if (isset($super_fund)) { ?>
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<label class="col-md-4 control-label">
			<?=$super_fund->Name;?>
			<? if ($super_fund->EmployerMembershipNumber) { ?>
			<br />Employer Membership Number: <?=$super_fund->EmployerMembershipNumber;?>
			<? } ?>
			<? if ($super_fund->PhoneNumber) { ?>
			<br />Phone Number: <?=$super_fund->PhoneNumber;?>
			<? } ?>
			<? if ($super_fund->Website) { ?>
			<br />Website: <?=$super_fund->Website;?>
			<? } ?>
		</label>
	</div>
	<? } else { ?>
	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			No company super fund is currently set up.
			<? if(!modules::run('auth/is_staff')){ ?>
			<br />To set up a default company super fund go to "System Settings" > "Company Profile"
			<? } ?>
		</div>
	</div>
	<? } ?>
</div>


<div class="row" id="own_choice">
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_myob_super_fund', 's_external_id', $staff['s_external_id']);?>
		</div>
		<div class="col-md-6">
			<span class="help-block">If you cant find your super fund in the list please <a href="<?=base_url();?>support">contact us</a></span>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="s_employee_id" class="col-md-2 control-label">Staff Membership Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_employee_id" name="s_employee_id" value="<?=$staff['s_employee_id'];?>" />
		</div>
	</div>
</div>

<? } else {
#
	$super_fund = modules::run('setting/superinformasi', 'super_fund_name');
	$super_product_id = modules::run('setting/superinformasi', 'super_product_id');
	$super_fund_phone = modules::run('setting/superinformasi', 'super_fund_phone');
	$super_fund_website = modules::run('setting/superinformasi', 'super_fund_website');
	?>

<div class="row" id="employer_choice">
	<? if ($super_fund) { ?>
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<label class="col-md-4 control-label">
			<?=$super_fund;?>
			<? if ($super_product_id) { ?>
			<br />Employer Membership Number: <?=$super_product_id;?>
			<? } ?>
			<? if ($super_fund_phone) { ?>
			<br />Phone Number: <?=$super_fund_phone;?>
			<? } ?>
			<? if ($super_fund_website) { ?>
			<br />Website: <?=$super_fund_website;?>
			<? } ?>
		</label>
	</div>
	<? } else { ?>
	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			No company super fund is currently set up.
			<? if(!modules::run('auth/is_staff')){ ?>
			<br />To set up a default company super fund go to "System Settings" > "Company Profile"
			<? } ?>
		</div>
	</div>
	<? } ?>
</div>


<div class="row" id="own_choice">
	<div class="form-group">
		<label class="col-md-2 control-label">Super Fund</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_supers', 's_external_id', $staff['s_external_id']);?>
		</div>
		<div class="col-md-6">
			<span class="help-block">If you cant find your super fund in the list please <a href="<?=base_url();?>support">contact us</a></span>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="s_employee_id" class="col-md-2 control-label">Staff Membership Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_employee_id" name="s_employee_id" value="<?=$staff['s_employee_id'];?>" />
		</div>
	</div>
</div>



<!-- <div class="row">
	<div class="form-group">
		<label for="s_name" class="col-md-2 control-label">Name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_name" name="s_name" value="<?=$staff['s_name'];?>" />
		</div>
		<label for="s_employee_id" class="col-md-2 control-label">Employee ID number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_employee_id" name="s_employee_id" value="<?=$staff['s_employee_id'];?>" />
		</div>
	</div>


	<div class="form-group<? //if(modules::run('common/check_super', $staff['s_fund_name'])) { echo ' has-success'; } else { echo '  has-warning'; } ?>">
		<label for="s_fund_name" class="col-md-2 control-label">Super Fund Name</label>
		<div class="col-md-4">
            <?=modules::run('common/dropdown_supers', 's_fund_name',($staff['s_choice'] == 'own') ? $staff['s_fund_name'] : modules::run('setting/superinformasi', 'super_fund_name',''));?>

		</div>
		<div class="col-md-6">
			<? //if(!modules::run('common/check_super', $staff['s_fund_name'])) { echo '<span class="help-block"> &nbsp; &nbsp; Super fund name not found in our system</span>'; } ?>
		</div>
	</div>
</div> -->


<!-- <div class="row" id="employer_choice">
	<div class="form-group">
		<label for="s_product_id" class="col-md-2 control-label">Super Product ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_product_id" name="s_product_id" value="<?=modules::run('setting/superinformasi', 'super_product_id','');?>" readonly/>
		</div>
		<label for="s_fund_website" class="col-md-2 control-label">Super Fund Website</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_website" name="s_fund_website" value="<?=modules::run('setting/superinformasi', 'super_fund_website','');?>" readonly />
		</div>
	</div>

	<div class="form-group">
		<label for="s_fund_phone" class="col-md-2 control-label">Super Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_phone" name="s_fund_phone" value="<?=modules::run('setting/superinformasi', 'super_fund_phone','');?>" readonly />
		</div>
	</div>
</div> -->

<!-- <div class="row" id="own_choice">
	<div class="form-group">
		<label for="s_membership" class="col-md-2 control-label">Membership Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_membership" name="s_membership" value="<?=$staff['s_membership'];?>" />
		</div>

		<label for="s_fund_suburb" class="col-md-2 control-label">Suburb</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_suburb" name="s_fund_suburb" value="<?=$staff['s_fund_suburb'];?>" />
		</div>
	</div>

	<div class="form-group">
		<label for="s_fund_address" class="col-md-2 control-label">Super Fund Address</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_address" name="s_fund_address" value="<?=$staff['s_fund_address'];?>" />
		</div>

		<label for="s_fund_website" class="col-md-2 control-label">State</label>
		<div class="col-md-4">
			<?=modules::run('common/field_select_states', 's_fund_state', $staff['s_fund_state']);?>
		</div>
	</div>

	<div class="form-group">
		<label for="s_fund_postcode" class="col-md-2 control-label">Postcode</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_postcode" name="s_fund_postcode" value="<?=$staff['s_fund_postcode'];?>" />
		</div>
	</div>
</div> -->
<? } ?>
<br />
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">I have attached</label>
		<div class="col-md-10">
			<ol type="a" class="super_attached">
			<li>A letter from the trustee stating that this is a complying fund or retirement savings account (RSA) or, for a self managed superannuation fund, a copy of documentation from the ATO confirming the fund is regulated</li>
			<li>Written evidence from the fund stating that they will accept contributions from my employer, and</li>
			<li>Details about how my employer can make contributions to this fund.</li>
		</ol>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-5">
        	<div class="checkbox">
				<input type="checkbox" name="s_agree" value="1"<?=($staff['s_agree']) ? ' checked' : '';?> /> I have read and agreed to the above statements.
            </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<div class="alert alert-success hide" id="msg-update-super"><i class="fa fa-check"></i> &nbsp; Staff super details has been updated successfully!</div>
            <div class="alert alert-danger hide" id="msg-update-super-error"><i class="fa fa-times"></i> &nbsp; <span id="super-update-error-msg"></span></div>
			<button type="button" class="btn btn-core" id="btn_update_super" data-loading-text="Updating staff..."><i class="fa fa-save"></i> Update Super Details</button>
		</div>
	</div>
</div>
<script>
$(function(){
	load_s_choice();

	$('input[name="s_choice"]').change(function(){
		load_s_choice();
	});

	$('#btn_update_super').click(function(){
		var btn = $(this);
		btn.button('loading');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_super",
			data: $('#form_update_staff_super').serialize(),
			success: function(data) {
				btn.button('reset');
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#super-update-error-msg').html(data.msg);
					$('#msg-update-super-error').removeClass('hide');
				}else{
					$('#msg-update-super-error').addClass('hide');
					$('#msg-update-super').removeClass('hide');
					setTimeout(function(){
						$('#msg-update-super').addClass('hide');
					}, 2000);
				}
			}
		})
	})
})
function load_s_choice()
{
	var employee_super_name = '<?=modules::run('setting/superinformasi', 'super_fund_name','')?>';
	var s_choice = $('input[name="s_choice"]:checked').val();
	if (s_choice == "own") {
		$('#own_choice').show();
		$('input[name="s_fund_name"]').prop('readonly',false);
		$('#own').prop('checked',true);
		$('#employer_choice').hide();
		//$('input[name="s_fund_name"]').val('')
	}
	else
	{
		$('#employer_choice').show();
		$('input[name="s_fund_name"]').attr('readonly','readonly');
		$('#employer').prop('checked',true);
		$('#own_choice').hide();
		$('input[name="s_fund_name"]').val(employee_super_name);
	}
}
</script>
