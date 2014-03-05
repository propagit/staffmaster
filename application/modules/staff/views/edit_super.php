<div class="staff-profile-detail-box">
	<h2> Super Details </h2>
	<p> Staff can choose the "Super" </p>
</div>
<form class="form-horizontal" role="form" id="form_update_staff_super">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Choice of superannuation fund</label>
		<div class="col-md-2">
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
<div class="row">
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


	<div class="form-group">
		<label for="s_tfn_1" class="col-md-2 control-label">TFN Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_tfn" name="s_tfn" value="<?=($staff['s_tfn'] == '') ? $staff['f_tfn'] : $staff['s_tfn'];?>" />
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
</div>


<div class="row" id="employer_choice">
	<div class="form-group">
		<label for="s_product_id" class="col-md-2 control-label">Super Product ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_product_id" name="s_product_id" value="<?=modules::run('setting/superinformasi', 'super_product_id','');?>" readonly="readonly"/>
		</div>
		<label for="s_fund_website" class="col-md-2 control-label">Super Fund Website</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_website" name="s_fund_website" value="<?=modules::run('setting/superinformasi', 'super_fund_website','');?>" readonly="readonly" />
		</div>
	</div>
		
	<div class="form-group">
		<label for="s_fund_phone" class="col-md-2 control-label">Super Phone</label>
		<div class="col-md-4">
			<input type="text" class="form-control" id="s_fund_phone" name="s_fund_phone" value="<?=modules::run('setting/superinformasi', 'super_fund_phone','');?>" readonly="readonly" />
		</div>
	</div>						
</div>
					
<div class="row" id="own_choice">
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
</div>				
<br />
<div class="row">
	<div class="form-group">
		<label for="title" class="col-md-2 control-label">I have attached</label>
		<div class="col-md-10">
			<ol type="a" class="super_attached">
			<li>A letter from the trustee stating that this is a complying fund or retirement savings account (RSA) or, for a self managed superannuation fund, a copy of documentation from the ATO confirming the fund is regulated</li>
			<li>written evidence from the fund stating that they will accept contributions from my employer, and</li>
			<li>details about how my employer can make contributions to this fund.</li>
		</ol>					
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-3">
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
			<button type="button" class="btn btn-core" id="btn_update_super"><i class="fa fa-save"></i> Update Super Details</button>
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
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_super",
			data: $('#form_update_staff_super').serialize(),
			success: function(html) {
				$('#msg-update-super').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-super').addClass('hide');
				}, 2000);
			}
		})
	})
})
function load_s_choice()
{
	var s_choice = $('input[name="s_choice"]:checked').val();
	if (s_choice == "own") {
		$('#own_choice').show();
		$('input[name="s_fund_name"]').prop('readonly',false);
		$('#own').prop('checked',true);
		$('#employer_choice').hide();
		$('input[name="s_fund_name"]').val('')
	}
	else
	{		
		$('#employer_choice').show();
		$('input[name="s_fund_name"]').attr('readonly','readonly');
		$('#employer').prop('checked',true);
		$('#own_choice').hide();
	}
}
</script>