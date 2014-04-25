<div class="staff-profile-detail-box">
	<h2> Financial Details </h2>
</div>
<form class="form-horizontal" role="form" id="form_update_staff_financial">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group">
		<label for="f_acc_name" class="col-md-4 control-label">Account Name</label>
		<div class="col-md-3">
			<input type="text" class="form-control" id="f_acc_name" name="f_acc_name" value="<?=$staff['f_acc_name'];?>" tabindex="1" />
		</div>
	</div>
	<div class="form-group">
		<label for="f_bsb" class="col-md-4 control-label">BSB</label>
		<div class="col-md-3">
			<input type="text" class="form-control" id="f_bsb" name="f_bsb" value="<?=$staff['f_bsb'];?>" tabindex="2" />
		</div>
	</div>
	<div class="form-group">
		<label for="f_acc_number" class="col-md-4 control-label">Account Number</label>
		<div class="col-md-3">
			<input type="text" class="form-control" id="f_acc_number" name="f_acc_number" value="<?=$staff['f_acc_number'];?>" tabindex="3" />
		</div>
	</div>
    <div class="form-group">
		<label class="col-md-4 control-label">Employed As</label>
		<div class="col-md-1">
			<div class="radio">
				<input type="radio" name="f_employed" value="1" <?=($staff['f_employed'] == 1) ? ' checked' : '';?> /> TFN
			</div>
		</div>
		<div class="col-md-1">
			<div class="radio">
				<input type="radio" name="f_employed" value="2" <?=($staff['f_employed'] == 2) ? ' checked' : '';?> /> ABN
			</div>
		</div>
	</div>
</div>
<div class="row">                     
	<div class="form-group" id="f_tfn_number">
		<label for="f_tfn_1" class="col-md-4 control-label">TFN Number</label>
		<div class="col-md-3">
			<input type="text" class="form-control" id="f_tfn" name="f_tfn" tabindex="4" value="<?=$staff['f_tfn'];?>" />
		</div>
	</div>
    <div class="form-group" id="f_abn_number">
		<label for="f_tfn_1" class="col-md-4 control-label">ABN Number</label>
		<div class="col-md-3">
			<input type="text" class="form-control" id="f_abn" name="f_abn" tabindex="7" value="<?=$staff['f_abn'];?>" />
		</div>
	</div>
    <div class="form-group" id="f_gst">
		<label for="f_tfn_1" class="col-md-4 control-label">Do you require GST?</label>
		<div class="col-md-3">
			<?
				$array = array(
					array('value' => '0', 'label' => 'No'),
					array('value' => '1', 'label' => 'Yes')
				);
				echo modules::run('common/field_select', $array, 'f_require_gst', $staff['f_require_gst']);
			?>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-lg-4 control-label">Are you an Australian Resident?</label>
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
		<label class="col-lg-4 control-label">Do you want to claim the tax free threshold?</label>
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
		<label class="col-lg-4 control-label">Do you want to claim the Senior Australian Tax offset?</label>
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
		<label class="col-lg-4 control-label">Your senior couple status <span class="required">**</span></label>
		<div class="col-lg-3">
			<?
				$array = array(
					array('value' => 'None', 'label' => 'None'),
					array('value' => 'Member of couple', 'label' => 'Member of couple'),
					array('value' => 'Member of illness-separated couple', 'label' => 'Member of illness-separated couple'),
					array('value' => 'Single', 'label' => 'Single')
				);
				echo modules::run('common/field_select', $array, 'f_senior_status', $staff['f_senior_status']);
			?>
		</div>
	</div>
							
	<div class="form-group">
		<label class="col-lg-4 control-label">Do you have a HELP (higher education loan program) debt?</label>
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
		<label class="col-lg-4 control-label">Your HELP variation <span class="required">**</span></label>
		<div class="col-lg-3">
			<?
				$array = array(
					array('value' => 'HELP', 'label' => 'HELP'),
					array('value' => 'SFSS', 'label' => 'SFSS'),
					array('value' => 'HELP + SFSS', 'label' => 'HELP + SFSS')
				);
				echo modules::run('common/field_select', $array, 'f_help_variation', $staff['f_help_variation']);
			?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-4 col-lg-offset-4">
			<div class="alert alert-success hide" id="msg-update-financial"><i class="fa fa-check"></i> &nbsp; Staff financial details has been updated successfully!</div>
			<button type="button" class="btn btn-core" id="btn_update_financial"><i class="fa fa-save"></i> Update Financial Details</button>
		</div>
	</div>
</div>

<script>
$(function(){
	load_senior_couple_status();
	load_help_variation();
	load_f_employed();
	$('input[name="f_tax_offset"]').change(function(){
		load_senior_couple_status();
	});
	$('input[name="f_help_debt"]').change(function(){
		load_help_variation();
	});
	$('input[name="f_employed"]').change(function(){
		load_f_employed();
	});
	$('#btn_update_financial').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_financial",
			data: $('#form_update_staff_financial').serialize(),
			success: function(html) {
				$('#msg-update-financial').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-financial').addClass('hide');
				}, 2000);
			}
		})
	})
})
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
		$('#f_tfn_number').hide();
		$('#f_abn_number').show();
		$('#f_gst').hide();
	}
}
</script>